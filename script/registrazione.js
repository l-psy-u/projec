window.addEventListener('DOMContentLoaded', function () {

    function showError(message) {
        const errorBox = document.getElementById("registrationError");
        if (errorBox) {
            errorBox.innerText = message;
            setTimeout(function () {
                errorBox.innerText = "";
            }, 3000);
        }
    }

    function showMessage(message) {
        const messageBox = document.getElementById("registrationMessage");
        if (messageBox) {
            messageBox.style.display = "block";
            messageBox.textContent = message;
        }
    }

    function check_data() {
        const name = document.getElementById("nome").value.trim();
        const lastname = document.getElementById("cognome").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("pass").value.trim();
        const confirm = document.getElementById("confirm").value.trim();

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/;

        if (!name || !lastname || !email || !password || !confirm) {
            showError("All fields must be filled out");
            return false;
        }

        if (!emailRegex.test(email)) {
            showError("mail non valida ");
            return false;
        }

        if (password !== confirm) {
            showError("Passwords non corrispondono");
            return false;
        }

        if (!passwordRegex.test(password)) {
            showError("Password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, one number and one special character");
            return false;
        }

        return true;
    }

    const form = document.getElementById("registration");

    if (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            if (!check_data()) {
                return;
            }

            const formData = new FormData(form);

            fetch("../php/Registration.php", {
                method: "POST",
                body: formData
            })
            .then(function (response) {
                return response.text();
            })
            .then(function (data) {
                const risposta = data.trim().toLowerCase();
                console.log("Risposta PHP:", data);

                if (risposta === "ok") {
                    showMessage("Registration successful");

                    setTimeout(function () {
                        window.location.href = "./index.php";
                    }, 3000);
                } else {
                    showError(data);
                }
            })
            .catch(function (error) {
                console.error(error);
                showError("Errore durante la registrazione");
            });
        });
    }
});