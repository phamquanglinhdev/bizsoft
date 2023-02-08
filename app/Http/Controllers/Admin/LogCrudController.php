<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LogRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Carbon\Carbon;

/**
 * Class LogCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LogCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Log::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/log');
        CRUD::setEntityNameStrings('Nhật ký', 'Nhật ký');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('grade')->label("Lớp học")->wrapper([
            'href' => function ($crud, $column, $entry, $related_key) {
                return backpack_url('grade/' . $related_key . '/show');
            },
        ]);
        CRUD::column('lesson')->label("Bài học");
        CRUD::column('teacher')->label("Giáo viên");
        CRUD::column('date')->label("Ngày")->type("date");
        CRUD::column('start')->label("Bắt đầu")->type("time");
        CRUD::column('end')->label("Kết thúc")->type("time");
        CRUD::column('salary_per_hour')->label("Lương theo giờ")->type("number")->suffix("đ");
        CRUD::column('video')->type("video");

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
        $this->crud->addFilter([
            'name' => 'status',
            'type' => 'select2',
            'label' => 'Status'
        ], function () {
            return [
                1 => 'In stock',
                2 => 'In provider stock',
                3 => 'Available upon ordering',
                4 => 'Not available',
            ];
        }, function ($value) { // if the filter is active
            // $this->crud->addClause('where', 'status', $value);
        });
        CRUD::setValidation(LogRequest::class);
        if (isset($_REQUEST["grade_id"])) {
            CRUD::field('grade_id')->value($_REQUEST["grade_id"])->type("hidden");
            if (backpack_user()->role != "teacher") {
                CRUD::addField([
                    'label' => 'Giáo viên',
                    'name' => 'teacher_id',
                    'type' => 'select2',
                    'entity' => 'Teacher',
                    'attribute' => 'name',
                    'options' => (function ($query) {
                        return $query->join("teacher_grade", "teacher_grade.teacher_id", "users.id")
                            ->where("teacher_grade.grade_id", $_REQUEST["grade_id"])
                            ->where('users.role', "teacher")
                            ->get();
                    }),
                ]);
            } else {
                CRUD::field('teacher_id')->value(backpack_user()->id);
            }
            CRUD::field('lesson')->label("Bài học");
            CRUD::field('date')->label("Ngày")->wrapper(["class" => "col-md-4 mb-2"])->default(Carbon::now());
            CRUD::field('start')->label("Bắt đầu")->wrapper(["class" => "col-md-4 mb-2"]);
            CRUD::field('end')->label("Kết thuc")->wrapper(["class" => "col-md-4 mb-2"]);;
            CRUD::field('salary_per_hour')->type("number")->label("Lương theo giờ")->wrapper(["class" => "col-md-6 mb-2"])->suffix(" đ");;
            CRUD::field('video')->type("video")->label("Video bài học")->wrapper(["class" => "col-md-6 mb-2"]);
            CRUD::field('teacher_comment')->label("Giáo viên nhận xét về buổi học");
            CRUD::field('question')->label("Bài tập của giáo viên");
        } else {
            CRUD::addField([
                'name' => 'grade_id',
                'type' => 'select2',
                'label' => 'Chọn lớp để điểm danh',
                'wrapper' => [
                    'onchange' => "changeGrade($('select[name=grade_id]').val())"
                ]
            ]);
        }
        Widget::add()->type('script')->content(asset("js/grades.js"));


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
}
