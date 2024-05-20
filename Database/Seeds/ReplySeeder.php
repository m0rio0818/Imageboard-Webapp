<?php

namespace Database\Seeds;

require_once 'vendor/autoload.php';

use Database\AbstractSeeder;
use Faker\Factory;
use Carbon\Carbon;

class ReplySeeder extends AbstractSeeder
{
    protected ?string $tableName = 'Post';
    protected array $tableColumns = [
        [
            'data_type' => 'int',
            'column_name' => 'reply_to_id'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'content'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'ImagePath'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'ThumbnailPath'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'url'
        ],
        [
            'data_type' => 'int',
            'column_name' => 'likes'
        ],
        [
            'data_type' => 'DateTime',
            'column_name' => 'created_at'
        ],
        [
            'data_type' => 'DateTime',
            'column_name' => 'updated_at'
        ],
    ];

    public function createRowData(): array
    {
        $faker = Factory::create();
        $rowData = [];
        $startDate = '-10 years'; // 10年前
        $endDate = 'now'; // 現在

        for ($i = 0; $i < 100; $i++) {
            $replyThumnail = "./images/2024/05/20/0098e23a9c483a38d06a1e40a06912b0433f64b8aad5aff3510270e0e3a43329_thumbnail.jpg";
            $replyPostImage = "./images/2024/05/20/0098e23a9c483a38d06a1e40a06912b0433f64b8aad5aff3510270e0e3a43329.jpg";
            $randomDateTimeString = $faker->dateTimeBetween($startDate, $endDate)->format("Y-m-d H:i:s");
            $randomDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $randomDateTimeString);
            
            $reply_row = [
                $faker->numberBetween(1, 100), //reply to id
                $faker->realText(200, 2),
                $replyThumnail,
                $replyPostImage,
                $faker->slug(),
                $faker->numberBetween(1, 100),
                // $faker->dateTimeBetween($startDate, $endDate)->format("Y-m-d H:i:s"),s
                // $faker->dateTimeBetween($startDate, $endDate)->format("Y-m-d H:i:s"),
                Carbon::instance($faker->dateTimeBetween($startDate, $endDate))->toDateTime(),
                Carbon::instance($faker->dateTimeBetween($startDate, $endDate))->toDateTime(),
               
            ];

            $rowData[] = $reply_row;
        }

        return $rowData;
    }
}
