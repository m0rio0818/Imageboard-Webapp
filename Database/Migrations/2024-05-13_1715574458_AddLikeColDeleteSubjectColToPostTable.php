<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class AddLikeColDeleteSubjectColToPostTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "ALTER TABLE Post ADD likes INT NOT NULL AFTER ImagePath",
            "ALTER TABLE Post DROP COLUMN subject"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "ALTER TABLE Post DROP likes",
            "ALTER TABLE Post ADD COLUMN subject VARCHAR(50) AFTER reply_to_id",
        ];
    }
}
