<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\Repositories\UserFileRepositoryInterface;
use App\Http\Repositories\BaseRepository;
use App\Models\UserFile;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Libraries\jsr;
use File;

class UserFileRepository extends BaseRepository implements UserFileRepositoryInterface {

    protected $model;
    public function __construct(protected UserFile $table,
                                protected User $user,
                                protected jsr $jsr) {
        $this->model = $this->table->getInstance();
    }

    public function get(array $where = null) {
        if($this->model->where($where)->first()) return collect($this->model->where($where)->get());
        return null;
    }

    public function getAll(array $where = null, string $order = 'user_file.id', string $by = 'asc', bool $is_paging = false, int $numpages = 0) {
        if($this->model->where($where)->first()) {
            if ($is_paging) {
                return collect($this->model
                            ->select('user_file.id as id', 'user_file.id_user as id_user', 'user_file.ket as ket',
                                     'user_file.foto as foto', 'users.name as user_name')
                            ->join('users', 'users.id', '=', 'user_file.id_user')
                            ->where($where)
                            ->orderBy($order, $by)
                            ->paginate($numpages));
            }
            return collect($this->model
                        ->select('user_file.id as id', 'user_file.id_user as id_user', 'user_file.ket as ket',
                                'user_file.foto as foto', 'users.name as user_name')
                        ->join('users', 'users.id', '=', 'user_file.id_user')
                        ->where($where)
                        ->orderBy($order, $by)
                        ->get());
        }
        return null;
    }

    public function getID(int $iduser = 0): String {
        // UF[user_id]#[counter]
        // UF1#0000001
        if($this->model->where(['id_user'=>$iduser])->first()) {
            $data   = $this->model->where(['id_user'=>$iduser])->orderBy('id', 'desc')->first();
            $strpos = (int)strpos($data['id'], "@") + 1;
            $substr = (int)substr($data['id'], $strpos)+1;
            return 'UF'.$iduser.'@'.str_pad($substr, 7, "0", STR_PAD_LEFT);
        }
        return 'UF'.$iduser.'@'.str_pad(1, 7, "0", STR_PAD_LEFT);
    }

    public function uploadFile($email, $file) {
        if(!File::isDirectory($this->user->readDir($email, $file))) return File::makeDirectory($this->user->readDir($email, $file), 0777, true, true);
    }

}
?>
