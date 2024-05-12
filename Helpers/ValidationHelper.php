<?php

namespace Helpers;

class ValidationHelper
{
    public static function integer($value, float $min = -INF, float $max = INF): int
    {
        // PHPには、データを検証する組み込み関数があります。詳細は https://www.php.net/manual/en/filter.filters.validate.php を参照ください。
        $value = filter_var($value, FILTER_VALIDATE_INT, ["min_range" => (int) $min, "max_range" => (int) $max]);

        // 結果がfalseの場合、フィルターは失敗したことになります。
        if ($value === false) throw new \InvalidArgumentException("The provided value is not a valid integer.");

        // 値がすべてのチェックをパスしたら、そのまま返します。
        return $value;
    }

    public static function ImageTypeValidater($mime): string
    {
        $imageType = [
            'image/png' => 'png',
            'image/jpeg' => 'jpeg',
            'image/gif' => 'gif'
        ];
        return $imageType[$mime];
    }

    public static function getImageURL(string $mime): bool
    {
        $imageType = [
            'image/png', 'image/jpeg', 'image/gif'
        ];

        return in_array($mime, $imageType);
    }

    public static function checkFileSize(int $fileSize): bool
    {
        $fileSizeMB = $fileSize / (1024 * 1024);
        return $fileSizeMB >= 5;
    }
}
