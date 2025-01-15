<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\Repositories\MyMemberRepositoryInterface;
use App\Http\Repositories\BaseRepository;
use App\Models\MyMember;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Libraries\jsr;

class MyMemberRepository extends BaseRepository implements MyMemberRepositoryInterface {

    protected $model;
    public function __construct(protected MyMember $table,
                                protected User $user,
                                protected jsr $jsr) {
        $this->model = $this->table->getInstance();
    }

    public function getID(array $where = null, int $iduser = 0): String {
        // MEMBER@[email]#[counter]
        // MEMBER@ariwiraasmara.sc37@gmail.com#0000000000000001
        $user_data = $this->user->where(['id'=>$iduser])->first();
        $email = $user_data['email'];

        if($this->model->where($where)->first()) {
            $data   = $this->model->where($where)->orderBy('mid', 'desc')->first();
            $strpos = (int)strpos($data['mid'], ":") + 1;
            $substr = (int)substr($data['mid'], $strpos)+1;
            return 'MEMBER@'.$email.':'.str_pad($substr, 16, "0", STR_PAD_LEFT);
        }
        return 'MEMBER@'.$email.':'.str_pad(1, 16, "0", STR_PAD_LEFT);
    }

    public function get(int $id = 0, string $order = 'my_member.mid', string $by = 'asc', bool $is_paging = false, int $numpages = null) {
        if($this->model->where(['id_user' => $id])->first()) {
            if ($is_paging) {
                return collect($this->model
                            ->select('my_member.mid',
                                     'my_member.id_user', 'a.name as my_name',
                                     'my_member.id_member', 'b.name as member_name', 'b.email as email_member')
                            ->join('users as a', 'a.id', '=', 'my_member.id_user')
                            ->join('users as b', 'b.id', '=', 'my_member.id_member')
                            ->where(['my_member.id_user' => $id])
                            ->orderBy($order, $by)
                            ->paginate($numpages));
            }
            return collect($this->model
                        ->select('my_member.mid',
                                 'my_member.id_user', 'a.name as my_name',
                                 'my_member.id_member', 'b.name as member_name', 'b.email as email_member')
                        ->join('users as a', 'a.id', '=', 'my_member.id_user')
                        ->join('users as b', 'b.id', '=', 'my_member.id_member')
                        ->where(['my_member.id_user' => $id])
                        ->orderBy($order, $by)
                        ->take($numpages)
                        ->get());
        }
        return null;
    }

    public function getChild($id = 0, $order = 'my_member.mid', $by = 'asc') {
        if($this->model->where(['id_user' => $id])->first()) {
            return collect($this->model
                        ->select('my_member.mid',
                                 'my_member.id_member', 'b.name as member_name', 'b.email as email_member')
                        ->join('users as b', 'b.id', '=', 'my_member.id_member')
                        ->where(['my_member.id_user' => $id])
                        ->orderBy($order, $by)
                        ->get());
        }
        return null;
    }

}
?>
