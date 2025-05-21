<?php

namespace Database\Seeders;

use App\Models\product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $product = 
        [
            [
                'name' => 'Kecap Kraos',
                'price' => 8000,
                'stock' => 100,
                'image' => 'https://cdn.grid.id/crop/0x0:0x0/700x465/photo/2021/10/31/5f9189f301b5djpg-20211031032542.jpg',
            ],
            [
                'name' => 'Sabun',
                'price' => 6000,
                'stock' => 100,
                'image' => 'https://dc9wzcca34ebk.cloudfront.net/wp-content/uploads/2024/01/serenitree-blog-5.png',
            ],
            [
                'name' => 'Mie Indomie',
                'price' => 6000,
                'stock' => 88,
                'image' => 'https://image.astronauts.cloud/product-images/2024/4/IndomieGorengSpesialMieinstan1_19ed38d5-421f-4813-bd66-25cf83f1909c_900x900.png',
            ],
            [
                'name' => 'Sabun 3',
                'price' => 6000,
                'stock' => 100,
                'image' => 'https://dc9wzcca34ebk.cloudfront.net/wp-content/uploads/2024/01/serenitree-blog-5.png',
            ],
            [
                'name' => 'Sabun 4',
                'price' => 6000,
                'stock' => 100,
                'image' => 'https://dc9wzcca34ebk.cloudfront.net/wp-content/uploads/2024/01/serenitree-blog-5.png',
            ],
            [
                'name' => 'Sabun 5',
                'price' => 6000,
                'stock' => 100,
                'image' => 'https://dc9wzcca34ebk.cloudfront.net/wp-content/uploads/2024/01/serenitree-blog-5.png',
            ]
        ];
        foreach ($product as $key => $value) {
            product::create($value);
        }

}
}
