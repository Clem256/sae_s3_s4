console.log('notif ok');
const permission = document.getElementById('push-permission');
if(!permission||!('Notification' in window)||!('serviceWorker' in navigator)||Notification.permission!=='default'){

}
const button= document.createElement('button');
button.innerHTML='Activer les notifications';
permission.appendChild(button);
button.addEventListener('click',askPermission);



//demande la permission à l'utilisateur de lui envoyer des notifs
async function askPermission(){
    await Notification.requestPermission(function () {
        if (Notification.permission === "granted") {
            //si jamais il accepte alors on peut lui envoyer des notifs
            register_sw();
        } else {
            console.log("Notification not granted");
        }


    })
}

async function getPublicKey(){
    const key = await fetch("./vapidPublicKey",{
        method:"GET",
        header:{
            Accept:"application/json"
        }})
        .then(response => response.json())
    return key;
}


//enregistrement du service-worker
async function register_sw(){
    const registration = await navigator.serviceWorker.register("service-worker.js");
    let subscription = registration.pushManager.getSubscription()

    if(subscription){
        console.log(subscription);
    }

    //abonne l'utilisateur
    subscription = await registration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: await getPublicKey(),
    })
    await saveSubscription(subscription);

}


async function  saveSubscription(subscription){
    const key = await fetch("./push/subscribe",{
        method:"post",
        header:{
            Accept:"application/json"
        },
        body: JSON.stringify(subscription)})


}


















/* test précédent avec la doc
    .then((registration)=>{
        return registration.pushManager
        .getSubscription()
        //enregistrement
        .then(async(subscription)=>{
            if(subscription){
                return subscription
            }
        })
        //abonnement
        .then(async(subscription)=>{
            //recupère clé publique du serv et convertit la rep en txt
            const reponse = await fetch("./vapidPublicKey");
            const vapidPublicKey = await reponse.text();
            const VapidKeyConverted = urlBase64toUInt8Array(vapidPublicKey);
            //abonne l'utilisateur
            registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: convertedVapidKey,
        });

            fetch("./register", {
                method: "post",
                headers: {
                "Content-type": "application/json",
                },
                body: JSON.stringify({ subscription }),
            });

        });
    });



//envoi de la notif
if (accepte){
    document.getElementById('sendNotification').addEventListener('click', function (event) {
        event.preventDefault(); // Empêche l'envoi du formulaire pour tester la notification
        let notif = createNotif("Notif", {
            body: "Test notif",
            icon: "https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png"
        });
        notif.onclick = function () {
            console.log("clicked");
            this.style.display='none';
        };
    });
}

//creation de l'objet notif
function createNotif(titre,option_tab){
    const titre_notif = titre;
    const options = option_tab;
    return new Notification(titre_notif, options);
}
*/