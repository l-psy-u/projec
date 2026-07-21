window.addEventListener('DOMContentLoaded', function () {

    function showMessage(message, color) {
        let box = document.getElementById("updateMessage");
        if (box) {
            box.style.display = "block";
            box.style.color = color || "red";
            box.innerText = message;
        }
    }

    function clearMessage() {
        let box = document.getElementById("updateMessage");
        if (box) {
            box.innerText = "";
            box.style.display = "none";
        }
    }

    function check_data() {
        let firstname = document.getElementById("firstname").value.trim();
        let lastname = document.getElementById("lastname").value.trim();
        let descrizione = document.getElementById("descrizione").value.trim();
        let citta = document.getElementById("citta").value.trim();
        let link = document.getElementById("link").value.trim();

        clearMessage();

        if (firstname === "" && lastname === "" && descrizione === "" && citta === "" && link === "") {
            showMessage("Inserisci almeno un campo da modificare", "red");
            return false;
        }

        if (firstname.length > 60) {
            showMessage("Nome troppo lungo", "red");
            return false;
        }

        if (lastname.length > 60) {
            showMessage("Cognome troppo lungo", "red");
            return false;
        }

        if (descrizione.length > 200) {
            showMessage("Descrizione troppo lunga", "red");
            return false;
        }

        if (citta.length > 20) {
            showMessage("Città troppo lunga", "red");
            return false;
        }

        if (link !== "") {
            let urlRegex = /^https:\/\/[^\s/$.?#].[^\s]*$/i;
            if (!urlRegex.test(link)) {
                showMessage("Il link deve iniziare con https://", "red");
                return false;
            }
        }

        return true;
    }

    let updateForm = document.getElementById("updateForm");

    if (updateForm) {
        updateForm.addEventListener("submit", function (event) {
            event.preventDefault();

            clearMessage();

            let isValid = check_data();
            if (!isValid) {
                return;
            }

            let formData = new FormData(updateForm);

            fetch(updateForm.action, {
                method: 'POST',
                body: formData
            })
            .then(function (response) {
                return response.text();
            })
            .then(function (data) {
                let risposta = data.trim().toLowerCase();

                if (risposta.indexOf("successo") !== -1) {
                    showMessage(data, "green");

                    setTimeout(function () {
                        window.location.href = "./privIndex.php";
                    }, 2000);
                } else {
                    showMessage(data, "red");
                }
            })
            .catch(function (error) {
                console.log(error);
                showMessage("Errore durante l'aggiornamento del profilo", "red");
            });
        });
    }
});