const shareApp = {
    shareData: {
        title: "G1 E-commerce Intern",
        text: "Share this app to your friends 😁",
        url: "http://localhost:8080",
    },
    share: async function () {
        if (!navigator.share) {
            return;
        }

        try {
            await navigator.share(shareApp.shareData);
            console.log("The content was shared successfully");
        } catch (e) {
            console.error("Error sharing the content", e);
        }
    },
};
