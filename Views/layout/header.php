<!doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Text Snipetter</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="/css/output.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<header class="fixed top-0 z-10 h-16 w-full bg-white text-white">
    <div class="d-flex font-medium justify-end text-center">
        <ul class="flex flex-wrap justify-end -mb-px">
            <li id="uploadImage" value="on" class="me-2 border-b-2 border-sky-500 ">
                <a href="/" class="inline-block p-4 rounded-t-lg text-sky-500" style="text-decoration:none;">
                    Home
                </a>
            </li>
            <li id="imageList" value="off" class="me-2 border-b-2 hover:border-gray-400">
                <a href="/post" class="active inline-block p-4 rounded-t-lg text-gray-500 hover:text-black hover:border-gray-300" style="text-decoration:none;">
                    create Post
                </a>
            </li>
        </ul>
    </div>
</header>

<body>
    <div class="mt-16 d-flex justify-center">