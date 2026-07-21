function verify() {
    let firstname = document.getElementById("firstname").value.trim();
    let lastname = document.getElementById("lastname").value.trim();
    let descrizione = document.getElementById("descrizione").value.trim();
    let citta = document.getElementById("citta").value.trim();
    let link = document.getElementById("link").value.trim();

    let errorBox = document.getElementById("error");

    errorBox.innerText = "";

    // altri controlli...

    var linkRegex = /^https:\/\/[^\s/$.?#].[^\s]*$/i;
    if (link !== "" && !linkRegex.test(link)) {
        errorBox.innerText = "Il link deve iniziare con https://";
        return false;
    }

    return true;
}

document.getElementById("updateForm").addEventListener("submit", function (event) {
    if (!verify()) {
        event.preventDefault();
    }
});