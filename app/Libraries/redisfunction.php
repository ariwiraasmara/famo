<?php
namespace App\Libraries;
use Illuminate\Support\Facades\Redis;
class redisfunction {
    protected $redis;

    public function __constructor($index = null) {
        $this->redis = Redis::connection($index);
    }

    public function check(String $key = null) {
        return $this->redis->exists($key);
    }

    public function set(String $key = null, String|int|object $val = null) {
        return $this->redis->set($key, $val);
    }    

    public function get(String|int $key = null) {
        return $this->redis->get($key);
    }    
    // }
}
?>