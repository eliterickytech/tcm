function validateSignUp() {
    const username = document.querySelector('[name="username"]').value;
    let usernameNumeros = username.length;
    const password = document.getElementById("password").value;
    let passwordNumeros = password.length;
    const confirm_password = document.getElementById("confirm-password").value;
    if (usernameNumeros < 3) {
        document.getElementById("usernameError").innerHTML = "Entry valid username very short";
    } else {
        document.getElementById("usernameError").innerHTML = "";
        if (confirm_password === password) {
            document.getElementById("confirm-passwordError").innerHTML = "";
        } else {
            document.getElementById("confirm-passwordError").innerHTML = "Password not equal";
        }
    }
    if (passwordNumeros < 5) {
        document.getElementById("passwordError").innerHTML = "Entry valid password";
    } else {
        document.getElementById("passwordError").innerHTML = "";
        if (confirm_password === password) {
            document.getElementById("confirm-passwordError").innerHTML = "";
        } else {
            document.getElementById("confirm-passwordError").innerHTML = "Password not equal";
        }
    }
    const mobile = document.querySelector('[name="mobile"]').value;
    let mobileDigitou = mobile.length;
    if (mobileDigitou < 7) {
        document.getElementById("mobileError").innerHTML = "Entry valid phone Canada.";
    } else {
        document.getElementById("mobileError").innerHTML = "";
        if (confirm_password === password) {
            document.getElementById("confirm-passwordError").innerHTML = "";
        } else {
            document.getElementById("confirm-passwordError").innerHTML = "Password not equal";
        }
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
    

return "ok";
}
function validateLogin() {
    const password = document.querySelector('[name="password"]').value;
    let passwordNumeros = password.length;
    if (passwordNumeros < 3) {
        document.getElementById("passwordError").innerHTML = "Entry valid password";
    } else {
        document.getElementById("passwordError").innerHTML = "";
    }
    const emailRegex = 
    new RegExp(/^[A-Za-z0-9_!#$%&'*+\/=?`{|}~^.-]+@[A-Za-z0-9.-]+$/, "gm");
    const email = document.querySelector('[name="email"]').value;
    const isValidEmail = emailRegex.test(email);
    if (!isValidEmail) {
        document.getElementById("emailError").innerHTML = "Entry valid email.";
        document.getElementById("forgot").href = "#";
    } else {
        document.getElementById("emailError").innerHTML = "";
        var versionUpdate = (new Date()).getTime();  
        const session = document.querySelector('[name="session"]').value;
        document.getElementById("forgot").href = "http://homolocao.thechefmelo.com/forgot_password.php?email=" + email + "&session=" + session + "&v=" + versionUpdate; 
    }
    

return "ok";
}
function validateCode() {
    var codeLogin = document.querySelector('[name="code_numbers"]').value;
    codeLogin = codeLogin.replace(/\s+/g, "");
    codeLogin = parseInt(codeLogin);
    let codeNumeros = codeLogin.length;
    if(!codeLogin){
        if (codeNumeros < 5) {
            document.getElementById("codenumberError").innerHTML = "Entry valid code";
            document.getElementById("code_numbers").value = "";
            if(document.getElementById("code_numbers").value.length > 0){
                document.getElementById("code_numbers").value = "";
            }
        }
    } else {
        if (codeNumeros < 5) {
            document.getElementById("codenumberError").innerHTML = "Entry valid code";
        } else {
            document.getElementById("codenumberError").innerHTML = "";
        }
    }
    
return "ok";
}
function validateChangePassword() {
    const password = document.getElementById("password").value;
    let passwordNumeros = password.length;
    const confirm_password = document.getElementById("confirm-password").value;
    if (passwordNumeros < 5) {
        document.getElementById("passwordError").innerHTML = "Entry valid password";
    } else {
        document.getElementById("passwordError").innerHTML = "";
        if (confirm_password === password) {
            document.getElementById("confirm-passwordError").innerHTML = "";
        } else {
            document.getElementById("confirm-passwordError").innerHTML = "Password not equal";
        }
    }
return "ok";
}
function validateChangeEmail() {
    const email = document.getElementById("email").value;
    let emailNumeros = email.length;
    const confirm_email = document.getElementById("confirm-email").value;
    if (emailNumeros < 5) {
        document.getElementById("emailError").innerHTML = "Entry valid email";
    } else {
        document.getElementById("emailError").innerHTML = "";
        if (confirm_email === email) {
            document.getElementById("emailError").innerHTML = "";
        } else {
            document.getElementById("emailError").innerHTML = "Email not equal";
        }
    }
return "ok";
}