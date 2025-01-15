<?php
namespace App\Http\Services;

use App\Http\Interfaces\Services\MyMemberServiceInterface;
use App\Http\Repositories\MyMemberRepository;
use App\Http\Repositories\MemberOfRepository;
use Illuminate\Support\Collection;
use App\Libraries\jsr;
use App\Libraries\myfunction;
use Strictus\Strictus;

class MyMemberService implements MyMemberServiceInterface {

    public function __construct(protected MyMemberRepository $repo,
                                protected MemberOfRepository $memberof,
                                protected jsr $jsr,
                                protected myfunction $fun) {

    }

    public function allMember(int $id = 0) {
        $data = $this->repo->get($id);
        return match($data) {
            null => 0,
            default => $data
        };
    }

    public function getRecentMember(int $id = 0) {
        return $this->repo->get($id, 'my_member.mid', 'desc', false, 4);
    }

    public function allParentChildMember($id = 0, $qorder = 'my_member.mid', $qby = 'asc') {
        $data = $this->repo->get($id, $qorder, $qby);
        return match($data) {
            null => 0,
            default => $data->map(function (object $parentitem, int $key) {
                $child = $this->repo->get($parentitem['id_member']);
                $fc = match($child) {
                    null => 0,
                    default => $child->map(function (object $childitem, int $key) {
                        return [
                           'child_mid'           => $childitem['mid'],
                           'child_id_member'     => $childitem['id_member'],
                           'child_member_name'   => $childitem['member_name'],
                           'child_email_member'  => $childitem['email_member'],
                       ];
                   })
                };

                return [
                    'mid'           => $parentitem['mid'],
                    'id_user'       => $parentitem['id_user'],
                    'my_name'       => $parentitem['my_name'],
                    'id_user'       => $parentitem['id_user'],
                    'id_member'     => $parentitem['id_member'],
                    'member_name'   => $parentitem['member_name'],
                    'email_member'  => $parentitem['email_member'],
                    'child_member'  => $fc
                ];
            })
        };
    }

    public function deleteMember(array $where1 = null, array $where2 = null): int {
        if($this->repo->delete($where1) && $this->memberof->delete($where2)) return 1;
        return 0;
    }

}
