<?php

namespace App\Repositories\Eloquent;

use App\Models\Teacher;
use App\Repositories\TeacherRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use TimWassenburg\RepositoryGenerator\Repository\BaseRepository;

/**
 * Class TeacherRepository.
 */
class TeacherRepository extends BaseRepository implements TeacherRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Teacher $model
     */
    public function __construct(Teacher $model)
    {
        parent::__construct($model);
    }

    public function getForClassroom(): Collection|array
    {
        return $this->model->newQuery()->get();
    }

    public function filter(array $attributes): Model|Builder
    {
        $query = $this->model->newQuery();
        if (isset($attributes["name"])) {
            $name = $attributes["name"];
            $query->where("name", "like", "%$name%");
        }
        if (isset($attributes["code"])) {
            $name = $attributes["code"];
            $query->where("code", "like", "%$name%");
        }
        if (isset($attributes["email"])) {
            $name = $attributes["email"];
            $query->where("email", "like", "%$name%");
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
}
