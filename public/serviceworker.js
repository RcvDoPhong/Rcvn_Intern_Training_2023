const staticCacheName = "pwa-v" + new Date().getTime();
//const staticCacheName = "pwa-v1";
const filesToCache = [
    "/offline-page/offline-page.html",
    "/image/icons/icon-72x72.png",
    "/image/icons/icon-96x96.png",
    "/image/icons/icon-128x128.png",
    "/image/icons/icon-144x144.png",
    "/image/icons/icon-152x152.png",
    "/image/icons/icon-384x384.png",
    "/image/icons/icon-192x192.png",
    "/image/icons/icon-512x512.png",
    "/image/logo.jpg",
    "/frontend/css/bootstrap.min.css",
    "/image/no-network.jpg",
];

// Cache on install
self.addEventListener("install", (event) => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            return cache.addAll(filesToCache);
        })
    );
});

// Clear cache on activate
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((cacheName) => cacheName.startsWith("pwa-"))
                    .filter((cacheName) => cacheName !== staticCacheName)
                    .map((cacheName) => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", async (event) => {
    if ("setAppBadge" in navigator) {
        navigator.setAppBadge(122);
    }
    event.respondWith(
        caches
            .match(event.request)
            .then((cachedResponse) => {
                // If request is in cache, return cached response
                if (cachedResponse) {
                    return cachedResponse;
                }

                // Otherwise, fetch the request from network
                return fetch(event.request).then((response) => {
                    // Clone the response to cache and return the original response
                    return caches.open(staticCacheName).then((cache) => {
                        cache.put(event.request, response.clone());
                        return response;
                    });
                });
            })
            //offline here
            .catch(() => {
                return caches.match("/offline-page/offline-page.html");
            })
    );
});

self.addEventListener("push", function (e) {
    if (!(self.Notification && self.Notification.permission === "granted")) {
        //notifications aren't supported or permission not granted!
        return;
    }

    if (e.data) {
        const msg = e.data.json();
        e.waitUntil(
            self.registration.showNotification(msg.title, {
                body: msg.body,
                icon: msg.icon,
                actions: msg.actions,
                image: msg.image,
                vibrate: msg.vibrate,
            })
        );
    }
});

self.addEventListener("notificationclick", (event) => {
    console.log("On notification click: ", event.notification.tag);
    event.notification.close();

    // This looks to see if the current is already open and
    // focuses if it is
    event.waitUntil(
        clients
            .matchAll({
                type: "window",
            })
            .then((clientList) => {
                for (const client of clientList) {
                    if (client.url === "/" && "focus" in client) {
                        client.focus();
                        break;
                    }
                }
                if (clients.openWindow) return clients.openWindow("/");
            })
    );
});
