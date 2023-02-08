<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StudentGradeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('student_grade')->delete();
        
        \DB::table('student_grade')->insert(array (
            0 => 
            array (
                'student_id' => 4,
                'grade_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'student_id' => 4,
                'grade_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'student_id' => 4,
                'grade_id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}