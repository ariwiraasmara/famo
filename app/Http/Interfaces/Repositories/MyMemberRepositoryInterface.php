<?php
namespace App\Http\Interfaces\Repositories;

use App\Models\MyMember;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Libraries\jsr;
use Strictus\Strictus;

interface MyMemberRepositoryInterface {

    public function __construct(MyMember $table, User $user, jsr $jsr);
    public function getID(array $where = null, int $iduser = 0): String;
    public function get(int $id = 0, string $order = 'my_member.mid', string $by = 'asc', bool $is_paging = false, int $numpages = null);
    public function getChild($id = 0, $order = 'my_member.mid', $by = 'asc');

}
?>
