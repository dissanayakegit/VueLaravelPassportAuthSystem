<?php

namespace App\Repositories;

use Exception;
use App\Contracts\MainRepositoryInterface;
use Illuminate\Contracts\Container\Container as App;
use Illuminate\Support\Facades\Storage;

abstract class MainRepository implements MainRepositoryInterface
{
    private $app;

    protected $model;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    abstract function model();

    public function makeModel()
    {
        $model = $this->app->make($this->model());

        return $this->model = $model;
    }

    public function all($columns = array('*'))
    {
        return $this->model->get($columns);
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        return $this->model->paginate($perPage, $columns);
    }

    public function create(array $data)
    {
        try {
            return $this->model->create($data);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function update(array $data, $id, $attribute = "id")
    {
//        $this->model->where($attribute, '=', $id)->update($data);
        $obj = $this->model->find($id);
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $obj->{$key} = $value;
            }
            $obj->save();
        }
        return $this->model->find($id);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    public function findOrFail($id, $columns = array('*'))
    {
        return $this->model->findOrFail($id, $columns);
    }

    public function where($whereArr, $first = false, $columns = array('*'), $pluckColumn = null)
    {
        if ($first) {
            return $this->model->select($columns)->where($whereArr)->first();
        } elseif ($pluckColumn) {
            return $this->model->select($columns)->where($whereArr)->pluck($pluckColumn);
        } else {
            return $this->model->select($columns)->where($whereArr)->get();
        }
    }

    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    public function deleteFilesFromStorage($path, $file)
    {
        return Storage::delete($path . "/" . $file);
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function withRelationshipQuery($withArray)
    {
        $withArr = [];
        foreach ($withArray as $relationship => $with) {
            $withArr[$relationship] = function ($query) use ($with) {
                $query->select($with['select']);
                if (!empty($with['where'])) {
                    $query->where($with['where']);
                }
                if (!empty($with['without'])) {
                    $query->without($with['without']);
                }
                if (!empty($with['withArray'])) {
                    $query->with($this->withRelationshipQuery($with['withArray']));
                }
            };
        }
        return $withArr;
    }

    public function makeGuzzleRequest($endpoint, $request_type = 'get', $params = [])
    {
        return guzzleRequest($endpoint, $request_type, $params);
    }
}
