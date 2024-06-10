<?php

use Carbon\Carbon;

date_default_timezone_set('Asia/Tokyo'); ?>
<div class="background pt-50 flex flex-col items-center justify-center h-full prose ">
    <div class="flex flex-col items-center border-gray-300  py-4 card w-full my-4 mx-auto px-5">
        <textarea id="message" rows="4" class="block p-2.5 w-3/4 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
        <div class="flex justify-between items-center w-3/4 py-2 relative">
            <div class="">
                <label for="file_input" class="mb-1 block text-sm font-medium text-gray-700"></label>
                <input id="file_input" type="file" accept=".jpg, .png, .gif" class="block w-full text-sm file:mr-4 file:rounded-md file:border-0 file:bg-gray-500 file:py-2.5 file:px-4 file:text-sm file:font-semibold file:text-white hover:file:bg-gray-600 focus:outline-none disabled:pointer-events-none disabled:opacity-60" />
            </div>
            <div class="py-2 absolute right-2 bottom-0">
                <button id="post_btn" type="submit" class="bg-sky-300 hover:bg-sky-500 text-white font-bold py-2 px-4 rounded-lg">ポストする</button>
            </div>
        </div>
    </div>
    <div id="modal-area" class=""></div>
    <div id="newMessageInfo"></div>
    <?php for ($i = 0; $i < count($posts); $i++) : ?>
        <?php $post = $posts[$i]; ?>
        <div class="w-2/3 my-3 rounded overflow-hidden border ">
            <article class="hover:border-gray-500 yubi" onclick="clickedURL(`<?= htmlspecialchars($post->getUrl()); ?>`)">
                <div class="flex items-center p-5">
                    <i class="fa-solid fa-user fa-2xl"></i>
                    <p class="text-xs ml-3">
                        Posted : <?= Carbon::parse($post->getTimeStamp()->getCreatedAt())->diffForHumans(); ?>
                    </p>
                </div>
                <div class="pl-6 py-2">
                    <div class="text-xl break-words overflow-wrap mb-2"><?= htmlspecialchars($post->getContent()); ?></div>
                </div>
                <div class="hover:bg-gray-300">
                    <?php if (!is_null($post->getImagePath())) : ?>
                        <a href="<?php echo substr($post->getImagePath(), 1) ?>">
                            <img class="mx-auto py-1" src="<?php echo substr($post->getThumbnailPath(), 1) ?>" alt="">
                        </a>
                    <?php endif; ?>
                </div>
                <div class="flex justify-center px-6 pt-2 pb-1">
                    <div class="flex items-center mx-10">
                        <i id="comment" class="fa-comment hover:text-blue-400 fa-solid mx-2"></i>
                        <p><?= htmlspecialchars($replyCounts[$i]); ?></p>
                    </div>
                    <!-- <div class="flex items-center mx-10">
                        <i data-checked="false" class="like fa-heart fa-solid mx-2" data-url="<?= htmlspecialchars($post->getUrl()); ?>"></i>
                        <p><?= htmlspecialchars($post->getLikes()); ?></p>
                    </div> -->
                </div>
            </article>
            <?php if (count($replies[$i]) > 0) : ?>
                <div class="w-full py-1 border-t border-b pl-5">
                    <p>Comment</p>
                </div>
            <?php endif; ?>
            <?php foreach ($replies[$i] as $reply) :  ?>
                <div class="border-b w-full py-1 pl-10">
                    <div class="flex items-center">
                        <i class="fa-regular fa-user fa-2xs mr-2"></i>
                        <p class="text-xs">
                            <?= Carbon::parse($reply->getTimeStamp()->getCreatedAt())->diffForHumans(); ?>
                        </p>
                    </div>
                    <?= htmlspecialchars($reply->getContent()) ?>
                </div>
            <?php endforeach ?>
            <?php if (count($replies[$i]) >= 3) : ?>
                <div class="w-full py-2 hover:bg-gray-100 yubi">
                    <p class="text-center text-sky-400">全てのコメントを表示</p>
                </div>
            <?php endif; ?>
        </div>
    <?php endfor; ?>
</div>
<script src=" /js/post.js"></script>
<script src="/js/detailPage.js"></script>
<!-- <script src="/js/likes.js"></script> -->
<style>
</style>