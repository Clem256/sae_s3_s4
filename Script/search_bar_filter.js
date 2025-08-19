document.getElementById('btn-tous').addEventListener('click', function () {
    document.getElementById('user-results').style.display = 'block';
    document.getElementById('game-results').style.display = 'block';
});

document.getElementById('btn-jeux').addEventListener('click', function () {
    document.getElementById('user-results').style.display = 'none';
    document.getElementById('game-results').style.display = 'block';
});

document.getElementById('btn-utilisateurs').addEventListener('click', function () {
    document.getElementById('user-results').style.display = 'block';
    document.getElementById('game-results').style.display = 'none';
});