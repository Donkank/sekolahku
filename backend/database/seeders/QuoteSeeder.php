<?php

namespace Database\Seeders;

use App\Models\Quote;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    public function run(): void
    {
        Quote::create([
            'text'   => 'Pendidikan adalah senjata paling mematikan di dunia, karena dengan pendidikan, kamu dapat mengubah dunia.',
            'author' => 'Nelson Mandela'
        ]);
        Quote::create([
            'text'   => 'Kejeniusan tanpa pendidikan adalah ibarat perak di dalam tambang.',
            'author' => 'Benjamin Franklin'
        ]);
        Quote::create([
            'text'   => 'Anda mungkin bisa menunda, tapi waktu tidak akan menunggu.',
            'author' => 'Benjamin Franklin'
        ]);
        Quote::create([
            'text'   => 'Pendidikan tanpa nilai, seberapa bergunanya itu, tampaknya hanya akan menciptakan seorang iblis yang lebih pintar.',
            'author' => 'C.S Lewis'
        ]);
        Quote::create([
            'text'   => 'Kegunaan pendidikan adalah untuk mengajarkan seseorang untuk berpikir dengan intensif dan kritis. Kecerdasan dan karakter itulah tujuan pendidikan sesungguhnya.',
            'author' => 'Martin Luther King'
        ]);
        Quote::create([
            'text'   => 'Kesedihanmu adalah kebahagiaanku, kerena sungguh kecemerlangan hatimu membuatku ingin membunuhmu.',
            'author' => 'DeDonkank'
        ]);
    }
}
