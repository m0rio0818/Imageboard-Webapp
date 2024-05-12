// グレー消す => 青を加えたい
function addHighLight(target, a_target) {
    target.classList.remove("hover:border-gray-400");
    target.classList.add("border-sky-500");

    a_target.classList.remove("text-gray-500", "hover:text-black");
    a_target.classList.add("text-sky-500");
}

// 青消す => グレーを加えたい
function removeHighlight(target, a_target) {
    target.classList.remove("border-sky-500");
    target.classList.add("hover:border-gray-400");

    a_target.classList.remove("text-sky-500");
    a_target.classList.add("text-gray-500", "hover:text-black");
}


function checkHeader() {
    const currentUrl = window.location.href;
    const uploadImage = document.getElementById("uploadImage");
    const a_uploadImage = uploadImage.querySelector("a");
    const imageList = document.getElementById("imageList");
    const a_imageList = imageList.querySelector("a");;

    if (currentUrl.includes("publicImages")) {
        removeHighlight(uploadImage, a_uploadImage);
        removeHighlight(imageList, a_imageList);
        addHighLight(imageList, a_imageList);
    } else if (currentUrl.includes("jpeg") || currentUrl.includes("png") || currentUrl.includes("gif") || currentUrl.includes("delete")) {
        removeHighlight(uploadImage, a_uploadImage);
        removeHighlight(imageList, a_imageList);
    } else {
        removeHighlight(uploadImage, a_uploadImage);
        removeHighlight(imageList, a_imageList);
        addHighLight(uploadImage, a_uploadImage);
    }
}

document.addEventListener("DOMContentLoaded", function () {
    checkHeader();
});