<?php
namespace App\Http\Repositories;

use App\Models\User;
use App\Models\PasswordResetTokens;
use App\Models\PersonalAccessTokens;
use App\Http\Interfaces\Repositories\UserRepositoryInterface;
use App\Http\Repositories\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use File;

class UserRepository extends BaseRepository implements UserRepositoryInterface {

    protected $model;
    public function __construct(protected User $table, 
                                protected PasswordResetTokens $psr,
                                protected PersonalAccessTokens $pat, 
                                protected String $path = '') {
        $this->model = $this->table->getInstance();
        $this->path = public_path('userfiles/');
    }

    public function get(array $where = null) {
        if($this->model->where($where)->first()) {
            return collect($this->model->where($where)->get());
        }
        return 0;
    }

    public function find(int $id = null, String $term = null): Collection {
        return $this->model
                    ->select('users.id', 'users.name', 'users.email')
                    ->leftJoin('my_member', function ($join) use ($id) {
                        $join->on('users.id', '=', 'my_member.id_user')
                            ->where('my_member.id_user', '<>', $id);
                    })
                    ->leftJoin('member_of', function ($join) use ($id) {
                        $join->on('users.id', '=', 'member_of.id_membership')
                            ->where('member_of.id_membership', '<>', $id);
                    })
                    ->where('users.id', '<>', $id)
                    ->where(function ($query) use ($term) {
                        $query->where('users.name', 'LIKE', '%' . $term . '%')
                            ->orWhere('users.email', 'LIKE', '%' . $term . '%');
                    })
                    ->whereNull('my_member.id_user')
                    ->whereNull('member_of.id_membership')
                    ->distinct()
                    ->get();
    }

    public function checkToken(int $id = null) {
        $user = $this->pat->where(['tokenable_id'=>$id]);
        if($user->first()) {
            $date = date_create(date('Y-m-d H:i:s'));
            date_add($date, date_interval_create_from_date_string("1 month"));
            $date_expire = date_format($date, 'Y-m-d 23:59:59');

            $user->update([
                'expires_at' => $date_expire,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return 1;
        }
        return 0;
    }

    public function getToken(int $id = null) {
        return $this->pat->where(['tokenable_id'=>$id])->first();
    }

    public function lastUsedToken(String $data = null, int $id = null): int {
        return $this->pat->where(['tokenable_id' => $id])
                         ->update([
                            'last_used_at' => date('Y-m-d H:i:s')
                        ]);
    }

    public function updateTokenExpire(int $id = null) {
        $date = date_create(date('Y-m-d H:i:s'));
        date_add($date, date_interval_create_from_date_string("1 month"));
        $date_expire = date_format($date, 'Y-m-d 23:59:59');
        return $this->pat->where(['tokenable_id' => $id])->update(['expires_at' => $date_expire]);
    }

    public function createDir(String $email = '') {
        $final = $this->path.$email.'/';
        if(!File::isDirectory($final)) return File::makeDirectory($final, 0777, true, true);
    }

    public function readDir(String $email = ''): String {
        return $this->path.$email.'/';
    }

    public function deleteDir(String $email = '') {
        $final = $this->path.$email.'/';
        if(File::exists($final)) return File::deleteDirectory($final, 0777, true, true);
    }

    public function createToken($content, $pass) {
        $header = base64_encode(
            json_encode([
                'alg' => 'HS256', 
                'type' => 'JWT'
            ])
        );
        $payload = base64_encode(json_encode($content));
        $secretkey = base64_encode($pass);
        return $header.$payload.$secretkey;
    }

}
?>
