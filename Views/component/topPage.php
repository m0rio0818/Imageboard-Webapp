<div class="background pt-50 flex flex-col items-center justify-center h-full prose ">
    <div class="flex flex-col items-center border-gray-300 bg-gray-100 py-4 card sm:w-1/2 w-5/6 my-4 mx-auto px-5">
        <div class="flex items-center">
            <h2 class="font-bold text-2xl">つぶやき</h2>
        </div>
        <div class="flex items-center w-full py-2 pl-10">
            <div class="pr-3">
                <label for="title">Title:</label>
            </div>
            <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full focus:ring-blue-500 mx-auto focus:border-blue-500 block p-2.5" id="title">
        </div>
        <div class="flex items-center w-full py-2 pl-10">
            <label for="file_input" class="mb-1 block text-sm font-medium text-gray-700"></label>
            <input id="file_input" type="file" accept=".jpg, .png, .gif" class="block w-full text-sm file:mr-4 file:rounded-md file:border-0 file:bg-gray-500 file:py-2.5 file:px-4 file:text-sm file:font-semibold file:text-white hover:file:bg-gray-600 focus:outline-none disabled:pointer-events-none disabled:opacity-60" />
        </div>
        <div class="w-full py-2 flex justify-center">
            <button id="post_btn" type="submit" class="bg-sky-300 hover:bg-sky-500 text-white font-bold py-2 px-4 rounded-lg">ポストする</button>
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