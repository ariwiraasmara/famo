<?php

namespace App\Http\Controllers;

use App\Models\MemberOf;
use Illuminate\Http\Request;
use App\Http\Services\MemberOfService;
use App\Libraries\jsr;
use App\Libraries\myfunction;
use Strictus\Strictus;

class MemberOfController extends Controller {

    public function __construct(protected MemberOfService $serv, 
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

    public function index(int $id) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $data = $this->serv->allMembership($id);
        return $this->jsr->res(['msg'=>'All Membership!', 'data'=>$data], 'ok');
    }

    public function recentMembership($id) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $data = $this->serv->getRecentMembership($id);
        return $this->jsr->res(['msg'=>'All Recent Membership!', 'data'=>$data], 'ok');
    }

    public function totalMembership($id) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $data = $this->serv->totalMembership($id);
        return $this->jsr->res(['msg'=>'Total Membership!', 'data'=>$data], 'ok');
    }

    public function destroy(MemberOf $memberOf, $id) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $res = $this->serv->deleteMembership(['mid'=> $id], ['mid'=>$id]);
        if($res == 1) return $this->jsr->res(['msg'=>'Success Delete Membership!', 'id'=>$id], 'ok');
        return $this->jsr->res(['msg'=>'Fail Delete Membership!', 'id'=>$id], 'error');
    }

}
