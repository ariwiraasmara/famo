<?php
namespace App\Http\Services;

use App\Http\Interfaces\Services\MemberConfirmationServiceInterface;
use App\Http\Repositories\MemberConfirmationRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\MyMemberRepository;
use App\Http\Repositories\MemberOfRepository;
use Illuminate\Support\Collection;
use App\Libraries\myfunction;
use App\Libraries\jsr;
use Strictus\Strictus;

class MemberConfirmationService implements MemberConfirmationServiceInterface {

    public function __construct(protected MemberConfirmationRepository $repo, 
                                protected UserRepository $user,
                                protected MyMemberRepository $member,
                                protected MemberOfRepository $membership,
                                protected jsr $jsr, 
                                protected myfunction $fun) {

    }

    public function getAllNotification(array $where = null, string $order = null, string $by = null, bool $is_paging = false, int $numpages = null): Collection {
        return collect($this->repo->getDetail($where, $order, $by, $is_paging, $numpages));
    }

    public function sendInvitation(int $id_requestor = 0, String $id_recipient = null, String $type = null): int {
        return $this->repo->store([
            'idc'           => $this->repo->getID($id_requestor, $id_recipient),
            'date_ask'      => date('Y-m-d H:i:s'),
            'date_confirm'  => null,
            'id_requestor'  => $id_requestor,
            'id_recipient'  => $id_recipient,
            'type'          => $type,
            'is_rejected'   => null
        ]);
    }

    public function acceptInvitation(String $idinvite = null, int $iduser = 0) {
        // update accept invitation
        $data = $this->repo->get(['idc'=>$idinvite], $iduser);

        if($data[0]['type'] == 'invite') {
            $mid = $this->member->getID(['id_user'=>$data[0]['id_requestor']], $data[0]['id_requestor']);
            
            return $this->repo->update([
                // data
                'date_confirm' => date('Y-m-d H:i:s'),
                'is_rejected'  => 0
            ], [
                // where
                'idc' => $idinvite
            ]) && $this->member->store([
                'mid'       => $mid,
                'id_user'   => $data[0]['id_requestor'],
                'id_member' => $data[0]['id_recipient'],
            ]) && $this->membership->store([
                'mid'           => $mid,
                'id_user'       => $data[0]['id_recipient'],
                'id_membership' => $data[0]['id_requestor'],
                'date_join'     => date('Y-m-d H:i:s')
            ]);
        }
        else if($data[0]['type'] == 'join'){
            $mid = $this->member->getID(['id_user'=>$data[0]['id_recipient']], $data[0]['id_recipient']);

            return $this->repo->update([
                // data
                'date_confirm' => date('Y-m-d H:i:s'),
                'is_rejected'  => 0
            ], [
                // where
                'idc' => $idinvite
            ]) && $this->member->store([
                'mid'       => $mid,
                'id_user'   => $data[0]['id_recipient'],
                'id_member' => $data[0]['id_requestor'],
            ]) && $this->membership->store([
                'mid'           => $mid,
                'id_user'       => $data[0]['id_requestor'],
                'id_membership' => $data[0]['id_recipient'],
                'date_join'     => date('Y-m-d H:i:s')
            ]);
        }
        return 0;
    }

    public function rejectInvitation(String $id = null): int {
        return $this->repo->update([
            'date_confirm'  => date('Y-m-d H:i:s'),
            'is_rejected'   => 1
        ], ['idc'=>$id]);
    }

    public function deleteNotification(array $where = null): int {
        if($this->repo->delete($where)) return 1;
        return 0;
    }

}
