<div class="background pt-50 flex flex-col items-center justify-center h-full prose ">
    <h1 class="text-center text-sky-500 text-3xl">Image Sharing</h1>
    <div class="flex flex-col items-center border-gray-300 bg-gray-100 py-4 card sm:w-1/2 w-5/6 my-4 mx-auto px-5">
        <div class="flex items-center">
            <i class="fa-solid fa-gear fa-2xn  mx-1"></i>
            <h2 class="font-bold text-3xl">Setting</h2>
        </div>
        <div class="flex items-center w-full py-2 pl-10">
            <label for="file_input" class="mb-1 block text-sm font-medium text-gray-700"></label>
            <input id="file_input" type="file" accept=".jpg, .png, .gif" class="block w-full text-sm file:mr-4 file:rounded-md file:border-0 file:bg-gray-500 file:py-2.5 file:px-4 file:text-sm file:font-semibold file:text-white hover:file:bg-gray-600 focus:outline-none disabled:pointer-events-none disabled:opacity-60" />
        </div>
        <div class="flex items-center w-full py-2 pl-10">
            <div class="pr-3">
                <label for="title">Title:</label>
            </div>
            <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full focus:ring-blue-500 mx-auto focus:border-blue-500 block p-2.5" id="title">
        </div>
        <div class="flex items-center w-full py-2 pl-10">
            <input id="publish" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
            <label for="publish" class="ml-2 text-sm font-medium text-gray-900">Add Publish Image List</label>
        </div>
        <div class="w-full py-2 flex justify-center">
            <button id="upload_image" type="submit" class="bg-sky-300 hover:bg-sky-500 text-white font-bold py-2 px-4 rounded-lg">Upload Image</button>
        </div>
    </div>
    <div class="w-2/3 py-10">
        <figure id="preview_area">
            <img src="" id="figureImage">
        </figure>
    </div>
    <div id="modal-area" class=""></div>
</div>
</div>
<script src="/js/main.js"></script>
<style>
</style>