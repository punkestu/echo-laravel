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
    return fetch("/auth/generate-token", {
        method: "POST",
        credentials: "include",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
    })
        .then((res) => res.json())
        .catch((err) => {
            window.location.href = "/logout";
        });
}

window.toggleModal = toggleModal;
window.closeModal = closeModal;
window.getToken = getToken;
