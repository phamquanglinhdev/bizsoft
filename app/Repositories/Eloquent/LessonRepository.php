<?php

namespace App\Repositories\Eloquent;

use App\Models\Lesson;
use App\Repositories\LessonRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use TimWassenburg\RepositoryGenerator\Repository\BaseRepository;

/**
 * Class LessonRepository.
 */
class LessonRepository extends BaseRepository implements LessonRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Lesson $model
     */
    public function __construct(Lesson $model)
    {
        parent::__construct($model);
    }

    public function filter(array $attributes): Model|Builder
    {
        $query = $this->model->newQuery();
        if (isset($attributes["title"])) {
            $title = $attributes["title"];
            $query->where("name", "like", "%$title%");
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


}
