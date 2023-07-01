<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        Video::create([
            'title'  => 'Instal eRapor Kurikulum Merdeka',
            'desc'   => 'Tutorial cara instal aplikasi erapor Kurikulum Merdeka',
            'url'    => 'https://www.youtube.com/embed/UQa1GQ3oWOQ'
        ]);

        Video::create([
            'title'  => 'Intro Channel',
            'desc'   => 'Baru nemu Intro buat video nanti',
            'url'    => 'https://www.youtube.com/embed/EE3LojjSktA'
        ]);
    }
}
