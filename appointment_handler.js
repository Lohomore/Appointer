document.getElementById("newCustomerAppointment").addEventListener("click", addCustomerAppointment);
document.getElementById("selectHairstyle").addEventListener("blur", verifyHairstyle);
document.getElementById("selectLocation").addEventListener("blur", verifyLocation);
document.getElementById("selectedHairstylist").addEventListener("click", openHairstylistWindow);
document.getElementById("selectStylistGrid").addEventListener("click", selectHairstylist);
document.getElementsByClassName("close")[0].addEventListener("click",closeSelectHairstylist);
document.getElementsByClassName("close")[0].addEventListener("click",verifyStylist);
document.getElementsByClassName("close")[1].addEventListener("click",closeEvent);

