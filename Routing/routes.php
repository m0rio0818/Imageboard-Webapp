<?php

use Helpers\ValidationHelper;
use Database\DataAccess\Implementations\PostDAOImpl;
use Models\Post;
use Response\Render\JSONRenderer;
use Response\Render\HTMLRenderer;

return [
    '' => function (): HTMLRenderer  | JSONRenderer {
        $method = $_SERVER['REQUEST_METHOD'];
        // GET method
        if ($method == "GET") {
            $postDao = new PostDAOImpl();
            $tempMaxThread = 200;
            $allThreads = $postDao->getAllThreads(0, $tempMaxThread);

            $replyCounts = [];
            $replies = [];

            foreach ($allThreads as $thread) {
                $replyCounts[] = $postDao->getReplyCount($thread);
                $replies[] = $postDao->getReplies($thread, 0, 3);
            }
            return new HTMLRenderer('component/topPage', ["posts" => $allThreads, "replyCounts" => $replyCounts, "replies" => $replies]);
        }
    },
    'post' => function (): HTMLRenderer  | JSONRenderer {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "GET") {
            return new JSONRenderer(["modal" => true]);
        }
        // POST method
        else {
            $jsonData = json_decode($_POST['data'], true);
            $postText = $jsonData["post"];
            $postType = $jsonData["type"];
            $isImage = $jsonData["isImage"];
            $hashedURL = hash('sha256', uniqid(mt_rand(), true));
            $post = new Post($postText, $hashedURL);
            $postDao = new PostDAOImpl();

            if (!ValidationHelper::checkPost($postText)["success"]) {
                return new JSONRenderer(["status" => false, "message" => ValidationHelper::checkPost($postText)["message"]]);
            }

            // 画像があった場合。
            if ($isImage) {
                $imageData = $_FILES['image'];
                $filePath = $imageData['tmp_name'];
                $fileSize = $imageData["size"];
                $extension = pathinfo($imageData["name"], PATHINFO_EXTENSION);
                // MIMEタイプを取得
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $filePath);
                finfo_close($finfo);

                if (!ValidationHelper::ImageTypeValidater($mimeType)) {
                    // ImageTypeが合致っていない
                    return new JSONRenderer(["status" => false, "message" => "ファイルtypeが正しくありません。png, jpeg, gif
                    か確認してください"]);
                }

                // ファイルサイズの確認
                if (ValidationHelper::checkFileSize($fileSize)) {
                    return new JSONRenderer(["status" => false, "message" => "ファイルは5MB以下のみ投稿可能です。"]);
                }

                // 画像保存フォルダ(日付ベースで作成 yyyy/mm/dd)がない際は作成。
                $timeZone = new DateTimeZone('Asia/Tokyo');
                $now = new DateTime();
                $now->setTimezone($timeZone);
                $year = $now->format("Y");
                $month = $now->format("m");
                $day = $now->format("d");
                $root_dir = "./images";
                $save_dirPath = $root_dir . "/" . $year . "/" . $month . "/" . $day;
                $save_ImageFullPath = $save_dirPath . "/" . $hashedURL . "." . $extension;
                $save_thumbnailFullPath = $save_dirPath . "/" . $hashedURL  . "_thumbnail." . $extension;

                // ディレクトリ作成
                if (!is_dir($save_dirPath)) {
                    mkdir($save_dirPath, 0777, true);
                }

                // 画像アップロード
                if (!move_uploaded_file($imageData["tmp_name"], $save_ImageFullPath)) {
                    return new JSONRenderer(["status" => "failed", "message" => "ファイルのアップロードに失敗しました. 再度アップロードお願いします"]);
                }


                // サムネイル画像の作成
                $newWidth = 640;
                $newHeight = 480;
                $command = "convert " . $save_ImageFullPath . " -resize " . $newWidth . "x" . $newHeight . " " . $save_thumbnailFullPath;

                // if ($extension == "gif") {
                //     $save_thumbnailFullPath = $save_dirPath . "/" . $hashedURL  . "_thumbnail.jpeg";
                //     $command = "convert {$save_ImageFullPath}[0] -resize {$newWidth}x{$newHeight} {$save_thumbnailFullPath}";
                // } else {
                //     $save_thumbnailFullPath = $save_dirPath . "/" . $hashedURL  . "_thumbnail" . "." . $extension;
                //     $command = "convert {$save_ImageFullPath} -resize {$newWidth}x{$newHeight} {$save_thumbnailFullPath}";
                // }

                if (exec($command) === false) {
                    return new JSONRenderer(["status" => "failed", "message" => "failed to create thumbnail image"]);
                }

                //  DBにデータを入れ込む.
                $post->setImagePath($save_ImageFullPath);
                $post->setThumbnailPath($save_thumbnailFullPath);
            }

            // 画像がない場合
            if ($postType == "post") {
                $resultOfCreate = $postDao->create($post);
                if ($resultOfCreate) return new JSONRenderer(["status" => "success", "url" => $hashedURL, "post" => $post]);
            } else if ($postType == "reply") {
                // urlから、返信元の投稿を特定
                $url = $jsonData["url"];
                $basePost = $postDao->getByURL($url);
                $reply_to_id = $basePost->getId();
                // 返信のPOST
                $post->setReplyToId($reply_to_id);
                // 返信をDBに追加
                $resultOfCreate = $postDao->create($post);
                // 返信をDB追加成功
                if ($resultOfCreate) {
                    // リプライを更新。
                    $replies = $postDao->getReplies($basePost, 0, 100);
                    return new JSONRenderer(["status" => "success", "url" => $url]);
                }
            }
            return new JSONRenderer(["status" => "success", "message" => "DBへ挿入が完了いたしました"]);
        }
    },
    'status' => function (): HTMLRenderer  | JSONRenderer {
        $method = $_SERVER['REQUEST_METHOD'];
        // GET method
        if ($method == "GET") {
            $currentUrl = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
            $urlParts = explode("/", $currentUrl);

            if (count($urlParts) < 3) {
                return new HTMLRenderer('component/404', ["data" => "URL does not correct. need hashstring.<br> status/<strong>{ hashstring } </strong>"]);
            }

            $publicPath = $urlParts[2];
            $postDao = new PostDAOImpl();
            $thread = $postDao->getByURL($publicPath);

            $replyCounts = $postDao->getReplyCount($thread);
            $replies = $postDao->getReplies($thread, 0, 100);

            if ($replies !== null) return new HTMLRenderer('component/status', ["post" => $thread,  "replyCount" => $replyCounts, "replies" => $replies]);
        }
    },
    'changeLike' => function (): JSONRenderer {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method == "POST") {
            $requestBody = file_get_contents('php://input');
            $jsonData = json_decode($requestBody, true);
            $likeURL = $jsonData["likeUrl"];
            $url = $jsonData["url"];
            $type = $jsonData["type"];

            $postDao = new PostDAOImpl();
            $post = $postDao->getByURL($likeURL);
            $likeCount = $post->getLikes();

            // echo "before like count : " . $likeCount;
            if ($type) {
                // いいねUPにを更新する。
                $likeCount += 1;
            } else {
                // いいねを-に更新する。
                if ($likeCount - 1 < 0) return  new JSONRenderer(["status" => "false", "message" => "likeが-になり、問題がありませう"]);
                $likeCount -= 1;
            }
            // echo "after like count : " . $likeCount;

            $post->setLikes($likeCount);
            $postDao->createOrUpdate($post);

            return new JSONRenderer(["status" => "success", "url" => $url, "message" => "DBへ挿入が完了いたしました"]);
        }
    }
];
