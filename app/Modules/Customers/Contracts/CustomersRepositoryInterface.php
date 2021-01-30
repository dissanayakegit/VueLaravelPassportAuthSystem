<?php


namespace App\Modules\Customers\Contracts;


use App\Contracts\MainRepositoryInterface;

interface CustomersRepositoryInterface extends MainRepositoryInterface
{
    public function getAllCustomers();

}
