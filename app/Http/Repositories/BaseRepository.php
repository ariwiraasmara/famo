<?php
namespace App\Http\Repositories;

use Illuminate\Support\Collection;
use App\Libraries\jsr;

class BaseRepository {
    public function store(array $data = null): int {
        if($this->model->create($data)) return 1;
        return 0;
    }

    public function update(array $data = null, array $where = null): int {
        if($this->model->where($where)->update($data)) return 1;
        return 0;
    }

    public function delete(array $where = null): int {
        if($this->model->where($where)->delete()) return 1;
        return 0;
    }
}
?>