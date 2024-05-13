const postBtn = document.getElementById("post_btn");
const fileInuput = document.getElementById("file_input");


postBtn.addEventListener("click", () => {
    const postText = document.getElementById("message").value;
    const imageFile = fileInuput.files[0];

    const isImage = imageFile ? true : false;

    const jsonData = {
        post: postText,
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
        })
})