<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use App\Libraries\myfunction;

class MemberSeeder extends Seeder {

    public function createMyMember1(String $email = mull, 
                                    String $counterid = mull,
                                    int $iduser = 0,
                                    int $idmember = 0) {
        \App\Models\MyMember::create(
            [
                'mid'       => 'MEMBER@'.$email.'#'.$counterid,
                'id_user'   => $iduser,
                'id_member' => $idmember,
            ]
        );
    }

    public function createMyMember2(String $email = mull,
                                    int $user = 0, 
                                    int $su = 0, 
                                    int $eu = 0): void {
        $i = 1;
        for($x = $su; $x < $eu; $x++) {
            \App\Models\MyMember::create(
                [
                    'mid'       => 'MEMBER@'.$email.'#000000000000000'.$i,
                    'id_user'   => $user,
                    'id_member' => $x,
                ]
            );
            $i++;
        }
    }

    public function run(): void {
        $i = 1;
        for($x = 2; $x < 5; $x++) {
            \App\Models\MyMember::create(
                [
                    'mid'       => 'MEMBER@username1@usermail.com#000000000000000'.$i,
                    'id_user'   => 1,
                    'id_member' => $x,
                ]
            );

            \App\Models\MemberOf::create(
                [
                    'mid'           => 'MEMBER@username1@usermail.com#000000000000000'.$i,
                    'id_user'       => $x,
                    'id_membership' => 1,
                    'date_join'     => date('Y-m-d h:i:s')
                ]
            );
            $i++;
        }

        $i = 1;
        for($x = 3; $x < 6; $x++) {
            \App\Models\MyMember::create(
                [
                    'mid'       => 'MEMBER@username2@usermail.com#000000000000000'.$i,
                    'id_user'   => 2,
                    'id_member' => $x,
                ]
            );

            \App\Models\MemberOf::create(
                [
                    'mid'           => 'MEMBER@username2@usermail.com#000000000000000'.$i,
                    'id_user'       => $x,
                    'id_membership' => 2,
                    'date_join'     => date('Y-m-d h:i:s')
                ]
            );
            $i++;
        }

        $i = 1;
        for($x = 4; $x < 7; $x++) {
            \App\Models\MyMember::create(
                [
                    'mid'       => 'MEMBER@username3@usermail.com#000000000000000'.$i,
                    'id_user'   => 3,
                    'id_member' => $x,
                ]
            );

            \App\Models\MemberOf::create(
                [
                    'mid'           => 'MEMBER@username3@usermail.com#000000000000000'.$i,
                    'id_user'       => $x,
                    'id_membership' => 3,
                    'date_join'     => date('Y-m-d h:i:s')
                ]
            );
            $i++;
        }
    }
}