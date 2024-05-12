<?php

namespace Helpers;

use Database\MySQLWrapper;
use DateInterval;
use DateTime;
use DateTimeZone;
use Exception;

class DatabaseHelper
{
    public static function createNewImage(string $title, string $shareURL, string $deleteURL, int $size, string $mime, string $imgURL, string $viewedCount, bool $publish, string $ip_address)
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("INSERT INTO images 
            (title, shared_url, delete_url, size, mimeType, image_url, viewed_count, publish, ip_address)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
        $stmt->bind_param('sssissiis', $title, $shareURL, $deleteURL, $size, $mime, $imgURL, $viewedCount, $publish, $ip_address);
        $insertSuccess = $stmt->execute();
        $stmt->close();
        return $insertSuccess;
    }

    public static function increaseViewedCount(string $url): bool
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("UPDATE images SET viewed_count = viewed_count + 1, last_acceessed_at = ?  WHERE shared_url = ?");
        $currentTime = date("Y-m-d H:m:s");
        $stmt->bind_param('ss', $currentTime, $url);
        $stmt->execute();
        // 影響を受けた行の数を取得する
        $affectedRows = $stmt->affected_rows;
        return $affectedRows > 0;
    }

    public static function getImageBySharedURL(string $url): array | string
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("SELECT * FROM images WHERE shared_url = ?");
        $stmt->bind_param('s', $url);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return "nodata";
        } else {
            $data = $result->fetch_assoc();
            return $data;
        }
    }
    public static function getImageByDeleteURL(string $url): array | string
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("SELECT * FROM images WHERE delete_url = ?");
        $stmt->bind_param('s', $url);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return "nodata";
        } else {
            $data = $result->fetch_assoc();
            return $data;
        }
    }

    public static function getImagePathByDeleteURL(string $deleteURL): string
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("SELECT image_url FROM images WHERE delete_url = ?");
        $stmt->bind_param('s', $deleteURL);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $imageUrl = $row['image_url'];
        } else {
            $imageUrl = null;
        }

        $result->close();
        $stmt->close();
        $db->close();

        return $imageUrl;
    }

    public static function deleteDataByURL(string $url): array | string
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("DELETE FROM images WHERE delete_url = ?");
        $stmt->bind_param('s', $url);
        $result = $stmt->execute();
        return $result ? true : false;
    }

    public static function deleteExpiredAt(string $url): string
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("DELETE FROM images WHERE url = ?");
        $stmt->bind_param('s', $url);
        $stmt->execute();
        $result = $stmt->execute();
        if ($result) return "success";
        return "failed";
    }

    public static function getTotalUploadCapacity(string $ipAddress): int
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("SELECT SUM(size) AS total_size FROM images WHERE ip_address = ? AND DATE(created_at) = CURDATE()");
        $stmt->bind_param('s', $ipAddress);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = 0;

        if ($result && $row = $result->fetch_assoc()) {
            $count = (int) $row['total_size'];
        }
        $error = $stmt->error;
        if ($error) {
            echo "Error: " . $error;
        }
        $stmt->close();
        return $count;
    }

    public static function getDayNumUploadedVideos(string $ipAddress): int
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("SELECT COUNT(*) FROM images WHERE ip_address = ? AND DATE(created_at) = CURDATE()");
        $stmt->bind_param('s', $ipAddress);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = 0;
        if ($result && $row = $result->fetch_assoc()) {
            $count = (int) $row['COUNT(*)'];
        }
        $stmt->close();
        return $count;
    }


    public static function getPublicImages(): array | string
    {
        $db = new MySQLWrapper();
        $stmt = $db->prepare("SELECT * FROM images WHERE publish = 1");
        $stmt->execute();
        $ans = [];
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $ans[] = $row;
        }
        if (!$ans) {
            return "nodata";
        }
        return $ans;
    }
}
