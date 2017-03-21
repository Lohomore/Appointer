document.getElementById("country").addEventListener("blur", submitLocation);
document.getElementById("province").addEventListener("blur", validateReigon);
document.getElementById("city").addEventListener("blur", submitLocation);

document.getElementById("email").addEventListener("blur", submitEmail);
document.getElementById("email").addEventListener("keyup", submitEmail);

document.getElementById("password").addEventListener("blur", submitPassword);
document.getElementById("password").addEventListener("keyup", submitPassword);
document.getElementById("passwordRepeat").addEventListener("blur", submitPassword);
document.getElementById("passwordRepeat").addEventListener("keyup", submitPassword);

document.getElementById("password").addEventListener("keypress", passwordStrength);
document.getElementById("password").addEventListener("keyup", passwordStrength);
document.getElementById("password").addEventListener("keydown", passwordStrength);

document.getElementsByClassName("close")[0].addEventListener("click",closeEditProfilePic);

document.getElementById("saveEmail").addEventListener("click", submitEmail);
document.getElementById("savePassword").addEventListener("click", submitPassword);
document.getElementById("saveLocation").addEventListener("click", submitCustomerLocation);
document.getElementById("deleteAccount").addEventListener("click", deleteAccount);