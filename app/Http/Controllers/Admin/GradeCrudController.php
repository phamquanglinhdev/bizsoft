<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GradeRequest;
use App\Models\Grade;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\Facades\Alert;

/**
 * Class GradeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class GradeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }

    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Grade::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/grade');
        CRUD::setEntityNameStrings('Lớp học', 'Danh sách lớp học');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if (backpack_user()->role != "admin") {
            $pivotTable = backpack_user()->role . "_grade";
            $pivotForeignId = backpack_user()->role . "_id";
            $pivotLocal = $pivotTable . ".grade_id";
            $pivotForeign = "$pivotTable.$pivotForeignId";
            $this->crud->query->join($pivotTable, $pivotLocal, "grades.id")
                ->where("$pivotForeign", backpack_user()->id)
                ->get();
        }

        if (session("success")) {
            Alert::success(session("success"));
        }
        $this->crud->addClause("where", "disable", 0);
        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Tên lớp',
        ]);

        CRUD::addColumn([
            'name' => 'thumbnail',
            'label' => 'Ảnh minh họa',
            'type' => 'image',
        ]);
        CRUD::addColumn([
            'name' => 'staffs',
            'label' => 'Nhân viên quản lý',
        ]);
        CRUD::addColumn([
            'name' => 'teachers',
            'label' => 'Giáo viên',
        ]);
        CRUD::addColumn([
            'name' => 'students',
            'label' => 'Học sinh',
        ]);
        CRUD::addColumn([
            'name' => 'pricing',
            'label' => 'Gói học phí',
            'type' => 'number',
            'suffix' => ' đ',
        ]);
        CRUD::addColumn([
            'name' => 'link',
            'label' => 'Link lớp học',
            'type' => 'link',
        ]);

        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Trạng thái',
            'type' => 'select_from_array',
            'options' => [
                'Đang học',
                'Đã kết thúc',
                'Đang bảo lưu'
            ],
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(GradeRequest::class);
        CRUD::addField([
            'name' => 'name',
            'label' => 'Tên lớp',
        ]);
        CRUD::addField([
            'name' => 'thumbnail',
            'label' => 'Ảnh minh họa',
            'default' => 'https://static.vecteezy.com/system/resources/previews/010/090/153/non_2x/back-to-school-square-frame-with-classic-yellow-pencil-with-eraser-on-it-the-pencils-are-arranged-in-a-circle-against-a-green-school-chalkboard-illustration-design-with-copy-space-free-vector.jpg',
            'type' => 'image',
            'crop' => true,
            'aspect_ratio' => 1,
        ]);
        if (backpack_user()->role == "admin") {
            CRUD::addField([
                'name' => 'staffs',
                'label' => 'Nhân viên',
                'type' => 'relationship',
                'model' => 'App\Models\Staff',
                'entity' => 'Staffs',
                'attribute' => 'name',
                'pivot' => true,
                'options' => (function ($query) {
                    return $query->orderBy('name', 'ASC')->where('role', "staff")->get();
                }),
            ]);
        }
        CRUD::addField([
            'name' => 'teachers',
            'label' => 'Giáo viên',
            'type' => 'relationship',
            'model' => 'App\Models\Teacher',
            'entity' => 'Teachers',
            'attribute' => 'name',
            'pivot' => true,
            'options' => (function ($query) {
                return $query->orderBy('name', 'ASC')->where('role', "teacher")->get();
            }),
        ]);
        CRUD::addField([
            'name' => 'students',
            'label' => 'Học sinh',
            'type' => 'relationship',
            'model' => 'App\Models\Student',
            'entity' => 'Students',
            'attribute' => 'name',
            'pivot' => true,
            'options' => (function ($query) {
                return $query->orderBy('name', 'ASC')->where('role', "student")->get();
            }),
        ]);
        CRUD::addField([
            'name' => 'link',
            'label' => 'Link lớp học'
        ]);
        CRUD::addField([
            'name' => 'pricing',
            'label' => 'Gói học phí',
            'type' => 'number',
            'suffix' => 'đ',
            'wrapper' => ['class' => 'col-md-6 mb-2']
        ]);
        CRUD::addField([
            'name' => 'status',
            'label' => 'Trạng thái',
            'type' => 'select_from_array',
            'options' => [
                'Đang học',
                'Đã kết thúc',
                'Đang bảo lưu'
            ],
            'wrapper' => ['class' => 'col-md-6 mb-2']
        ]);
        CRUD::addField([
            'name' => 'times',
            'label' => 'Lịch học',
            'type' => 'repeatable',
            'fields' => [
                [
                    'name' => 'day',
                    'label' => "Ngày trong tuần",
                    'type' => 'select2_from_array',
                    'options' => [
                        'monday' => 'Thứ 2',
                        'tuesday' => 'Thứ 3',
                        'wednesday' => 'Thứ 4',
                        'thursday' => 'Thứ 5',
                        'friday' => 'Thứ 6',
                        'saturday' => 'Thứ 7',
                        'sunday' => 'Chủ nhật',
                    ],
                    'wrapper' => ['class' => 'col-md-6 mb-2']
                ],
                [
                    'name' => 'start',
                    'type' => 'time',
                    'label' => 'Bắt đầu',
                    'wrapper' => ['class' => 'col-md-3 mb-2']
                ],
                [
                    'name' => 'end',
                    'type' => 'time',
                    'label' => 'Kết thúc',
                    'wrapper' => ['class' => 'col-md-3 mb-2']
                ]
            ],
            'new_item_label' => 'Thêm lịch'
        ]);
        CRUD::addField([
            'name' => 'information',
            'label' => 'Thông tin thêm',
            'type' => 'summernote',
        ]);


        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }


    protected function setupShowOperation()
    {
//        $this->crud->addColumn([
//            'name' => 'thumbnail',
//            'label' => false,
//            'type' => 'image'
//        ]);
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Tên lớp',
        ]);
        $this->crud->addColumn([
            'name' => 'pricing',
            'label' => 'Gói học phí',
            'type' => 'number',
            'suffix' => ' đ',
        ]);
        $this->crud->addColumn([
            'name' => 'information',
            'label' => 'Thông tin',
            'type' => 'html',
        ]);
        $this->crud->addColumn([
            'name' => 'link',
            'label' => 'Link lớp học',
            'type' => 'link',
        ]);
        $this->crud->addColumn([
            'name' => 'times',
            'label' => 'Lịch học',
            'type' => 'json_view',
        ]);
        Widget::add([
            'type' => 'relation_table',
            'name' => 'logs',
            'button' => true,
            'label' => 'Nhật ký của lớp',
            'backpack_crud' => 'log',
            'visible' => function ($entry) {
                return $entry->logs->count() > 0;
            },
            'search' => function ($query, $search) {
                return $query->where('lesson', 'like', "%{$search}%");
            },
            'relation_attribute' => 'grade_id',
            'button_create' => true,
            'button_delete' => false,
            'columns' => [
                [
                    'label' => 'Bài học',
                    'name' => 'lesson',
                ],
                [
                    'label' => 'Ngày',
                    'name' => 'date',
                ],
                [
                    'label' => 'Bắt đầu',
                    'name' => 'start',
                ],
                [
                    'label' => 'Kết thúc',
                    'name' => 'end',
                ],
                [
                    'label' => 'Lương theo giờ',
                    'name' => 'salary_per_hour',
                    'type' => 'number',
                    'suffix' => 'đ',
                ],
                [
                    'label' => 'Video',
                    'name' => 'video',
                    'type' => 'video'
                ],
            ],
        ])->to('after_content');
    }

    protected function destroy($id)
    {
        Grade::find($id)->update(["disable" => 1]);
        return redirect(backpack_url("/grade/"))->with("success", "Xóa thành công !");
    }

    public function store()
    {
        $response = $this->traitStore();
        if (backpack_user()->role == "staff") {
            $id = Grade::orderBy("id", "DESC")->first()->id;
            DB::table("staff_grade")->insert([
                'grade_id' => $id,
                'staff_id' => backpack_user()->id
            ]);
        }
        return $response;
    }
}
