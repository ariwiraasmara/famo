<?php
namespace App\Http\Interfaces\Repositories;

use App\Models\MemberOf;
use Illuminate\Support\Collection;
use App\Libraries\jsr;
use Strictus\Strictus;

interface MemberOfRepositoryInterface {

    public function __construct(MemberOf $table, jsr $jsr);
    public function get(int $id = 0, string $order = 'id_user', string $by = 'asc', bool $is_paging = false, int $numpages = null);
    public function getTable(int $id = 0, string $order = 'id_user', string $by = 'asc', bool $is_paging = false, int $numpages = null): Collection;
    public function store(array $data = null): int;
    public function update(array $data = null, array $where = null): int;
    public function delete(array $where = null): int;

}
?>
