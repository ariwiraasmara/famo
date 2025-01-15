<?php
namespace App\Http\Interfaces\Repositories;

use App\Models\MemberConfirmation;
use Illuminate\Support\Collection;
use App\Libraries\jsr;
use Strictus\Strictus;

interface MemberConfirmationRepositoryInterface {

    public function __construct(MemberConfirmation $memberconfirmation, jsr $jsr);
    public function get(array $where = null): Collection;
    public function getDetail(array $where = null, string $order = null, string $by = null, bool $is_paging = false, int $numpages = null);

}
?>
