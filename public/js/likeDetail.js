const likeButtons = document.querySelectorAll('.like');

// チェックする
function checked(button) {
    button.classList.remove("fa-regular", "hover:text-pink-400");
    button.classList.add("fa-solid", "text-pink-400");
    button.setAttribute("data-checked", true);
    console.log(button.getAttribute("data-checked"));
    return true;
}

// チェック外す
function unChecked(button) {
    button.classList.remove("fa-solid", "text-pink-400");
    button.classList.add("fa-regular", "hover:text-pink-400");
    button.addEventListener('mouseenter', function () {
        this.classList.remove('fa-regular');
        this.classList.add('fa-solid');
    });

    button.addEventListener('mouseleave', function () {
        this.classList.remove('fa-solid');
        this.classList.add('fa-regular');
    });

    button.setAttribute("data-checked", false);
    return false;
}

likeButtons.forEach(button => {
    let liksChecked = button.getAttribute('data-checked') === 'true';
    console.log("isChecked", liksChecked);
    // いいねついてたら
    if (liksChecked) {
        checked(button);
    } else {
        unChecked(button);
    }

    button.addEventListener("click", (e) => {
        e.stopPropagation();
        const clickedURL = button.getAttribute("data-url");
        let isChecked = button.getAttribute('data-checked') === 'true';
        
        console.log("before : ", isChecked);
        let result = isChecked ? unChecked(button) : checked(button);
        isChecked = !isChecked;
        console.log("after : ", result);
        
        
        const likeCountElement = button.nextElementSibling;
        let likeCount = parseInt(likeCountElement.textContent); // 現在のいいね数を取得
        console.log("LikeCount", likeCount);

        likeCount = isChecked ? likeCount + 1 : likeCount - 1;
        likeCountElement.textContent = likeCount;


        const urlList = window.location.href.split("/");
        const hashURL = urlList[urlList.indexOf("status") + 1];

        const jsonForm = JSON.stringify({
            type: result,
            url: hashURL,
            likeUrl: clickedURL,
        });

        console.log(jsonForm);

        const requestPath = "/changeLike";
        fetch(requestPath, {
            method: "POST",
            body: jsonForm
        }).
            then(response => response.json())
            .then(data => {
                console.log(data);
                if (data["status"] == "success") {
                }
            })
    })
})