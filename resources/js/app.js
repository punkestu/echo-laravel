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

window.toggleModal = toggleModal;
window.closeModal = closeModal;