<?php


namespace App\Modules\Files\Contracts;


use App\Contracts\MainRepositoryInterface;

interface FilesRepositoryInterface extends MainRepositoryInterface
{
    public function getAllFiles();

    public function getFiletDetailsById($fileID);

}
