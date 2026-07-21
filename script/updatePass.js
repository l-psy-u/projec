function verify() {
    let currentPassword = document.getElementById("current").value.trim();
    let password = document.getElementById("pass").value.trim();
    let confirmPassword = document.getElementById("confirm").value.trim();

    let errorBox = document.getElementById("error");

    errorBox.innerText = "";

    if (currentPassword === "" || password === "" || confirmPassword === "") {
        errorBox.innerText = "Please fill in all the fields.";
        return false;
    }

    if (password !== confirmPassword) {
        errorBox.innerText = "The passwords do not match.";
        return false;
    }

    if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/.test(password)) {
        errorBox.innerText = "Password must contain at least 8 characters, one lowercase letter, one uppercase letter, one number and one special character.";
        return false;
    }

    return true;
}

document.getElementById("changePasswordForm").addEventListener("submit", function (event) {
    if (!verify()) {
        event.preventDefault();
    }
});