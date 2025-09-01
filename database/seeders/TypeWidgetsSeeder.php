<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeWidgetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('type_widgets')->insert([
            [
                'title' => 'Hero Banner',
                'description' => 'Widget untuk menampilkan banner utama dengan gambar dan teks headline.',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Carousel',
                'description' => 'Widget slider/carousel untuk menampilkan gambar atau konten bergulir.',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Newsletter Signup',
                'description' => 'Form pendaftaran newsletter/email subscription.',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Testimonial',
                'description' => 'Widget untuk menampilkan testimoni pelanggan atau partner.',
                'status' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Call To Action',
                'description' => 'Widget ajakan bertindak (CTA) dengan tombol aksi.',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
