<?php

use App\Tax;
use App\ItemTax;
use App\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::insert([
            [
                'location_id' => 1,
                'name' => 'Eyebrow Trimmer',
                'description' => 'Get Best Eyebrow Trimmer in Best Price',
                'price' => '100',
                'image' => '["hair.jpg"]',
                'default_image' => 'hair.jpg',
                'status' => 'active',
            ],
            [
                'location_id' => 1,
                'name' => 'Herbal Facial Kit',
                'description' => 'Get Best Herbal Facial Kit in Best Price',
                'price' => '100',
                'image' => '["hair.jpg"]',
                'default_image' => 'hair.jpg',
                'status' => 'active',
            ],
            [
                'location_id' => 1,
                'name' => 'Hair Dye Brush',
                'description' => 'Get Best Hair Dye Brush in Best Price',
                'price' => '100',
                'image' => '["hair.jpg"]',
                'default_image' => 'hair.jpg',
                'status' => 'active',
            ],
            [
                'location_id' => 1,
                'name' => 'Wooden Hair Brush',
                'description' => 'Get Best Wooden Hair Brush in Best Price',
                'price' => '100',
                'image' => '["hair.jpg"]',
                'default_image' => 'hair.jpg',
                'status' => 'active',
            ],
            [
                'location_id' => 2,
                'name' => 'Home Spa Kit',
                'description' => 'Get Best Home Spa Kit in Best Price',
                'price' => '100',
                'image' => '["hair.jpg"]',
                'default_image' => 'hair.jpg',
                'status' => 'active',
            ],
            [
                'location_id' => 2,
                'name' => 'Makeup Brush',
                'description' => 'Get Best Makeup Brush in Best Price',
                'price' => '100',
                'image' => '["hair.jpg"]',
                'default_image' => 'hair.jpg',
                'status' => 'active',
            ],
            [
                'location_id' => 3,
                'name' => 'Hair Dryer',
                'description' => 'Get Best Hair Dryer in Best Price',
                'price' => '100',
                'image' => '["hair.jpg"]',
                'default_image' => 'hair.jpg',
                'status' => 'active',
            ]
        ]);

        $path = base_path('public/user-uploads/' . 'product' . '/');

        if (!File::isDirectory($path)) {
            File::makeDirectory($path);
        }

        $path1 = base_path('public/user-uploads/' . 'product' . '/' . '1' . '/');

        if (!File::isDirectory($path1)) {
            File::makeDirectory($path1);
        }

        File::copy(public_path('img/banner/slide-1.jpeg'), public_path('user-uploads/product/1/slide-1.jpeg'));

        $tax = Tax::active()->first();
        $products = Product::all();

        if ($products && $tax) {
            foreach ($products as $product) {
                $taxServices = new ItemTax();
                $taxServices->tax_id = $tax->id;
                $taxServices->service_id = null;
                $taxServices->deal_id = null;
                $taxServices->product_id = $product->id;
                $taxServices->save();
            }
        }
    }

}
