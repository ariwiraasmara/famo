<?php
namespace App\Http\Interfaces\Repositories;

use App\Http\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Models\PasswordResetTokens;
use App\Models\PersonalAccessTokens;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Strictus\Strictus;
use File;

interface UserRepositoryInterface {

    public function __construct(User $table, 
                                PasswordResetTokens $psr,
                                PersonalAccessTokens $pat, 
                                String $path = '');
    public function get(array $where = null);
    public function find(int $id = null, String $term = null): Collection;
    public function checkToken(int $id = null);
    public function getToken(int $id = null);
    public function lastUsedToken(String $data = null, int $id = null): int;
    public function updateTokenExpire(int $id = null);
    public function createDir(String $email = '');
    public function readDir(String $email = ''): String;
    public function deleteDir(String $email = '');
    public function createToken($content, $pass);

}
?>
