document.getElementById("country").addEventListener("blur", validateCountry);
document.getElementById("province").addEventListener("blur", validateReigon);
document.getElementById("city").addEventListener("blur", validateCity);

document.getElementById("salon").addEventListener("blur", validateSalon);

document.getElementById("email").addEventListener("blur", validateEmail);
document.getElementById("email").addEventListener("keyup", validateEmail);

document.getElementById("password").addEventListener("blur", validatePassword);
document.getElementById("password").addEventListener("keyup", validatePassword);
document.getElementById("passwordRepeat").addEventListener("blur", validatePassword);
document.getElementById("passwordRepeat").addEventListener("keyup", validatePassword);

document.getElementById("password").addEventListener("keypress", passwordStrength);
document.getElementById("password").addEventListener("keyup", passwordStrength);
document.getElementById("password").addEventListener("keydown", passwordStrength);

document.getElementsByClassName("close")[0].addEventListener("click",closeEditProfilePic);

document.getElementById("saveEmail").addEventListener("click", submitEmail);
document.getElementById("savePassword").addEventListener("click", submitPassword);
document.getElementById("saveLocation").addEventListener("click", submitLocation);
document.getElementById("deleteStylist").addEventListener("click", deleteStylist);
document.getElementById("deleteAccount").addEventListener("click", deleteAccount);