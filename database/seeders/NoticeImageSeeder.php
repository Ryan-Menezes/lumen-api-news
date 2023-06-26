<?php

namespace Database\Seeders;

use App\Helpers\ImageBase64Helper;
use App\Models\NoticeImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoticeImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = NoticeImage::factory()->make();

        NoticeImage::factory(10)->create([
            'source' => ImageBase64Helper::generate($model->source),
        ]);
    }
}
