const ws = new WebSocket("ws://localhost:8080");

ws.onopen = function () {
    console.log("Connected to WebSocket server");
};

ws.onmessage = function (event) {
    const Message = JSON.parse(event.data);
    window.location.href = "/";
    console.log("POST ページ Message : ", Message);
};


const postBtn = document.getElementById("post_btn");
const fileInuput = document.getElementById("file_input");


postBtn.addEventListener("click", () => {
    const postText = document.getElementById("message");
    const imageFile = fileInuput.files[0];

    const isImage = imageFile ? true : false;

    const jsonData = {
        post: postText.value,
        type: "post",
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
            console.log("DDD", data);
            if (data["status"] == "success") {
                ws.send(JSON.stringify((jsonData)));
                postText.value = "";
            } else {
                window.alert(data.message);
            }
        })
})


ws.onclose = function (e) {
    console.log("Connection closed.");
};

ws.onerror = function (e) {
    console.error("WebSocket error observed:", e);
};