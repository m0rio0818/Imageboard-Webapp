<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class AddUrlColToPostTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "ALTER TABLE Post ADD url VARCHAR(255) AFTER ImagePath"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "ALTER TABLE Post DROP url",
        ];
    }
}
