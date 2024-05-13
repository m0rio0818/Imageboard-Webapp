
const replyComment = document.getElementById("replyComment");
const fileInuput = document.getElementById("file_input");
const send_reply = document.getElementById("reply_btn");

send_reply.addEventListener("click", (e) => {
    e.preventDefault();
    console.log("HELLO WORLD");
    const imageFile = fileInuput.files[0];

    const isImage = imageFile ? true : false;

    const jsonData = {
        post: replyComment.value,
        type: "reply",
        replyId: "id",
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
            if (data["status"] == "success") {
                replyComment.value = "";
            }
        })
})

