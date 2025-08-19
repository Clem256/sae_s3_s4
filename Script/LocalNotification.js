console.log("LocalNotification.js chargé");

document.addEventListener('DOMContentLoaded', function () {
    if (!Notification) {
        alert('Le navigateur ne supporte pas les notifications.');
    } else if (Notification.permission !== 'granted') {
        Notification.requestPermission();
    }

    const localNotifButton = document.getElementById("localNotif");
    if (localNotifButton) {
        localNotifButton.addEventListener('click', function () {
            notifier();
        });
    } else {
        // console.error('Element non trouver');
    }

    const mailNotifButton = document.getElementById("mailNotif");
    if (mailNotifButton) {
        mailNotifButton.addEventListener('click', function () {
        });
    } else {
        // console.error('Element non trouver');
    }
});

function notifier() {
    if (Notification.permission !== 'granted') {
        Notification.requestPermission().then(function (permission) {
            if (permission === 'granted') {
                sendNotification();
            } else {
                alert("Permission refusée");
            }
        });
    } else {
        sendNotification();
    }
}

function sendNotification() {
    const notification = new Notification('Bonjour !');
    notification.onclick = function () {
        window.open('');
    };
}