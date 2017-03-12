
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

document.getElementById("salon").addEventListener("blur", validateSalon);

document.getElementById("email").addEventListener("blur", validateEmail);
document.getElementById("email").addEventListener("keyup", validateEmail);


document.getElementById("createAccount").addEventListener("click", createStylistAccount);
