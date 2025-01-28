<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        About::create([
            'title' => 'About Us',
            'description' => 'Learn more about our company.',
            'content' => 'Welcome to our About Us page. Here, you can find information about our company and our mission.'
        ]);
    }
}
