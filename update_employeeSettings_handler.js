document.getElementById("email").addEventListener("blur", submitEmail);
document.getElementById("email").addEventListener("keyup", submitEmail);

document.getElementById("password").addEventListener("blur", submitPassword);
document.getElementById("password").addEventListener("keyup", submitPassword);
document.getElementById("passwordRepeat").addEventListener("blur", submitPassword);
document.getElementById("passwordRepeat").addEventListener("keyup", submitPassword);

document.getElementById("password").addEventListener("keypress", passwordStrength);
document.getElementById("password").addEventListener("keyup", passwordStrength);
document.getElementById("password").addEventListener("keydown", passwordStrength);


document.getElementById("saveEmail").addEventListener("click", submitEmail);
document.getElementById("savePassword").addEventListener("click", submitPassword);
