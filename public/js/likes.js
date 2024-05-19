const likeButtons = document.querySelectorAll('#like');
console.log(likeButtons)

document.addEventListener("DOMContentLoaded", () => {
    likeButtons.forEach(likeBtn => {
        likeBtn.addEventListener("click", (event) => {
            event.stopPropagation();

            const requestPath = "/changeLike";

            fetch(requestPath, {
                method: "POST",
                body: JSON.stringify({
                    type: "up"
                })
            }).
                then(response => response.json())
                .then(data => {
                    console.log(data);
                })
        })
    })
});