<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PostCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PostCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Post::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/post');
        CRUD::setEntityNameStrings('Bài viết', 'Bài viết');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'title',
            'label' => 'Tiêu đề'
        ]);
        CRUD::addColumn([
            'name' => 'roles',
            'label' => 'Hiển thị với',
            'type' => 'array',
        ]);
        CRUD::addColumn([
            'name' => 'pin',
            'label' => 'Ghim lên đầu',
            'type' => 'check'
        ]);
        CRUD::addColumn([
            'name' => 'updated_at',
            'label' => 'Ngày cập nhật',
            'type' => 'date'
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
        CRUD::setValidation(PostRequest::class);
        CRUD::addField([
            'name' => 'title',
            'label' => 'Tiêu đề'
        ]);
        CRUD::addField([
            'name' => 'pin',
            'type' => 'radio',
            'label' => 'Ghim',
            'options' => [
                'Không',
                'Có'
            ]
        ]);
        CRUD::addField([
            'name' => 'roles',
            'label' => 'Hiển thị với',
            'type' => 'select2_from_array',
            'options' => [
                'staff' => 'Nhân viên',
                'teacher' => 'Giáo viên',
                'student' => 'Học sinh'
            ],
            'allows_multiple' => true,
        ]);
        CRUD::addField([
            'name' => 'document',
            'label' => 'Nội dung',
            'type' => 'summernote'
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
}
