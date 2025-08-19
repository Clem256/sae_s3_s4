<?php
session_start();

function creergame($id, $nom, $image_url): array
{
    $game = [];
    $game[$id] = new Game($id, $nom, $image_url);
    return $game;
}

function refresh_page(): void
{
    $URI = $_SERVER['REQUEST_URI'];
    header("Location: $URI");
}

function is_user_connected(): bool
{
    return isset($_SESSION['pseudo']);
}
if (!isset($_SESSION['unite_temps'])) {
    $_SESSION['unite_temps'] = 'format1';
}
if (!isset($_SESSION['format_date'])) {
    $_SESSION['format_date'] = 'format1';
}

function format_igt($time, $unite_temps): string
{
    // Vérifie si l'entrée est déjà une chaîne au format HH:MM:SS
    if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $time)) {
        if ($unite_temps == 'format1') {
            // Convertit en texte lisible (ex : "1 h, 23 m, 45 s")
            [$hours, $minutes, $seconds] = explode(':', $time);
            return sprintf('%d h, %d m, %d s', $hours, $minutes, $seconds);
        } elseif ($unite_temps == 'format2') {
            // Retourne le format HH:MM:SS
            return $time;
        }
    }

    // Si l'entrée est un nombre, utilise le formatage en secondes
    $time = intval($time);
    return gmdate('H:i:s', $time); // Format par défaut
}


function format_date($date, $format_date)
{
    $res = strtotime($date);
    if (!$res) {
        return 'Date invalide'; // Retourne un message d'erreur si la date est invalide
    }
    switch ($format_date) {
        case 'format1':
            return date('d/m/Y', $res);
        case 'format2':
            return date('Y/m/d', $res);
        case 'format3':
            return date('d F Y', $res);
        default:
            return date('d/m/Y', $res); // Format par défaut
    }
}

