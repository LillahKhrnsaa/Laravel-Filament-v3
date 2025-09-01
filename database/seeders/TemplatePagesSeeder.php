<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplatePagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('template_pages')->insert([
            [
                'title' => 'Homepage',
                'description' => 'Template halaman utama website dengan hero banner, highlight produk/layanan, dan CTA.',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'About Us',
                'description' => 'Template halaman tentang perusahaan, visi, misi, dan tim.',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Contact',
                'description' => 'Template halaman kontak dengan form, alamat, dan peta lokasi.',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Blog',
                'description' => 'Template halaman daftar artikel/blog.',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Landing Page',
                'description' => 'Template khusus untuk kampanye produk/jasa dengan fokus CTA.',
                'status' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
