<?php


namespace App\Modules\Files\Repositories;

use App\Modules\Files\Contracts\FilesRepositoryInterface;
use App\Repositories\MainRepository;

class FilesRepository  extends MainRepository implements FilesRepositoryInterface
{
    function model()
    {
        return 'App\File';
    }

    public function getAllFiles(){
        return $this->model->all();
    }

    public function getFiletDetailsById($fileId){
        $this->model->where('id', $fileId)->first();
    }


}
