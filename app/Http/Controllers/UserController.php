<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Crypt;
use App\Http\Services\UserService;
use App\Libraries\myfunction;
use App\Libraries\jsr;
use Strictus\Strictus;
use Redirect;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    //

    public function __construct(protected UserService $serv, 
                                protected jsr $jsr, 
                                protected myfunction $fun) {

    }

    protected int $id;
    protected String $name, $email;
    protected $islogin;
    protected function islogin() {
        $ceklogin = $this->fun->getRawCookie('islogin');
        if($ceklogin) {
            $this->islogin  = true;
            $this->id       = $this->fun->getCookie('id');
            $this->name     = $this->fun->getCookie('name');
            $this->email    = $this->fun->getCookie('email');
        }
    }

    public function login(Request $request) {
        $res = $this->serv->login($request->user, $request->pass);
        if(($res['success'] == 1)) {
            $credentials = [
                'email'    => $request->user,
                'password' => $request->pass
            ];
            $checkToken = $this->serv->checkToken($res['data']['id']);
            $user = Auth::user();

            /*
            if($checkToken == 0 && Auth::attempt($credentials, true)) {
                $res['data']['token'] = $this->serv->tokenize($user->createToken('famowiraasmara_'.$request->user)->accessToken);
            }
            else if($checkToken == 1) {
                $res['data']['token'] = $this->serv->tokenize($this->serv->getToken($res['data']['id']));
            }
            */

            $this->fun->setCookie([
                'islogin'=> 1,
                'id'     => $res['data']['id'],
                'name'   => $res['data']['name'],
                'email'  => $res['data']['email'],
                'token'  => $res['data']['token']
            ]);
            return $this->jsr->res($res->toArray(), 'ok');
        }
        return $this->jsr->res($res->toArray(), 'error');
    }

    public function logout(Request $request) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $user = $request->user();
        $res = $this->serv->logout();
        return match($res->has('success')) {
            true => $this->jsr->res($res->toArray(), 'ok'),
            default => $this->jsr->res(['msg'=>'Logout Fail!', 'error'=>1], 'error')
        };
    }

    public function logout_web() {
        $this->fun->setCookieOff('islogin');
        $this->fun->setCookieOff('id');
        $this->fun->setCookieOff('name');
        $this->fun->setCookieOff('email');
        $this->fun->setCookieOff('token');
        return Redirect::to('/');
    }

    public function register(Request $request) {
        $res = $this->serv->register([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $request->pass
        ]);
        // return $res;
        return match($res['success']) {
            1 => $this->jsr->res(['msg'=>'Success Create New User!', 'data'=>$res], 'created'),
            default => $this->jsr->res(['msg'=>'Fail Create New User!', 'success'=>0], 'error')
        };
    }

    public function search($id, $term) {
        // return $id.' : '.$term;
        $res = $this->serv->findMemberUser($id, $term);
        return $this->jsr->res(['msg'=>'Search for User..', 'like'=>$term, 'data'=>$res], 'ok');
    }

    public function forgotpassword() {

    }

    public function emailconfirmation() {

    }

    public function dashboard() {
        
    }

}
