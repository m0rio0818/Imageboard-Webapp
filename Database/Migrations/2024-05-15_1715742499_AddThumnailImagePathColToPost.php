<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class AddThumnailImagePathColToPost implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [

            "ALTER TABLE Post ADD ThumbnailPath VARCHAR(255) AFTER ImagePath"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "ALTER TABLE Post DROP ThumbnailPath",
        ];
    }
}
