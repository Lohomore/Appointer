document.getElementById("lgm-1").addEventListener("click", swapProfileInfo);
document.getElementById("lgm-2").addEventListener("click", swapProfileInfo);
document.getElementById("lgm-3").addEventListener("click", swapProfileInfo);

document.getElementById("stylistImage").addEventListener("mouseover", hoverProfilePic);
document.getElementById("stylistImage").addEventListener("mouseout", offhoverProfilePic);
document.getElementById("editOverview").addEventListener("click", editOverview);
document.getElementById("editEducation").addEventListener("click", editEducation);
document.getElementById("editGallery").addEventListener("click", editGallery);
document.getElementById("editProfilePic").addEventListener("click", editProfilePic);
document.getElementsByClassName("close")[0].addEventListener("click",closeEditProfilePic);