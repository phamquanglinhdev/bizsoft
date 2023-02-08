<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('migrations')->delete();
        
        \DB::table('migrations')->insert(array (
            0 => 
            array (
                'id' => 47,
                'migration' => '2014_10_12_000000_create_users_table',
                'batch' => 1,
            ),
            1 => 
            array (
                'id' => 48,
                'migration' => '2014_10_12_100000_create_password_resets_table',
                'batch' => 1,
            ),
            2 => 
            array (
                'id' => 49,
                'migration' => '2019_08_19_000000_create_failed_jobs_table',
                'batch' => 1,
            ),
            3 => 
            array (
                'id' => 50,
                'migration' => '2019_12_14_000001_create_personal_access_tokens_table',
                'batch' => 1,
            ),
            4 => 
            array (
                'id' => 51,
                'migration' => '2023_02_05_133745_create_grades_table',
                'batch' => 1,
            ),
            5 => 
            array (
                'id' => 52,
                'migration' => '2023_02_06_071505_create_logs_table',
                'batch' => 1,
            ),
            6 => 
            array (
                'id' => 53,
                'migration' => '2023_02_08_062038_create_posts_table',
                'batch' => 1,
            ),
            7 => 
            array (
                'id' => 54,
                'migration' => '2023_02_08_092241_create_staff_grade_table',
                'batch' => 1,
            ),
            8 => 
            array (
                'id' => 55,
                'migration' => '2023_02_08_102722_create_teacher_grade_table',
                'batch' => 1,
            ),
            9 => 
            array (
                'id' => 56,
                'migration' => '2023_02_08_102739_create_student_grade_table',
                'batch' => 1,
            ),
        ));
        
        
    }
}