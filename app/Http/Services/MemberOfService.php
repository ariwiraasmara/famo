<?php
namespace App\Http\Services;

use App\Http\Interfaces\Services\MemberOfServiceInterface;
use App\Http\Repositories\MyMemberRepository;
use App\Http\Repositories\MemberOfRepository;
use Illuminate\Support\Collection;
use App\Libraries\jsr;
use App\Libraries\myfunction;
use Strictus\Strictus;

class MemberOfService implements MemberOfServiceInterface {

    public function __construct(protected MemberOfRepository $repo,
                                protected MyMemberRepository $member,
                                protected jsr $jsr,
                                protected myfunction $fun) {

    }

    public function allMembership(int $id = 0) {
        $data = $this->repo->get($id);
        return match($data) {
            null => 0,
            default => $data
        };
    }

    public function getRecentMembership(int $id = 0) {
        return $this->repo->get($id, 'member_of.mid', 'desc', false, 4);
    }

    public function deleteMembership(array $where1 = null, array $where2 = null): int {
        if($this->repo->delete($where1) && $this->member->delete($where2)) return 1;
        return 0;
    }

}
