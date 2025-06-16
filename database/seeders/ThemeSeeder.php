<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemeSeeder extends Seeder
{
    public function run()
    {
        DB::table('themes')->insert([
            [
                'name' => 'minimal',
                'label' => 'Minimal / Light',
                'description' => 'Tema minimalis dan terang, cocok untuk tampilan bersih dan sederhana.',
            ],
            [
                'name' => 'dark',
                'label' => 'Dark',
                'description' => 'Tema gelap yang nyaman untuk mata di malam hari.',
            ],
            [
                'name' => 'glass',
                'label' => 'Glass',
                'description' => 'Tema glassmorphism modern dengan efek transparan dan blur.',
            ],
            [
                'name' => 'digital',
                'label' => 'Digital',
                'description' => 'Tema digital modern dengan warna-warna cerah dan kontras.',
            ],
        ]);
    }
} 