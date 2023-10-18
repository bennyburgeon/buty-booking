<?php

use App\BookingTime;
use App\Tax;
use App\Media;
use App\ItemTax;
use App\Category;
use App\Location;
use App\BusinessService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CategorySeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /* remove all files from user-uploads */
        /* $file = new Filesystem;
        $file->cleanDirectory(public_path('user-uploads')); */

        $location_arr = [1,2];
        $types = ['online', 'offline'];

        Media::insert([
            [
                'file_name' => 'slide-1.jpeg',
                'title_note' => null,
                'section_title' => null,
                'section_content' => null,
                'have_content' => null,
                'content_alignment' => null,
                'is_section_content' => 'no',
            ],
            [
                'file_name' => 'slide-2.jpeg',
                'title_note' => null,
                'section_title' => null,
                'section_content' => null,
                'have_content' => null,
                'content_alignment' => null,
                'is_section_content' => 'no',
            ]
        ]);

        $userFolder = base_path('public/' . 'user-uploads' . '/');

        if (!File::isDirectory($userFolder)) {
            File::makeDirectory($userFolder);
        }

        $path = base_path('public/user-uploads/' . 'sliders' . '/');

        if (!File::isDirectory($path)) {
            File::makeDirectory($path);
        }

        File::copy(public_path('front/images/hair.jpg'), public_path('user-uploads/sliders/section_image.jpg'));
        File::copy(public_path('front/images/hair-color.jpg'), public_path('user-uploads/sliders/section_image_1.jpg'));

        Location::insert([
            ['name' => 'New York, USA'],
            ['name' => 'California, USA'],
        ]);

        Category::insert([
            ['name' => 'Hair', 'slug' => 'hair', 'image' => 'hair.jpg'],
            ['name' => 'Nails', 'slug' => 'nails', 'image' => 'nails.png'],
            ['name' => 'Body', 'slug' => 'body', 'image' => 'hair-spa.jpg'],
        ]);


        $catPath = base_path('public/user-uploads/' . 'category' . '/');

        if (!File::isDirectory($catPath)) {
            File::makeDirectory($catPath);
        }

        File::copy(public_path('front/images/hair.jpg'), public_path('user-uploads/category/hair.jpg'));
        File::copy(public_path('front/images/nails.png'), public_path('user-uploads/category/nails.png'));
        File::copy(public_path('front/images/hair-spa.jpg'), public_path('user-uploads/category/hair-spa.jpg'));

        BusinessService::insert([
            [
                'name' => 'Hair Cut',
                'slug' => 'hair-cut',
                'description' => 'Get Best Hair cut',
                'price' => '10',
                'time' => '30',
                'time_type' => 'minutes',
                'discount' => '0.00',
                'image' => '["hair.jpg"]',
                'default_image' => 'hair.jpg',
                'discount_type' => 'percent',
                'service_type' => Arr::random($types),
                'category_id' => 1,
                'location_id' => Arr::random($location_arr),
            ],
            [
                'name' => 'Hair Spa',
                'slug' => 'hair-spa',
                'description' => 'Get Best Hair spa',
                'price' => '20',
                'time' => '30',
                'time_type' => 'minutes',
                'discount' => '0.00',
                'image' => '["hair-spa.jpg"]',
                'default_image' => 'hair-spa.jpg',
                'discount_type' => 'percent',
                'service_type' => Arr::random($types),
                'category_id' => 1,
                'location_id' => Arr::random($location_arr),
            ],
            [
                'name' => 'Hair Coloring',
                'slug' => 'hair-coloring',
                'description' => 'Get Best Hair color',
                'price' => '20',
                'time' => '30',
                'time_type' => 'minutes',
                'discount' => '0.00',
                'image' => '["hair-spa.jpg"]',
                'default_image' => 'hair-spa.jpg',
                'discount_type' => 'percent',
                'service_type' => Arr::random($types),
                'category_id' => 1,
                'location_id' => Arr::random($location_arr),
            ],
            [
                'name' => 'Manicure',
                'slug' => 'manicure',
                'description' => 'Get Best manicure',
                'price' => '50',
                'time' => '20',
                'time_type' => 'minutes',
                'discount' => '0.00',
                'image' => '["nails.png"]',
                'default_image' => 'nails.png',
                'discount_type' => 'percent',
                'service_type' => Arr::random($types),
                'category_id' => 2,
                'location_id' => Arr::random($location_arr),
            ],
            [
                'name' => 'Pedicure',
                'slug' => 'pedicure',
                'description' => 'Get Best Pedicure',
                'price' => '5',
                'time' => '20',
                'time_type' => 'minutes',
                'discount' => '0.00',
                'image' => '["nails.png"]',
                'default_image' => 'nails.png',
                'discount_type' => 'percent',
                'service_type' => Arr::random($types),
                'category_id' => 2,
                'location_id' => Arr::random($location_arr),
            ],
            [
                'name' => 'Waxing',
                'slug' => 'waxing',
                'description' => 'Get Best waxing',
                'price' => '9',
                'time' => '20',
                'time_type' => 'minutes',
                'discount' => '0.00',
                'image' => '["hair.jpg"]',
                'default_image' => 'hair.jpg',
                'discount_type' => 'percent',
                'service_type' => Arr::random($types),
                'category_id' => 2,
                'location_id' => Arr::random($location_arr),
            ],
            [
                'name' => 'Deep Tissue Massage',
                'slug' => 'deep-tissue-massage',
                'description' => 'Get Best massage',
                'price' => '30',
                'time' => '50',
                'time_type' => 'minutes',
                'discount' => '0.00',
                'image' => '["hair.jpg"]',
                'default_image' => 'hair.jpg',
                'discount_type' => 'percent',
                'service_type' => Arr::random($types),
                'category_id' => 2,
                'location_id' => Arr::random($location_arr),
            ]
        ]);

        $serviceLocations = BusinessService::select('location_id')->distinct()->get();

        foreach ($serviceLocations as $serviceLocation)
        {
            $bookingTimes = BookingTime::where('location_id', $serviceLocation->location_id)->count();

            if($bookingTimes === 0)
            {
                $booking_times = [];
                $weekdays = [
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday',
                ];

                foreach ($weekdays as $weekday) {
                    $booking_times[] = [
                        'location_id' => $serviceLocation->location_id,
                        'day' => $weekday,
                        'start_time' => Carbon::parse('09:00:00')->setTimezone('UTC'),
                        'end_time' => Carbon::parse('18:00:00')->setTimezone('UTC'),
                    ];
                }

                BookingTime::insert($booking_times);
            }
        }

        $path = base_path('public/user-uploads/' . 'service' . '/');

        if (!File::isDirectory($path)) {
            File::makeDirectory($path);
        }

        $path1 = base_path('public/user-uploads/' . 'service' . '/' . '1' . '/');

        if (!File::isDirectory($path1)) {
            File::makeDirectory($path1);
        }

        File::copy(public_path('front/images/hair.jpg'), public_path('user-uploads/service/1/hair.jpg'));

        $path2 = base_path('public/user-uploads/' . 'service' . '/' . '2' . '/');

        if (!File::isDirectory($path2)) {
            File::makeDirectory($path2);
        }

        File::copy(public_path('front/images/hair-spa.jpg'), public_path('user-uploads/service/2/hair-spa.jpg'));

        $path3 = base_path('public/user-uploads/' . 'service' . '/' . '3' . '/');

        if (!File::isDirectory($path3)) {
            File::makeDirectory($path3);
        }

        File::copy(public_path('front/images/hair-spa.jpg'), public_path('user-uploads/service/3/hair-spa.jpg'));

        $path4 = base_path('public/user-uploads/' . 'service' . '/' . '4' . '/');

        if (!File::isDirectory($path4)) {
            File::makeDirectory($path4);
        }

        File::copy(public_path('front/images/nails.png'), public_path('user-uploads/service/4/nails.png'));

        $path5 = base_path('public/user-uploads/' . 'service' . '/' . '5' . '/');

        if (!File::isDirectory($path5)) {
            File::makeDirectory($path5);
        }

        File::copy(public_path('front/images/nails.png'), public_path('user-uploads/service/5/nails.png'));

        $path6 = base_path('public/user-uploads/' . 'service' . '/' . '6' . '/');

        if (!File::isDirectory($path6)) {
            File::makeDirectory($path6);
        }

        File::copy(public_path('front/images/hair.jpg'), public_path('user-uploads/service/6/hair.jpg'));

        $path7 = base_path('public/user-uploads/' . 'service' . '/' . '7' . '/');

        if (!File::isDirectory($path7)) {
            File::makeDirectory($path7);
        }

        File::copy(public_path('front/images/hair.jpg'), public_path('user-uploads/service/7/hair.jpg'));


        $tax = Tax::active()->first();
        $services = BusinessService::all();

        if ($services && $tax) {
            foreach ($services as $key => $value) {
                $taxServices = new ItemTax();
                $taxServices->tax_id = $tax->id;
                $taxServices->service_id = $value->id;
                $taxServices->deal_id = null;
                $taxServices->product_id = null;
                $taxServices->save();
            }
        }

    }

}
