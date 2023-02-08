<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StaffGradeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('staff_grade')->delete();
        
        \DB::table('staff_grade')->insert(array (
            0 => 
            array (
                'staff_id' => 5,
                'grade_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'staff_id' => 3,
                'grade_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'staff_id' => 3,
                'grade_id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}