<?php
namespace App\Http\Interfaces\Services;

use App\Http\Repositories\MemberConfirmationRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\MyMemberRepository;
use App\Http\Repositories\MemberOfRepository;
use Illuminate\Support\Collection;
use App\Libraries\myfunction;
use App\Libraries\jsr;
use Strictus\Strictus;

interface MemberConfirmationServiceInterface {

    public function __construct(MemberConfirmationRepository $repo, 
                                UserRepository $user,
                                MyMemberRepository $member,
                                MemberOfRepository $membership,
                                jsr $jsr, 
                                myfunction $fun);

    public function getAllNotification(array $where = null, string $order = null, string $by = null, bool $is_paging = false, int $numpages = 0): Collection;
    public function sendInvitation(int $id_requestor = 0, String $id_recipient = null, String $type = null): int;
    public function acceptInvitation(String $idinvite = null, int $iduser = 0);
    public function rejectInvitation(String $id = null): int;
    public function deleteNotification(array $where = null): int;

}
