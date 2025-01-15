<?php
namespace App\Http\Interfaces\Services;

use App\Http\Repositories\UserFileRepository;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\Collection;
use App\Libraries\jsr;
use App\Libraries\myfunction;
use Strictus\Strictus;

interface UserFileServiceInterface {

    public function __construct(UserFileRepository $repo, 
                                UserRepository $user,
                                jsr $jsr, 
                                myfunction $fun);
    public function readFile(String $email = null, String $file = null): String;
    public function getFile(String $id = null): Collection;
    public function getAllFile(int $userid = null);
    public function getExtension(String $str = null): String;
    public function addFile(array $data = null);
    public function deleteFile(array $where = null);

}
