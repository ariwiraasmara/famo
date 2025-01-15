<?php
namespace App\Http\Interfaces\Repositories;

use App\Models\UserFile;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Libraries\jsr;
use Strictus\Strictus;
use File;

interface UserFileRepositoryInterface {

    public function __construct(UserFile $model, User $user, jsr $jsr);
    public function get(array $where = null);
    public function getAll(array $where = null, string $order = 'id', string $by = 'asc', bool $is_paging = false, int $numpages = 0);
    public function getID(int $iduser = 0): String;
    public function uploadFile($email, $file);

}
?>
