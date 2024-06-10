
const replyComment = document.getElementById("replyComment");
const fileInuput = document.getElementById("file_input");
const send_reply = document.getElementById("reply_btn");

send_reply.addEventListener("click", (e) => {
    e.preventDefault();

    const imageFile = fileInuput.files[0];
    const isImage = imageFile ? true : false;
    const urlList = window.location.href.split("/");
    const hashURL = urlList[urlList.indexOf("status") + 1];

    const jsonData = {
        post: replyComment.value,
        type: "reply",
        url: hashURL,
        isImage: isImage,
    }

    const formData = new FormData();
    if (isImage) formData.append("image", imageFile)
    formData.append("data", JSON.stringify(jsonData));

    const requestPath = "/post";
    fetch(requestPath, {
        method: "POST",
        body: formData,
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            if (data["status"] == "success") {
                window.location.href = "/status/" + data["url"];
                replyComment.value = "";
            }
        })
})

