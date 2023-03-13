<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LogRequest;
use App\Models\Grade;
use App\Models\Student;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

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
        $this->crud->disableResponsiveTable();
        if (backpack_user()->role != "admin") {
            $role = backpack_user()->role;
            $this->crud->query
                ->join("grades", "logs.grade_id", "grades.id")
                ->join($role . "_grade", $role . "_grade.grade_id", "grades.id")
                ->where($role . "_grade." . $role . "_id", backpack_user()->id);
        }
        CRUD::column('grade')->label("Lớp học")->wrapper([
            'href' => function ($crud, $column, $entry, $related_key) {
                return backpack_url('grade/' . $related_key . '/show');
            },
        ]);
        CRUD::column('lesson')->label("Bài học");
        CRUD::column('frequency_table')->type("model_function")->function_name("frequency")->label("Sĩ số lớp");
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
        CRUD::setValidation(LogRequest::class);
        if (isset($_REQUEST["grade_id"])) {
            $grade = Grade::where("id", $_REQUEST["grade_id"])->first();
            if (!isset($grade->id)) {
                CRUD::addField([
                    'name' => 'grade_id',
                    'type' => 'select2',
                    'label' => 'Chọn lớp để điểm danh',
                    'wrapper' => [
                        'onchange' => "changeGrade($('select[name=grade_id]').val())"
                    ],
                ]);
            } else {
                CRUD::field('grade_id')->value($_REQUEST["grade_id"])->type("hidden");
                if (backpack_user()->role != "teacher") {
                    CRUD::addField([
                        'label' => 'Giáo viên',
                        'name' => 'teacher_id',
                        'type' => 'relationship',
                        'entity' => 'Teacher',
                        'attribute' => 'name',
                        'options' => (function ($query) {
                            return $query->whereHas("grades", function (Builder $builder) {
                                $builder->where("id", $_REQUEST["grade_id"]);
                            });
                        }),
                    ]);
                } else {
                    CRUD::field('teacher_id')->value(backpack_user()->id);
                }
                CRUD::field('lesson')->label("Bài học");
                CRUD::field('date')->label("Ngày")->wrapper(["class" => "col-md-4 mb-2"])->default(Carbon::now());
                CRUD::field('start')->label("Bắt đầu")->wrapper(["class" => "col-md-4 mb-2"]);
                CRUD::field('end')->label("Kết thuc")->wrapper(["class" => "col-md-4 mb-2"]);;
                CRUD::addField([   // select_and_order
                    'name' => 'students',
                    'label' => 'Học sinh tham gia (Kéo vào)',
                    'type' => 'select_and_order',
                    'options' => Student::whereHas("grades", function (Builder $builder) use ($grade) {
                        $builder->where("id", $grade->id);
                    })->get()->pluck("name")->toArray(),
                ]);
                CRUD::field('salary_per_hour')->type("number")->label("Lương theo giờ")->wrapper(["class" => "col-md-6 mb-2"])->suffix(" đ");;
                CRUD::field('video')->type("video")->label("Video bài học")->wrapper(["class" => "col-md-6 mb-2"]);
                CRUD::field('teacher_comment')->label("Giáo viên nhận xét về buổi học");
                CRUD::field('question')->label("Bài tập của giáo viên");
            }
        } else {
            if (backpack_user()->role != "admin") {
                CRUD::addField([
                    'name' => 'grade_id',
                    'type' => 'select2',
                    'label' => 'Chọn lớp để điểm danh',
                    'wrapper' => [
                        'onchange' => "changeGrade($('select[name=grade_id]').val())"
                    ],
                    'options' => (function ($query) {
                        return $query->join("staff_grade", "staff_grade.grade_id", 'grades.id')
                            ->where("staff_grade.staff_id", backpack_user()->id)
                            ->get();
                    }),
                ]);
            } else {
                CRUD::addField([
                    'name' => 'grade_id',
                    'type' => 'select2',
                    'label' => 'Chọn lớp để điểm danh',
                    'wrapper' => [
                        'onchange' => "changeGrade($('select[name=grade_id]').val())"
                    ],
                ]);
            }
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
        $_REQUEST["grade_id"] = $this->crud->getCurrentEntry()->grade->id;
        $this->setupCreateOperation();
    }
}
