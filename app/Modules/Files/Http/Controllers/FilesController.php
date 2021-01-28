<?php

namespace App\Modules\Files\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Files\Contracts\FilesRepositoryInterface;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    private $fileRepo;
    public function __construct(FilesRepositoryInterface $fileRepo)
    {
        $this->fileRepo = $fileRepo;
    }

    public function index(){
        $this->fileRepo->getAllFiles();
    }
    public function index2(){
        dd(1);
    }
}
