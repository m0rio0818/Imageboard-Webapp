<div class="background pt-10 flex flex-col items-center justify-center h-full prose ">
    <div class="w-2/3 border rounded">
        <div class="w-full overflow-hidden border ">
            <article onclick="clickedURL(`<?= htmlspecialchars($post->getUrl()); ?>`)">
                <div class="px-6 py-4">
                    <div class="text-xl mb-2"><?= htmlspecialchars($post->getContent()); ?></div>
                </div>
                <div class="flex justify-center  px-6 pt-4 pb-2">
                    <div class="flex items-center mx-10">
                        <i id="comment" class="fa-comment hover:text-blue-400 fa-solid mx-2">
                        </i>
                        <p><?= $replyCount; ?></p>
                    </div>
                    <div class="flex items-center mx-10">
                        <i id="like" class="fa-heart hover:text-pink-400 fa-solid mx-2">
                        </i>
                        <p><?= htmlspecialchars($post->getLikes()); ?></p>
                    </div>
                </div>
            </article>
        </div>
        <form method="post" enctype="multipart/form-data">
            <div clsass="flex flex-col items-center border-gray-300 py-4 card w-full my-4 mx-auto px-5">
                <textarea id="replyComment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50  border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="send reply to this post"></textarea>
                <div class="flex justify-between items-center w-full py-2 relative">
                    <div class="ml-2">
                        <label for="file_input" class="mb-1 block text-sm font-medium text-gray-700"></label>
                        <input id="file_input" type="file" accept=".jpg, .png, .gif" class="block w-full text-sm file:mr-4 file:rounded-md file:border-0 file:bg-gray-500 file:py-2.5 file:px-4 file:text-sm file:font-semibold file:text-white hover:file:bg-gray-600 focus:outline-none disabled:pointer-events-none disabled:opacity-60" />
                    </div>
                    <div class="py-2 absolute right-2 bottom-0">
                        <button id="reply_btn" type="submit" class="bg-sky-300 hover:bg-sky-500 text-white font-bold py-2 px-4 rounded-lg">返信</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php if (isset($replies)) : ?>
        <?php foreach ($replies as $reply) : ?>
            <div class="w-2/3 rounded overflow-hidden border">
                <article>
                    <div class="px-6 py-4">
                        <div class="text-xl mb-2"><?= htmlspecialchars($reply->getContent()); ?></div>
                    </div>
                    <div class="flex justify-center  px-6 pt-4 pb-2">
                        <div class="flex items-center ml-20">
                            <i id="like" class="fa-heart hover:text-pink-400 fa-solid mx-2">
                            </i>
                            <p><?= htmlspecialchars($reply->getLikes()); ?></p>
                        </div>
                    </div>
                </article>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>
<script src="/js/reply.js"></script>