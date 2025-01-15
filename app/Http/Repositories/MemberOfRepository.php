<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\Repositories\MemberOfRepositoryInterface;
use App\Http\Repositories\BaseRepository;
use App\Models\MemberOf;
use Illuminate\Support\Collection;
use App\Libraries\jsr;

class MemberOfRepository extends BaseRepository implements MemberOfRepositoryInterface {

    protected $model;
    public function __construct(protected MemberOf $table, jsr $jsr) {
        $this->model = $this->table->getInstance();
    }

    public function get(int $id = 0, string $order = 'member_of.id_user', string $by = 'asc', bool $is_paging = false, int $numpages = null) {
        if($this->model->where(['id_user' => $id])->first()) {
            if ($is_paging) {
                return collect($this->model
                            ->select('member_of.mid', 'member_of.date_join',
                                     'member_of.id_user', 'a.name as my_name',
                                     'member_of.id_membership', 'b.name as membership', 'b.email as email_membership')
                            ->leftJoin('users as a', 'a.id', '=', 'member_of.id_user')
                            ->leftJoin('users as b', 'b.id', '=', 'member_of.id_membership')
                            ->where(['member_of.id_user' => $id])
                            ->orderBy($order, $by)
                            ->paginate($numpages));
            }
            return collect($this->model
                        ->select('member_of.mid', 'member_of.date_join',
                                 'member_of.id_user', 'a.name as my_name',
                                 'member_of.id_membership', 'b.name as membership', 'b.email as email_membership')
                        ->leftJoin('users as a', 'a.id', '=', 'member_of.id_user')
                        ->leftJoin('users as b', 'b.id', '=', 'member_of.id_membership')
                        ->where(['member_of.id_user' => $id])
                        ->orderBy($order, $by)
                        ->take($numpages)
                        ->get());
        }
        return null;
    }

    public function getTable(int $id = 0, string $order = 'member_of.id_user', string $by = 'asc', bool $is_paging = false, int $numpages = null): Collection {
        $data = $this->model
                    ->select('member_of.mid', 'member_of.date_join',
                            'member_of.id_user', 'a.name as my_name',
                            'member_of.id_membership', 'b.name as membership', 'b.email as email_membership')
                    ->leftJoin('users as a', 'a.id', '=', 'member_of.id_user')
                    ->leftJoin('users as b', 'b.id', '=', 'member_of.id_membership')
                    ->where(['member_of.id_user' => $id])
                    ->orderBy($order, $by)
                    ->take($numpages)
                    ->get();
        $result = [];
        $groupSize = 4; // Jumlah item dalam setiap grup
        $groupIndex = 0; // Indeks grup awal

        foreach ($data as $index => $item) {
            if ($index % $groupSize === 0 && $index > 0) {
                $groupIndex++;
            }

            $result[$groupIndex][] = $item;
        }

        return collect($result);
    }

}
?>
