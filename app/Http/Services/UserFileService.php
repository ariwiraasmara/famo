<?php
namespace App\Http\Services;

use App\Http\Interfaces\Services\UserFileServiceInterface;
use App\Http\Repositories\UserFileRepository;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\Collection;
use App\Libraries\jsr;
use App\Libraries\myfunction;
use Strictus\Strictus;

class UserFileService implements UserFileServiceInterface {

    public function __construct(protected UserFileRepository $repo, 
                                protected UserRepository $user,
                                protected jsr $jsr, 
                                protected myfunction $fun) {

    }

    public function readFile(String $email = null, String $file = null): String {
        return $this->user->readDir($email).$file;
    }

    public function getFile(String $id = null): Collection {
        return collect($this->repo->get(['id'=>$id]));
    }

    public function getAllFile(int $userid = null) {
        $data = $this->repo->getAll(['user_file.id_user'=>$userid]);
        return match($data) {
            null => 0,
            default => $data
        };
    }

    public function getExtension(String $str = null): String {
        return match($str){
            'pdf'   => 'pdf',
            'jfif'  => 'image', 
            'pjpeg' => 'image', 
            'jpeg'  => 'image', 
            'pjp'   => 'image', 
            'jpg'   => 'image', 
            'png'   => 'image', 
            default => null
        };
    }

    public function addFile(array $data = null) {
        if($data['filesize'] > 1000000000) return -1;
        return $this->repo->store([
            'id'        => $this->repo->getID($data['id_user']),
            'id_user'   => $data['id_user'],
            'foto'      => $data['filename'],
            'filetype'  => $this->getExtension($data['extension']),
            'ket'       => $data['fileinfo'],
        ]);
    }

    public function deleteFile(array $where = null) {
        return $this->repo->delete($where);
        if($this->repo->delete($where)) return 1;
        return 0;
    }

}
