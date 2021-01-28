<?php


namespace App\Modules\Files\Repositories;


use App\File;
use App\Modules\Files\Contracts\FilesRepositoryInterface;

class FilesRepository  implements FilesRepositoryInterface
{
    function model()
    {
        return 'App\File';
    }

    public function getAllFiles(){
        dd('file repo!');
    }

}
