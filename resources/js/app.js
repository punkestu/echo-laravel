import "./bootstrap";

function toggleModal(idmodal, callback) {
    const modal = document.getElementById(idmodal);
    modal.classList.toggle("hidden");
    modal.classList.toggle("flex");
    if (callback) {
        callback();
    }
}

function closeModal(idmodal, callback) {
    const modal = document.getElementById(idmodal);
    modal.classList.add("hidden");
    modal.classList.remove("flex");
    if (callback) {
        callback();
    }
}

async function getToken() {
    await fetch("/sanctum/csrf-cookie", {
        credentials: "include",
    });
    return fetch("/api/generate-token", {
        method: "POST",
        credentials: "include",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
    })
        .then((res) => res.json())
        .then(console.log);
}

window.toggleModal = toggleModal;
window.closeModal = closeModal;
window.getToken = getToken;
