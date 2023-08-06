<?php

namespace App\Repositories\Eloquent;

use App\Models\Classroom;
use App\Repositories\ClassroomRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use TimWassenburg\RepositoryGenerator\Repository\BaseRepository;

/**
 * Class ClassroomRepository.
 */
class ClassroomRepository extends BaseRepository implements ClassroomRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Classroom $model
     */
    public function __construct(Classroom $model)
    {
        parent::__construct($model);
    }

    public function filter(array $attributes): Model|Builder
    {
        $query = $this->model->newQuery();
        if (isset($attributes["name"])) {
            $name = $attributes["name"];
            $query->where("name", "like", "%$name%");
        }
        if (isset($attributes["classroom"])) {
            $classroomFilter = $attributes["classroom"];
            $query->whereHas("classroom", function (Builder $classroom) use ($classroomFilter) {
                $classroom->where("name", "like", "%$classroomFilter%");
            });
        }
        return $query->orderBy("created_at", "DESC");
    }

    public function getTotalRecord($attributes): int
    {
        return $this->filter($attributes)->count();
    }

    public function getPagination(array $attributes): Collection
    {
        if ($attributes["perPage"] === "-1") {
            return $this->filter($attributes)->get();
        } else {
            return $this->filter($attributes)->skip($attributes["startRecord"])->take($attributes["perPage"])->get();
        }
    }
    public function getClassroomForCreate(): Collection|array
    {
        return $this->model->newQuery()->get();
    }
}
