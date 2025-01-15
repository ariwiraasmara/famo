<?php
namespace App\Http\Interfaces\Services;

use App\Http\Interfaces\Services\MemberOfServiceInterface;
use App\Http\Repositories\MyMemberRepository;
use App\Http\Repositories\MemberOfRepository;
use Illuminate\Support\Collection;
use App\Libraries\jsr;
use App\Libraries\myfunction;
use Strictus\Strictus;

interface MemberOfServiceInterface {

    public function __construct(MemberOfRepository $repo, 
                                MyMemberRepository $member,
                                jsr $jsr, 
                                myfunction $fun);
    public function allMembership(int $id = 0);
    public function getRecentMembership(int $id = 0);
    public function deleteMembership(array $where1 = null, array $where2 = null): int;

}
