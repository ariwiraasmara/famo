<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MemberConfirmation;
use App\Models\MyMember;
use App\Models\MemberOf;
use App\Models\UserFile;
use Strictus\Strictus;

class DebugController extends Controller {
    //

    public function __construct(protected User $user, 
                                protected MemberConfirmation $confirm, 
                                protected Mymember $member,
                                protected MemberOf $membership,
                                protected UserFile $file) {

    }

    public function memberchild() {
        return $this->member->select('mid', )->all();
    }

}
