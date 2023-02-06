<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GradeRequest;
use App\Models\Grade;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Prologue\Alerts\Facades\Alert;

/**
 * Class GradeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class GradeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
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

}
