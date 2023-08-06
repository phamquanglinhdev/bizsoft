<?php

namespace App\Repositories\Eloquent;

use App\Models\Student;
use App\Repositories\StudentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use TimWassenburg\RepositoryGenerator\Repository\BaseRepository;

/**
 * Class StudentRepository.
 */
class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Student $model
     */
    public function __construct(Student $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $attributes
     * @return Model|Builder currentPage
     * currentPage
     * endRecord
     * perPage
     * startRecord
     * totalPage
     */
    public function filter(array $attributes): Model|Builder
    {
        $query = $this->model->newQuery();
        if (isset($attributes["name"])) {
            $name = $attributes["name"];
            $query->where("name", "like", "%$name%");
        }
        if (isset($attributes["parent_name"])) {
            $name = $attributes["parent_name"];
            $query->where("parent", "like", "%$name%");
        }
        if (isset($attributes["phone"])) {
            $name = $attributes["phone"];
            $query->where("phone", "like", "%$name%");
        }
        return $query->orderBy("created_at", "DESC");
    }

    public function getTotalRecord($attributes): int
    {
        return $this->filter($attributes)->count();
    }

    public function getStudentList(array $attributes): Collection
    {
        if ($attributes["perPage"] === "-1") {
            return $this->filter($attributes)->get();
        } else {
            return $this->filter($attributes)->skip($attributes["startRecord"])->take($attributes["perPage"])->get();
        }
    }

    public function getForClassroom(): Collection|array
    {
        return $this->model->newQuery()->get();
    }
}
