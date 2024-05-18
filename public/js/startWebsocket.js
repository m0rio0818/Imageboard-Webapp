const ws = new WebSocket("ws://localhost:8080");

ws.onopen = function () {
    console.log("Connected to WebSocket server");
};

ws.onmessage = function (event) {
    const Message = JSON.parse(event.data);
    window.location.href = "/status/" + Message["url"];
};

const replyComment = document.getElementById("replyComment");
const fileInput = document.getElementById("file_input");
const replyBtn = document.getElementById("reply_btn");

replyBtn.addEventListener("click", (e) => {
    e.preventDefault();

    const imageFile = fileInput.files[0];
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

    ws.send(JSON.stringify((jsonData)));

    const requestPath = "/post";
    fetch(requestPath, {
        method: "POST",
        body: formData
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


ws.onclose = function (e) {
    console.log("Connection closed.");
};

ws.onerror = function (e) {
    console.error("WebSocket error observed:", e);
};