<?php

namespace App\Http\Middleware;

use DB;
use Closure;
use App\Models\User;
use App\Models\PersonalAccessTokens;
use App\Libraries\myfunction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');
        $authenticated = true;

        if(!$token) {
            $authenticated = false;
        }

        $bearerToken = json_decode(base64_decode($request->bearerToken()));
        if($bearerToken == null) {
            abort(401, 'Token tidak valid');
        }

        if($authenticated) {
            $getDBToken = $this->getPersonalAccessTokens(myfunction::decrypt($bearerToken->tokenable_id));
            if(myfunction::decrypt($bearerToken->name) == $getDBToken[0]['name']) {
                $lastusedtoken = $this->lastUsedToken(myfunction::decrypt($bearerToken->tokenable_id));
                $user = $this->getUser(myfunction::decrypt($bearerToken->tokenable_id));
                // Auth::login($request);
                return $next($request);
            }
            return Response(['message' => 'Brak!']);
        }
        else {
            return Response([
                'message' => 'Unauthenticated!!!',
            ]);
        }
    }

    protected function getUser(int $id = 0) {
        return User::where(['id'=>$id])->get();
    }

    protected function getPersonalAccessTokens(int $id = 0) {
        return PersonalAccessTokens::where(['tokenable_id'=>$id])->get();
    }

    protected function lastUsedToken(int $id = 0) {
        return PersonalAccessTokens::where(['tokenable_id' => $id])
                                ->update([
                                    'last_used_at' => date('Y-m-d H:i:s')
                                ]);
    }
}
