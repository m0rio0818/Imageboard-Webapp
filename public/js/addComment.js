function clickedURL(url) {
    const fetchTo = "/status/" + url;
    window.location.href = fetchTo;
}


comment.addEventListener("click", () => {
    console.log("HELLO WORLD");
    const replyComment = document.getElementById("replyComment");
    const imageFile = fileInuput.files[0];

    const isImage = imageFile ? true : false;

    const jsonData = {
        post: replyComment.value,
        type: "post",
        isImage: isImage,
    }
    console.log(jsonData);
})