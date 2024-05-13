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
            $results = $postDao->getAllThreads(0, $tempMaxThread);

            return new HTMLRenderer('component/topPage', ["posts" => $results]);
        }
        // POST method
        else {
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
            $ip_address = $_SERVER['REMOTE_ADDR'];

            // 画像があった場合。
            if ($isImage) {
                $imageData = $_FILES['image'];
                $filePath = $imageData['tmp_name'];
                $extension = pathinfo($imageData["name"], PATHINFO_EXTENSION);
                // MIMEタイプを取得
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $filePath);
                finfo_close($finfo);
                $createHashURL = hash('sha256', uniqid(mt_rand(), true));

                if (!ValidationHelper::ImageTypeValidater($mimeType)) {
                    // ImageTypeが合致っていない
                    return new JSONRenderer(["status" => false, "message" => "ファイルtypeが正しくありません。png, jpeg, gif
                    か確認してください"]);
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
                $save_fullPath = $save_dirPath . "/" . $createHashURL . "." . $extension;

                if (!is_dir($save_dirPath)) {
                    mkdir($save_dirPath, 0777, true);
                }
                // URLのroot確認
                $urlMediaType = ValidationHelper::ImageTypeValidater($mimeType);
                $createdFullURL = $urlMediaType . "/" . $createHashURL;

                $postDao = new PostDAOImpl();
                $post = new Post($postText, $createdFullURL);
                if (!move_uploaded_file($imageData["tmp_name"], $save_fullPath)) {
                    return new JSONRenderer(["status" => false, "message" => "ファイルの作成に失敗しました. 再度作成お願いします"]);
                } else {
                    $postDao = new PostDAOImpl();
                    $post = new Post($postText, $save_fullPath);
                    $postDao->create($post);
                    return new JSONRenderer(["status" => "success", "message" => "DBへ挿入が完了いたしました"]);
                }
            }

            $hashedURL =  hash('sha256', uniqid(mt_rand(), true));

            $postDao = new PostDAOImpl();
            if ($postType == "post") {
                $post = new Post($postText, $hashedURL);
            } else if ($postType == "reply") {
                $post = new Post($postText, $hashedURL);
            }
            $postDao->create($post);
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

            $results = $postDao->getByURL($publicPath);
            // return new HTMLRenderer('component/404', ["data" => "URL does not correct. need hashstring.<br> status/<strong>{ hashstring } </strong>"]);

            // var_dump($results);

            return new HTMLRenderer('component/status', ["post" => $results]);
        }
    },

];
