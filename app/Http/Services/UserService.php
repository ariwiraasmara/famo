<?php
namespace App\Http\Services;

use App\Models\User;
use App\Http\Interfaces\Services\UserServiceInterface;
use App\Http\Repositories\UserRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use App\Libraries\jsr;
use App\Libraries\myfunction;
use Strictus\Strictus;
use File;

class UserService implements UserServiceInterface {

    protected $redis;

    public function __construct(protected UserRepository $repo, 
                                protected jsr $jsr, 
                                protected myfunction $fun) {
        // $this->redis = Redis::connection('0');
        // $this->redis->rawCommand("auth", "famo", "@12i50f!@_F@m0");
    }

    public function login(String $user = null, String $pass = null) {
        $cek1 = $this->repo->get(['users.email' => $user]);
        if(!$cek1->isNotEmpty() || !Hash::check($pass, $cek1[0]['password'])) {
            throw new HttpResponseException(
                response([
                    'msg'   => 'Email or Password is Wrong! Try Again!',
                    'error' => 1
                ])
            );
        } else {
            $data = collect([
                'id'    => $cek1[0]['id'],
                'name'  => $cek1[0]['name'],
                'email' => $cek1[0]['email'],
                'token' => $this->getToken($cek1[0]['id']),
                'roles' => $cek1[0]['roles'],
            ]);
            return collect(['msg' => 'You\'re Logged In!', 'success' => 1, 'data' => $data]);
        }
        return collect(['msg'=>'User Not Found! This User Not Registered!', 'error' => 1]);
    }

    public function logout(): Collection {
        $this->fun->setCookieOff('islogin');
        $this->fun->setCookieOff('id');
        $this->fun->setCookieOff('name');
        $this->fun->setCookieOff('email');
        $this->fun->setCookieOff('token');
        // $cache = $this->redis->del('user');
        return collect(['msg' => 'You\'re Logged Out!', 'success' => 1]);
    }

    public function register(array $data) {
        // $enpass = $this->fun->encrypt_pass($data['password']);
        $enpass = Hash::make($data['password']);
        $email_verified_at = date('Y-m-d H:i:s');

        $success = $this->repo->store([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'email_verified_at' => $email_verified_at,
            'password'          => $enpass,
            'roles'             => 3,
        ]);
        // return $success;
        if($success == 1) {
            $this->repo->createDir($data['email']);
            return collect([
                'success'           => 1,
                'name'              => $data['name'],
                'email'             => $data['email'],
                'email_verified_at' => $email_verified_at,
                'roles'             => 3,
            ]);
        }
        return 0;
    }

    public function forgotpassword(String $user = null) {

    }

    public function emailconfirmation(String $user = null) {

    }

    public function updateUser(int $id, array $data) {
        return $this->repo->update($data, ['id'=>$id]);
    }

    public function findMemberUser(int $id, String $user): Collection {
        return collect($this->repo->find($id, $user));
    }

    public function profile(int $id = null): Collection {
        return collect($this->repo->get(['id' => $id]));
    }

    public function createDir(String $email = '') {
        return $this->repo->createDir($email);
    }

    public function readDir(String $email = '') {
        return $this->repo->readDir($email);
    }

    public function deleteDir(String $email = '') {
        return $this->repo->deleteDir($email);
    }

    public function tokenize($token = null) {
        // $token['id'] = $this->fun->encrypt($token['id']);
        $this->repo->updateTokenExpire($token['tokenable_id']);
        $token['name'] = $this->fun->encrypt($token['name']);
        $token['tokenable_id'] = $this->fun->encrypt($token['tokenable_id']);
        $token['tokenable_type'] = $this->fun->encrypt($token['name']);
        return base64_encode($token);
    }

    public function checkToken(int $id = null) {
        return $this->repo->checkToken($id);
    }

    public function getToken(int $id = null) {
        return $this->repo->getToken($id);
    }

    public function lastUsedToken(String $data = null, int $id = null): int {
        return $this->lastUsedToken($data, $id);
    }

    public function generateToken(int $randnum = 0, 
                                String $token = null, 
                                String $email = null, 
                                String $password = null,
                                int $role = 0,
                                $date, $date_expire): String {
        $header = base64_encode(
                    json_encode([
                        'alg' => 'HS256', 
                        'type' => 'JWT'
                    ])
                  );
        $payload = base64_encode(
                      json_encode([
                         'id'               => $randnum,
                         'username'         => $username, 
                         'email'            => $email,
                         'tokenable_type'   => 'App\\Models\\User',
                         'roles'            => $role,
                         'expire_at'        => $date_expire,
                         'create_at'        => $date
                      ])
                   );
        $secretkey = base64_encode(hash_hmac('sha256', $username, $password));
        $signature = $header.'.'.$payload.'.'.$secretkey;
        // $signature = hash_hmac("sha256", $header.".".$payload, $secretkey);
        return str_replace('=', '', $signature);
    }

}
