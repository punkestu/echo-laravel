import "./bootstrap";

async function toggleModal(idmodal, callback) {
    const modal = document.getElementById(idmodal);
    modal.classList.toggle("hidden");
    modal.classList.toggle("flex");
    if (callback) {
        await callback();
    }
}

async function closeModal(idmodal, callback) {
    const modal = document.getElementById(idmodal);
    modal.classList.add("hidden");
    modal.classList.remove("flex");
    if (callback) {
        await callback();
    }
}

async function fetchToken() {
    await fetch("/sanctum/csrf-cookie", {
        credentials: "include",
    });
    const res = await fetch("/auth/generate-token", {
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
    if (res.token) {
        localStorage.setItem("auth_token", res.token);
    }
}

async function getToken() {
    const token = localStorage.getItem("auth_token");
    if (!token) {
        await fetchToken();
    }
    if (token) {
        fetch("/api/validate-token", {
            headers: {
                Accept: "application/json",
                Authorization: `Bearer ${token}`,
            },
        }).then((res) => {
            if (res.status === 401) {
                localStorage.removeItem("auth_token");
                fetchToken();
            }
        });
    }
    return { token: localStorage.getItem("auth_token") };
}

window.toggleModal = toggleModal;
window.closeModal = closeModal;
window.getToken = getToken;
