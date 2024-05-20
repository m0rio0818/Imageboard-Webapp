<?php

namespace Database\Seeds;

require_once 'vendor/autoload.php';

use Database\AbstractSeeder;
use Faker\Factory;
use Carbon\Carbon;

class PostsSeeder extends AbstractSeeder
{
    protected ?string $tableName = 'Post';
    protected array $tableColumns = [
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
            $Post_Thumbnail = "./images/2024/05/20/5e750e6d8715166571c7cd1fef5c0645a37f86b250e3583dfde8887258c83257_thumbnail.jpg";
            $Post_Image = "./images/2024/05/20/5e750e6d8715166571c7cd1fef5c0645a37f86b250e3583dfde8887258c83257.jpg";
            $randomDateTimeString = $faker->dateTimeBetween($startDate, $endDate)->format("Y-m-d H:i:s");
            
            $row = [
                $faker->realText(200, 2),
                $Post_Image,
                $Post_Thumbnail,
                $faker->slug(),
                $faker->numberBetween(1, 100),
                // $faker->dateTimeBetween($startDate, $endDate)->format("Y-m-d H:i:s"),
                Carbon::instance($faker->dateTimeBetween($startDate, $endDate))->toDateTime(),
                Carbon::instance($faker->dateTimeBetween($startDate, $endDate))->toDateTime(),
               
            
            ];
            $rowData[] = $row;
        }

        return $rowData;
    }
}
