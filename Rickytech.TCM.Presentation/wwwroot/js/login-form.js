function validateLogin() {
    const password = document.querySelector('[name="password"]').value;
    let passwordNumeros = password.length;
    if (passwordNumeros < 4) {
        document.getElementById("passwordError").innerHTML = "Entry valid password";
    } else {
        document.getElementById("passwordError").innerHTML = "";
    }
    const mobile = document.querySelector('[name="password"]').value;
    let mobileDigitou = mobile.length;
    if (mobileDigitou < 8) {
        document.getElementById("mobileError").innerHTML = "Entry valid phone Canada.";
    } else {
        document.getElementById("mobileError").innerHTML = "";
    }
    const emailRegex = 
    new RegExp(/^[A-Za-z0-9_!#$%&'*+\/=?`{|}~^.-]+@[A-Za-z0-9.-]+$/, "gm");
    const email = document.querySelector('[name="email"]').value;
    const isValidEmail = emailRegex.test(email);
    if (!isValidEmail) {
        document.getElementById("emailError").innerHTML = "Entry valid email.";
    } else {
        document.getElementById("emailError").innerHTML = "";
    }
    

return valid;
}