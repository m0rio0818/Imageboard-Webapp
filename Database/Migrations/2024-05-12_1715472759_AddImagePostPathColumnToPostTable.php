<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class AddImagePostPathColumnToPostTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "ALTER TABLE Post ADD ImagePath Text AFTER content"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "ALTER TABLE Post DROP ImagePath"
        ];
    }
}
