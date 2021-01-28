<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
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

    public function getTokenFromTokenService($guid = null)
    {
        return generateToken($guid);
    }

    public function checkIsTokenValid($token = null)
    {
        return checkIsTokenValid($token);
    }

    public function getChildAccounts($permissionToAccountType, $permissionToTerritoryId)
    {
        $user = auth('api')->user();
        $tenant_info = Tenant::territoryDetails($user->tenant->tena_id);
        $account = Company::where('comp_territory_id', $permissionToTerritoryId)->first();
        $accountTerritoryId = $account->comp_territory_id;
        $childAccounts = Company::select('comp_id', 'comp_name', 'comp_territory_id', 'comp_country', 'comp_region_id', 'is_logical')
            ->without('territory', 'region')
            ->where('comp_country', $tenant_info['tena_country'])
            ->whereHas('territory.tenant', function ($query) use ($permissionToAccountType) {
                $query->where('tena_type', $permissionToAccountType);
            });
        $childAccounts = $childAccounts->orderBy('comp_territory_id')
            ->addSelect(DB::raw('(SELECT terr_parent_id FROM SYS_territories WHERE SYS_companies.comp_territory_id = SYS_territories.terr_id ) as terr_parent_id'))
            ->orderBy('terr_parent_id')
            ->get();

        $data = $this->accountTree($childAccounts, $accountTerritoryId);
        return $data;
    }

    public function accountTree($companies, $territory_id)
    {

        $ids = [];
        foreach ($companies as $com) {
            if ($territory_id == $com->terr_parent_id) {
                $ids[] = array("company_id" => $com->comp_id, "company_territory_id" => $com->comp_territory_id);

                $childids = $this->accountTree($companies, $com->comp_territory_id);

                $ids = array_merge($ids, $childids);
            }
        }
        $response = unique_multi_dimensional_array($ids, 'company_id');
        return $response;
    }

    public function addSameKeyForElementsInArray($array, $key)
    {
        $createdArray = [];
        foreach ($array as $element) {
            $createdArray[str_random(4)] = [
                $key => $element
            ];
        }
        return $createdArray;
    }
}
