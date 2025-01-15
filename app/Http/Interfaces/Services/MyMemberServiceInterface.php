<?php
namespace App\Http\Interfaces\Services;

use App\Http\Repositories\MyMemberRepository;
use App\Http\Repositories\MemberOfRepository;
use Illuminate\Support\Collection;
use App\Libraries\jsr;
use App\Libraries\myfunction;
use Strictus\Strictus;

interface MyMemberServiceInterface {

    public function __construct(MyMemberRepository $repo,
                                MemberOfRepository $memberof,
                                jsr $jsr,
                                myfunction $fun);
    public function allMember(int $id = 0);
    public function getRecentMember(int $id = 0);
    public function allParentChildMember($id = 0, $order = 'my_member.mid', $by = 'asc');
    public function deleteMember(array $where1 = null, array $where2 = null): int;

}
