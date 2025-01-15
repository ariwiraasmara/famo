<?php

namespace App\Http\Controllers;

use App\Models\UserFile;
use Illuminate\Http\Request;
use App\Http\Services\UserFileService;
use App\Http\Services\UserService;
use App\Libraries\jsr;
use App\Libraries\myfunction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;
use Strictus\Strictus;
use Illuminate\Support\Facades\Auth;

class UserFileController extends Controller {

    protected int $id;
    protected String $name, $email, $token;
    protected $islogin;

    public function __construct(protected UserFileService $serv,
                                protected UserService $user,
                                protected jsr $jsr,
                                protected myfunction $fun) {
        // return Auth::check();
    }
    
    protected function islogin() {
        $ceklogin = $this->fun->getRawCookie('islogin');
        if($ceklogin) {
            $this->islogin  = true;
            $this->id       = $this->fun->getCookie('id');
            $this->name     = $this->fun->getCookie('name');
            $this->email    = $this->fun->getCookie('email');
            $this->token    = $this->fun->getCookie('token');
            return $this->islogin;
        }
    }

    public function index($id) {
        if(!$this->islogin) {
            $user = Auth::check();
            $data = $this->serv->getAllFile($id);
            return $this->jsr->res([
                'msg'  => 'You\'re Files!', 
                'data' => $data,
            ], 'ok');
        }
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
    }

    public function show(UserFile $userFile, $id) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $data = $this->serv->getFile($id);
        return $this->jsr->res(['msg'=>'You\'re File!', 'data'=>$data], 'ok');
    }

    public function destroy(UserFile $userFile, $id) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $data  = $this->serv->getFile($id);
        $user  = $this->user->profile($data[0]['id_user']);
        $file  = $data[0]['foto'];
        $email = $user[0]['email'];
        $res = $this->serv->deleteFile(['id'=>$id]);
        if($res > 0) {
            File::delete($this->serv->readFile($email, $file));
            return $this->jsr->res(['msg'=>'Success Delete File!', 'id'=>$id], 'ok');
        }
        return $this->jsr->res(['msg'=>'Fail Delete File!', 'id'=>$id], 'error');
    }

    public function store(Request $request) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $file = $request->file('filename');
        $res = $this->serv->addFile([
            'id_user'   => $request->id_user,
            'filename'  => $file->getClientOriginalName(),
            'extension' => $file->extension(),
            'filesize'  => $file->getSize(),
            'fileinfo'  => $request->fileinfo,
        ]);

        if($res < 0) return $this->jsr->res(['msg'=>'Fail Upload File! File is too big!', 'data'=>$res], 'error');
        else if($res > 0) {
            $file->move($this->user->readDir($request->email), $file->getClientOriginalName());
            return $this->jsr->res(['msg'=>'Success Upload File!', 'data'=>$res], 'ok');
        }
        return $this->jsr->res(['msg'=>'Fail Upload File!', 'data'=>$res], 'error');
    }

}
