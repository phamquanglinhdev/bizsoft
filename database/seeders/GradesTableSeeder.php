<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GradesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('grades')->delete();
        
        \DB::table('grades')->insert(array (
            0 => 
            array (
                'id' => 7,
                'name' => 'C001',
                'link' => 'none',
                'pricing' => 1900000,
                'information' => NULL,
                'times' => '[{"day":"","start":"","end":""}]',
                'status' => 0,
                'disable' => 0,
                'thumbnail' => 'https://static.vecteezy.com/system/resources/previews/010/090/153/non_2x/back-to-school-square-frame-with-classic-yellow-pencil-with-eraser-on-it-the-pencils-are-arranged-in-a-circle-against-a-green-school-chalkboard-illustration-design-with-copy-space-free-vector.jpg',
                'created_at' => '2023-02-08 10:22:48',
                'updated_at' => '2023-02-08 10:22:48',
            ),
            1 => 
            array (
                'id' => 8,
                'name' => 'C002',
                'link' => 'none',
                'pricing' => 1900000,
                'information' => NULL,
                'times' => '[{"day":"","start":"","end":""}]',
                'status' => 0,
                'disable' => 0,
                'thumbnail' => 'https://static.vecteezy.com/system/resources/previews/010/090/153/non_2x/back-to-school-square-frame-with-classic-yellow-pencil-with-eraser-on-it-the-pencils-are-arranged-in-a-circle-against-a-green-school-chalkboard-illustration-design-with-copy-space-free-vector.jpg',
                'created_at' => '2023-02-08 11:35:32',
                'updated_at' => '2023-02-08 11:35:32',
            ),
            2 => 
            array (
                'id' => 9,
                'name' => 'C003',
                'link' => 'none',
                'pricing' => 2000000,
                'information' => NULL,
                'times' => '[{"day":"","start":"","end":""}]',
                'status' => 0,
                'disable' => 0,
                'thumbnail' => 'https://static.vecteezy.com/system/resources/previews/010/090/153/non_2x/back-to-school-square-frame-with-classic-yellow-pencil-with-eraser-on-it-the-pencils-are-arranged-in-a-circle-against-a-green-school-chalkboard-illustration-design-with-copy-space-free-vector.jpg',
                'created_at' => '2023-02-08 12:19:25',
                'updated_at' => '2023-02-08 12:19:25',
            ),
        ));
        
        
    }
}