<?php


namespace App\Modules\Customers\Repositories;

use App\Modules\Customers\Contracts\CustomersRepositoryInterface;
use App\Repositories\MainRepository;

class CustomersRepository  extends MainRepository implements CustomersRepositoryInterface
{
    function model()
    {
        return 'App\Customer';
    }

    public function getAllCustomers(){
        return $this->model->all();
    }


}
