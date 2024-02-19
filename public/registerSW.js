if ("serviceWorker" in navigator) {
    navigator.serviceWorker
        .register("/serviceworker.js", {
            scope: ".",
        })
        .then(function (registration) {
            // Registration was successful
            console.log(
                "Laravel PWA: ServiceWorker registration successful with scope: ",
                registration.scope
            );
            triggerBackgroundSync();
            initPush();
        })

        .catch(function (err) {
            // Handle errors from service worker registration or permission request
            console.error(
                "Laravel PWA: Error during registration or permission request: ",
                err
            );
        });
}

document
    .querySelector("#registerProtocolHandler")
    .addEventListener("click", () => {
        navigator.registerProtocolHandler(
            "web+category",
            "./frontend/category?category_id=%s"
        );
    });

function initPush() {
    if (!navigator.serviceWorker.ready) {
        return;
    }

    new Promise(function (resolve, reject) {
        const permissionResult = Notification.requestPermission(function (
            result
        ) {
            resolve(result);
        });

        if (permissionResult) {
            permissionResult.then(resolve, reject);
        }
    }).then((permissionResult) => {
        if (permissionResult !== "granted") {
            throw new Error("We weren't granted permission.");
        }
        subscribeUser();
    });
}

// Utility function for browser interoperability
function urlBase64ToUint8Array(base64String) {
    var padding = "=".repeat((4 - (base64String.length % 4)) % 4);
    var base64 = (base64String + padding)
        .replace(/\-/g, "+")
        .replace(/_/g, "/");

    var rawData = window.atob(base64);
    var outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}
function subscribeUser() {
    navigator.serviceWorker.ready
        .then((registration) => {
            const subscribeOptions = {
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(
                    "BKYu0CztyHvM9T3gi-j_TmAU7SAR7XUzblzhJmoUMyDvzGA2PHsI9jZSElULOyczOWtnslQGLm5WiDjO4krEDk0"
                ),
            };

            return registration.pushManager.subscribe(subscribeOptions);
        })
        .then((pushSubscription) => {
            console.log(
                "Received PushSubscription: ",
                JSON.stringify(pushSubscription)
            );
            storePushSubscription(pushSubscription);
        });
}

function storePushSubscription(pushSubscription) {
    const token = document
        .querySelector("meta[name=csrf-token]")
        .getAttribute("content");

    fetch("/frontend/push/subscribe-user", {
        method: "POST",
        body: JSON.stringify(pushSubscription),
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-CSRF-Token": token,
        },
    })
        .then((res) => {
            return res.json();
        })
        .then((res) => {
            console.log(res);
        })
        .catch((err) => {
            console.log(err);
        });
}



function triggerBackgroundSync() {
    if ("SyncManager" in window) {
        navigator.serviceWorker.ready
            .then((registration) => {
                console.log("sync data registered");
                return registration.sync.register("syncData");
            })
            .catch((error) => {
                console.error("Background sync registration failed:", error);
            });
    }

    // verify the background sync
    navigator.serviceWorker.ready.then((registration) => {
        registration.sync.getTags().then((tags) => {
            if (tags.includes("syncData"))
                console.log("Messages sync already requested");
        });
    });
}
