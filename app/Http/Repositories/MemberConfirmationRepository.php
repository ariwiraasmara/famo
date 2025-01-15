<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\Repositories\MemberConfirmationRepositoryInterface;
use App\Http\Repositories\BaseRepository;
use App\Models\MemberConfirmation;
use Illuminate\Support\Collection;
use App\Libraries\jsr;

class MemberConfirmationRepository extends BaseRepository implements MemberConfirmationRepositoryInterface {

    protected $model;
    public function __construct(protected MemberConfirmation $table, protected jsr $jsr) {
        $this->model = $this->table->getInstance();
    }

    public function getID(int $iduser1 = 0, int $iduser2 = 0) {
        return 'IDC@'.date('Ymd').$iduser1.$iduser2.date('His');
    }

    public function get(array $where = null): Collection {
        if($this->model->where($where)->first()) return $this->model->where($where)->get();
        return null;
    }

    public function getDetail(array $where = null, string $order = null, string $by = null, bool $is_paging = false, int $numpages = null) {
        if($this->model->where($where)->first()) {
            if ($is_paging) {
                return collect($this->model
                            ->join('users', 'users.id', '=', 'member_confirmation.id_requestor')
                            ->where($where)
                            ->orderBy($order, $by)
                            ->paginate($numpages));
            }
            return collect($this->model
                        ->join('users', 'users.id', '=', 'member_confirmation.id_requestor')
                        ->where($where)
                        ->orderBy($order, $by)
                        ->take(11)
                        ->get());
        }
        return null;
    }

}
?>
