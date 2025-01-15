<?php
namespace App\Http\Interfaces\Repositories;

interface UserFileRepositoryInterface {
    public function __construct(UserFile $model, User $user, jsr $jsr);
}
?>
