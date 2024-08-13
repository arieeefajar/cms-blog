<?php

namespace Database\Seeders;

use App\Models\KategoryModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        KategoryModel::create([
            'name' => 'Artikel',
        ]);

        KategoryModel::create([
            'name' => 'Berita',
        ]);
    }
}
