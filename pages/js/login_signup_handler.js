
document.getElementById("firstName").addEventListener("blur", validateFirstName);
document.getElementById("firstName").addEventListener("keyup", validateFirstName);
document.getElementById("lastName").addEventListener("keyup", validateLastName);
document.getElementById("lastName").addEventListener("blur", validateLastName);



document.getElementById("months").addEventListener("blur", validateMonth);
document.getElementById("days").addEventListener("blur", validateDay);
document.getElementById("years").addEventListener("blur", validateYear);

document.getElementById("country").addEventListener("blur", validateCountry);
document.getElementById("province").addEventListener("blur", validateReigon);
document.getElementById("city").addEventListener("blur", validateCity);

document.getElementById("email").addEventListener("blur", validateEmail);
document.getElementById("email").addEventListener("keyup", validateEmail);

document.getElementById("password").addEventListener("blur", validatePassword);
document.getElementById("password").addEventListener("keyup", validatePassword);
document.getElementById("passwordRepeat").addEventListener("blur", validatePassword);
document.getElementById("passwordRepeat").addEventListener("keyup", validatePassword);

document.getElementById("password").addEventListener("keypress", passwordStrength);
document.getElementById("password").addEventListener("keyup", passwordStrength);
document.getElementById("password").addEventListener("keydown", passwordStrength);

document.getElementById("createAccount").addEventListener("click", createAccount);
document.getElementById("logIn").addEventListener("click", logIn);