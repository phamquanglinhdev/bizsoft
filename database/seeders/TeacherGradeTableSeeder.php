<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TeacherGradeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('teacher_grade')->delete();
        
        \DB::table('teacher_grade')->insert(array (
            0 => 
            array (
                'teacher_id' => 2,
                'grade_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'teacher_id' => 2,
                'grade_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'teacher_id' => 6,
                'grade_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'teacher_id' => 6,
                'grade_id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}