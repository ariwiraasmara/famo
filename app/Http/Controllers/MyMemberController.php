<?php

namespace App\Http\Controllers;

use App\Models\MyMember;
use Illuminate\Http\Request;
use App\Http\Services\MyMemberService;
use App\Libraries\jsr;
use App\Libraries\myfunction;
use Strictus\Strictus;

class MyMemberController extends Controller {

    public function __construct(protected MyMemberService $serv,
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
        
        $data = $this->serv->allMember($id);
        return $this->jsr->res(['msg'=>'All Member!', 'data'=>$data], 'ok');
    }

    public function recentMember(int $id) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $data = $this->serv->getRecentMember($id);
        return $this->jsr->res(['msg'=>'All Recent Member!', 'data'=>$data], 'ok');
    }

    public function totalMember(int $id) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $data = $this->serv->totalMember($id);
        return $this->jsr->res(['msg'=>'Total Member!', 'data'=>$data], 'ok');
    }

    public function getChild($id, $order, $by) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $data = $this->serv->childMember($id, $order, $by);
        return $this->jsr->res(['msg'=>'Child Member!', 'id'=>$id, 'data'=>$data], 'ok');
    }

    public function allParentChildMember($id = 0, $order = '', $by = '') {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $data= $this->serv->allParentChildMember($id, $order, $by);
        return $data;
        return $this->jsr->res(['msg'=>'All Member!',
                                'user'=> ['id'=>$id, "order by:" => $order.' '.$by],
                                'data'=>$data], 'ok');
    }

    public function destroy(MyMember $myMember, $id) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $res = $this->serv->deleteMember(['mid'=> $id], ['mid'=>$id]);
        if($res == 1) return $this->jsr->res(['msg'=>'Success Delete Member!', 'id'=>$id], 'ok');
        return $this->jsr->res(['msg'=>'Fail Delete Member!', 'id'=>$id], 'error');
    }

}
