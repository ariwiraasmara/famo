<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use App\Libraries\myfunction;

class MemberConfirmationSeeder extends Seeder {
    public function run(): void {

        for($user1 = 2; $user1 < 5; $user1++) {
            \App\Models\MemberConfirmation::create([
                'idc'           => 'IDC@'.date('Ymd').'1'.$user1.date('His'),
                'date_ask'      => date('Y-m-d H:i:s'),
                'date_confirm'  => null,
                'id_requestor'  => 1,
                'id_recipient'  => $user1,
                'type'          => 'invite',
                'is_rejected'   => null
            ]);
        }

        for($user2 = 5; $user2 < 8; $user2++) {
            \App\Models\MemberConfirmation::create([
                'idc'           => 'IDC@'.date('Ymd').'2'.$user2.date('His'),
                'date_ask'      => date('Y-m-d H:i:s'),
                'date_confirm'  => null,
                'id_requestor'  => 2,
                'id_recipient'  => $user2,
                'type'          => 'invite',
                'is_rejected'   => null
            ]);
        }

        for($user3 = 8; $user3 < 11; $user3++) {
            \App\Models\MemberConfirmation::create([
                'idc'           => 'IDC@'.date('Ymd').'2'.$user3.date('His'),
                'date_ask'      => date('Y-m-d H:i:s'),
                'date_confirm'  => null,
                'id_requestor'  => 3,
                'id_recipient'  => $user3,
                'type'          => 'invite',
                'is_rejected'   => null
            ]);
        }
    }
}