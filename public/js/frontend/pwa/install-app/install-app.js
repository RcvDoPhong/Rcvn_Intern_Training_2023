let deferredPrompt = null;
window.addEventListener("beforeinstallprompt", (e) => {
    deferredPrompt = e;
});

const installApp = document.getElementById("installApp");
installApp.addEventListener("click", async () => {
    if (deferredPrompt !== null) {
        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;
        if (outcome === "accepted") {
            deferredPrompt = null;
        }
    } else {
        sweet.sweetAlertDisplay(
            "Your app is already installed",
            "Please check your device and use it",
            "info",
            2500
        );
    }
});
