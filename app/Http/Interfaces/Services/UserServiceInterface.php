<?php
namespace App\Http\Interfaces\Services;

use App\Http\Repositories\UserRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use App\Libraries\jsr;
use App\Libraries\myfunction;
use Strictus\Strictus;
use File;

interface UserServiceInterface {

    public function __construct(UserRepository $repo, jsr $jsr, myfunction $fun);
    public function login(String $user = null, String $pass = null);
    public function logout(): Collection;
    public function register(array $data);
    public function forgotpassword(String $user = null);
    public function emailconfirmation(String $user = null);
    public function findMemberUser(int $id, String $user): Collection;
    public function profile(int $id = null): Collection;
    public function createDir(String $email = '');
    public function readDir(String $email = '');
    public function deleteDir(String $email = '');
    // public function retoken();
    public function tokenize($token = null);
    public function checkToken(int $id = null);
    public function getToken(int $id = null);
    public function lastUsedToken(String $data = null, int $id = null): int;
    public function generateToken(int $randnum = 0, 
                                  String $username = null, 
                                  String $email = null, 
                                  String $password = null,
                                  int $role = 0,
                                  $date, $date_expire): String;

}
