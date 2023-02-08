<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('posts')->delete();
        
        \DB::table('posts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Chào mừng đến với BIZSOFT',
            'document' => '<p>Tạo các tài khoản học sinh , giáo viên, nhân viên tương ứng</p><p>- Tài khoản nhân viên có thể tạo "Lớp", điểm danh hộ giáo viên trong phần&nbsp; "Nhật ký" ( lớp mà nhân viên đó quản lý)<br>- Tài khoản giáo viên có thể xem nhật ký, điểm danh lớp ( lớp giáo viên được thêm)<br>- Tài khoản học sinh có thể xem nhật ký (lớp mà học sinh được thêm)</p><p>Nhân viên có thể thêm học sinh ( mặc định sẽ thành học sinh do giáo viên đó quản lý)<br>Nhân viên có thể thêm tài khoản giáo viên<br>Nhân viên có thể tạo lớp ( mặc định sẽ thành lớp nhân viên đó quản lý)</p><p>Admin có thể tạo tất cả các tài khoản, thực hiện tất cả các quyền trên</p><p>Nếu phát hiện lỗi trong phần mềm, vui lòng gửi về form:&nbsp;<a href="https://forms.gle/gNcTmEKihGtenPEM8" target="_blank">https://forms.gle/gNcTmEKihGtenPEM8</a></p>',
                'roles' => '["staff","teacher","student"]',
                'pin' => 1,
                'created_at' => '2023-02-08 10:42:58',
                'updated_at' => '2023-02-08 10:42:58',
            ),
        ));
        
        
    }
}