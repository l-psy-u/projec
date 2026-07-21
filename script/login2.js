window.addEventListener('DOMContentLoaded', function () {

    function showLoginError(message) {
        let box = document.getElementById("loginError");
        if (box) {
            box.style.display = "block";
            box.innerText = message;
        }
    }

    function clearLoginError() {
        let box = document.getElementById("loginError");
        if (box) {
            box.innerText = "";
        }
    }

    function check_data() {
        // var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
        // var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

        let email = document.getElementById("email").value.trim();
        let password = document.getElementById("pass").value.trim();

        clearLoginError();

        if (!email || !password) {
            showLoginError("All fields must be filled out");
            return false;
        }

        // if (!emailRegex.test(email)) {
        //     showLoginError("Invalid email format");
        //     return false;
        // }

        // if (!passwordRegex.test(password)) {
        //     showLoginError("Password must have at least 8 characters, one uppercase letter, one lowercase letter and one number");
        //     return false;
        // }

        return true;
    }

    let loginForm = document.getElementById("login");

    if (loginForm) {
        loginForm.addEventListener("submit", function (event) {
            event.preventDefault();

            clearLoginError();

            let isValid = check_data();
            if (!isValid) {
                return;
            }

            let formData = new FormData(loginForm);

            fetch('../php/login.php', {
                method: 'POST',
                body: formData
            })
            .then(function (response) {
                return response.text();
            })
            .then(function (data) {
                let risposta = data.trim().toLowerCase();

                if (risposta === "ok") {
                    showLoginError("Accesso effettuato con successo");

                    setTimeout(function () {
                        window.location.href = '../html/priv/privIndex.php';
                    }, 2000);
                } else {
                    showLoginError(data);
                }
            })
            .catch(function (error) {
                console.log(error);
                showLoginError("Errore durante il login");
            });
        });
    }
});