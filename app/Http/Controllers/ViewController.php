<?php
namespace App\Http\Controllers;

use App\Http\Services\UserService;
use App\Http\Services\MemberConfirmationService;
use App\Http\Services\MyMemberService;
use App\Http\Services\MemberOfService;
use App\Http\Services\UserFileService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Libraries\myfunction;
use Redirect;
use Strictus\Strictus;

class ViewController extends Controller {
    //

    protected $redis;
    protected int $id;
    protected String $name, $email, $token;
    protected $islogin;

    public function __construct(protected UserService $user,
                                protected MemberConfirmationService $memberconfirmation,
                                protected MyMemberService $mymember,
                                protected MemberOfService $memberof,
                                protected UserFileService $file,
                                protected myfunction $fun) {
        $this->redis = Redis::connection('0');
    }

    protected function islogin() {
        $ceklogin = $this->fun->getCookie('islogin');
        if($ceklogin > 0) {
            $this->islogin  = true;
            $this->id       = $this->fun->getCookie('id');
            $this->name     = $this->fun->getCookie('name');
            $this->email    = $this->fun->getCookie('email');
            $this->token    = $this->fun->getCookie('token');
        }
    }

    protected function checklogin(String $page = null) {
        if(isset($_COOKIE['islogin'])) return redirect($page);
        return redirect('/');
    }

    public function index() {
        if(isset($_COOKIE['islogin'])) return redirect('dashboard');
        return Inertia::render('Welcome', ['islogin'=>false]);
    }

    public function getNotification(int $id) {
        return match($this->redis->exists('getnotification')) {
            1 => $this->redis->get('getnotification'),
            default => $this->memberconfirmation->getAllNotification(
                [
                    'id_recipient' => $id,
                    'date_confirm' => null
                ], // array $where = null
                'date_ask',  // string $order = null
                'desc', // string $by = null
                false, // bool $is_paging = false
                11 // int $numpages = 0
            )
        };
    }

    public function dashboard() {
        $this->islogin();

        // $recent_membership = empty($this->memberof->getRecentMembership($this->id)) ? 0 : $this->memberof->getRecentMembership($this->id);
        $recent_membership = match($this->memberof->getRecentMembership($this->id)) {
            1 => 0,
            default => $this->memberof->getRecentMembership($this->id),
        };

        $cache_recent_membership = match($this->redis->exists('recent_membership')) {
            1 => $this->redis->get('recent_membership'),
            default => $recent_membership
        };
        
        // $recent_mymember = empty($this->mymember->getRecentMember($this->id)) ? 0 : $this->mymember->getRecentMember($this->id);
        $recent_mymember = match($this->mymember->getRecentMember($this->id)) {
            1 => 0,
            default => $this->mymember->getRecentMember($this->id),
        };
        
        $cache_recent_mymember = match($this->redis->exists('recent_membership')) {
            1 => $this->redis->get('recent_mymember'),
            default => $recent_mymember
        };

        return Inertia::render('Dashboard',
            [
                'isLogin'          => $this->islogin,
                'name'             => $this->name,
                'recent_membership'=> $cache_recent_membership,
                'recent_mymember'  => $cache_recent_mymember,
                'notif'            => $this->getNotification($this->id),
                'nav_active'       => 'dashboard'
            ]
        );
    }

    public function mymember() {
        if(!isset($_COOKIE['islogin'])) return redirect('/');
        $this->islogin();
        $data = $this->mymember->allParentChildMember($this->id);
        $cache_data = match($this->redis->exists('mymember')) {
            1 => $this->redis->get('mymember'),
            default => $data
        };
        // return $data;
        return Inertia::render('mymember/Mymember',
            [
                'isLogin'    => $this->islogin,
                'iduser'     => $this->id,
                'name'       => $this->name,
                'member'     => $cache_data,
                'notif'      => $this->getNotification($this->id),
                'nav_active' => 'mymember'
            ]
        );
    }

    public function memberof() {
        if(!isset($_COOKIE['islogin'])) return redirect('/');
        $this->islogin();
        $data = $this->memberof->allMembership($this->id);
        $cache_data = match($this->redis->exists('membership')) {
            1 => $this->redis->get('membership'),
            default => $data
        };
        // return $data;
        return Inertia::render('memberof/Memberof',
            [
                'isLogin'    => $this->islogin,
                'iduser'     => $this->id,
                'name'       => $this->name,
                'membership' => $cache_data,
                'notif'      => $this->getNotification($this->id),
                'nav_active' => 'memberof'
            ]
        );
    }

    public function profile() {
        if(!isset($_COOKIE['islogin'])) return redirect('/');
        $this->islogin();
        $path = $this->file->readFile($this->email);

        $profile = $this->user->profile($this->id);
        $cache_profile = match($this->redis->exists('profile')) {
            1 => $this->redis->get('profile'),
            default => $profile
        };

        $allfile = $this->file->getAllFile($this->id);
        $cache_allfile = match($this->redis->exists('allfile')) {
            1 => $this->redis->get('allfile'),
            default => $allfile
        };
        return Inertia::render('Profile/ViewProfile',
            [
                'isLogin'   => $this->islogin,
                'profile'   => $cache_profile,
                'path'      => $path,
                'allfile'   => $cache_allfile,
                'notif'     => $this->getNotification($this->id)
            ]
        );
    }

    public function allnotification() {
        if(!isset($_COOKIE['islogin'])) return redirect('/');
        $this->islogin();
        $data = $this->memberconfirmation->getAllNotification(
            ['id_recipient' => $this->id],
            'date_ask',  // string $order = null
            'desc', // string $by = null
            false, // bool $is_paging = false
            null // int $numpages = 0
        );
        $cache_data = match($this->redis->exists('allnotification')) {
            1 => $this->redis->get('allnotification'),
            default => $data
        };

        return Inertia::render('notification/AllNotif',
            [
                'isLogin'   => $this->islogin,
                'name'      => $this->name,
                'notif'     => $this->getNotification($this->id),
                'allnotif'  => $cache_data
            ]
        );
    }

}
