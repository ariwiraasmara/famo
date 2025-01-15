<?php

namespace App\Http\Controllers;

use App\Models\MemberConfirmation;
use Illuminate\Http\Request;
use App\Http\Services\MemberConfirmationService;
use App\Libraries\myfunction;
use App\Libraries\jsr;
use Strictus\Strictus;

class MemberConfirmationController extends Controller {

    public function __construct(protected MemberConfirmationService $serv, protected jsr $jsr, protected myfunction $fun) {

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

    public function index($id) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $data = $this->serv->getAllNotification(['id_recipient'=>$id, 'date_ask'=>null], 'date_ask', 'desc', false, 0);
        return $this->jsr->res(['msg'=>'You\'re Notifications!', 'data'=>$data], 'ok');
    }

    public function store(Request $request) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $res = $this->serv->sendInvitation($request->id_requestor, $request->id_recipient, $request->type);
        if($res > 0) return $this->jsr->res(['msg'=>'Success Send Invitation!', 'data'=>$res], 'ok');
        return $this->jsr->res(['msg'=>'Fail Send Invitation!', 'data'=>$res], 'error');
    }

    public function update(Request $request, MemberConfirmation $memberConfirmation) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $res = $this->serv->acceptInvitation($request->id_invite, $request->id_user);
        if($res > 0) return $this->jsr->res(['msg'=>'Success Accept Invitation!', 'data'=>$res], 'ok');
        return $this->jsr->res(['msg'=>'Fail Accept Invitation!', 'data'=>$res], 'error');
    }

    public function reject(Request $request, MemberConfirmation $memberConfirmation) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $res = $this->serv->rejectInvitation($request->idc);
        if($res > 0) return $this->jsr->res(['msg'=>'Success Reject Invitation!', 'data'=>$res], 'ok');
        return $this->jsr->res(['msg'=>'Fail Reject Invitation!', 'data'=>$res], 'error');
    }

    public function destroy(MemberConfirmation $memberConfirmation, String $id) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $res = $this->serv->deleteNotification(['idc'=>$id]);
        if($res > 0) return $this->jsr->res(['msg'=>'Success Delete Notification!', 'data'=>$res], 'ok');
        return $this->jsr->res(['msg'=>'Fail Delete Notification!', 'data'=>$res], 'error');
    }

    public function destroyAll(MemberConfirmation $memberConfirmation, int $id) {
        $this->islogin();
        if(!$this->islogin) return $this->jsr->res(['msg'=>'Unauthorized!', 'error'=>1], 'error');
        
        $res = $this->serv->deleteNotification(['id_recipient'=>$id]);
        if($res > 0) return $this->jsr->res(['msg'=>'Success Delete Notification!', 'data'=>$res], 'ok');
        return $this->jsr->res(['msg'=>'Fail Delete Notification!', 'data'=>$res], 'error');
    }

}
