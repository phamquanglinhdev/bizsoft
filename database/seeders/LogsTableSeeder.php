<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LogsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('logs')->delete();
        
        \DB::table('logs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'grade_id' => 7,
                'lesson' => 'Lesson 1: Greeting',
                'date' => '2023-02-08',
                'start' => '19:20:00',
                'end' => '19:40:00',
                'salary_per_hour' => 250000,
                'video' => '{"provider":"vimeo","id":794298261,"title":"Georgia Astle: Flip The Switch","image":"https://i.vimeocdn.com/video/1601069461-cdecaebd9f6835016ede164143ec5a4c733982479ed6c628229fc463fa178abd-d_640","url":"https://vimeo.com/794298261"}',
                'question' => 'Video chào những người xung quanh bằng tiếng Anh',
                'teacher_comment' => 'Bé Học Bài Nhanh, Có tư duy tốt',
                'teacher_id' => 2,
                'created_at' => '2023-02-08 12:22:47',
                'updated_at' => '2023-02-08 12:22:47',
            ),
            1 => 
            array (
                'id' => 2,
                'grade_id' => 7,
                'lesson' => 'Lesson 2: Simple Tense',
                'date' => '2023-02-08',
                'start' => '22:24:00',
                'end' => '22:40:00',
                'salary_per_hour' => 250000,
                'video' => '{"provider":"vimeo","id":794298261,"title":"Georgia Astle: Flip The Switch","image":"https://i.vimeocdn.com/video/1601069461-cdecaebd9f6835016ede164143ec5a4c733982479ed6c628229fc463fa178abd-d_640","url":"https://vimeo.com/794298261"}',
                'question' => NULL,
                'teacher_comment' => NULL,
                'teacher_id' => 2,
                'created_at' => '2023-02-08 12:24:33',
                'updated_at' => '2023-02-08 12:24:33',
            ),
            2 => 
            array (
                'id' => 3,
                'grade_id' => 9,
                'lesson' => 'Lesson 1: Greeting',
                'date' => '2023-02-08',
                'start' => '19:27:00',
                'end' => '20:26:00',
                'salary_per_hour' => 300000,
                'video' => '{"provider":"youtube","id":"Fw0rdSHzWFY","title":"Theme 1. Greeting - Good morning. Good bye. | ESL Song & Story - Learning English for Kids","image":"https://i.ytimg.com/vi/Fw0rdSHzWFY/maxresdefault.jpg","url":"https://www.youtube.com/watch?v=Fw0rdSHzWFY"}',
                'question' => NULL,
                'teacher_comment' => NULL,
                'teacher_id' => 6,
                'created_at' => '2023-02-08 12:25:53',
                'updated_at' => '2023-02-08 12:25:53',
            ),
            3 => 
            array (
                'id' => 4,
                'grade_id' => 8,
                'lesson' => 'Lesson 1: Greeting',
                'date' => '2023-02-03',
                'start' => '22:58:00',
                'end' => '22:58:00',
                'salary_per_hour' => 300000,
                'video' => '{"provider":"youtube","id":"Fw0rdSHzWFY","title":"Theme 1. Greeting - Good morning. Good bye. | ESL Song & Story - Learning English for Kids","image":"https://i.ytimg.com/vi/Fw0rdSHzWFY/maxresdefault.jpg","url":"https://www.youtube.com/watch?v=Fw0rdSHzWFY"}',
                'question' => NULL,
                'teacher_comment' => NULL,
                'teacher_id' => 2,
                'created_at' => '2023-02-08 12:58:43',
                'updated_at' => '2023-02-08 12:58:43',
            ),
        ));
        
        
    }
}