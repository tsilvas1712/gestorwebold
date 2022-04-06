<?php

namespace App\Http\Middleware;

use Closure;
use Adldap\Laravel\Facades\Adldap;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Models\Commissioned;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Auth\AuthLdapController;

class AuthLdap
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //> autenticação por token
        if (isset($request->token)){
            try{
                $token = explode('¿', Crypt::decrypt($request->token));
                $username = $token[0];
                $password = $token[1];
            } catch (\RuntimeException $e) {
                return response("Token inválido.",400);
            }
            $authLdap = new AuthLdapController();
            
            $response = $authLdap->loginLdap($username, $password);
            if (!$response['return']){
                return response("Token inválido:{$response['error']}",400);
            }
        }
        
        $userId = Session::get('userId');
        $user = new User;
        $user = $user->getUser($userId);

        if ($user){
            if ($user->Cd_Comissionado == null){
                Session::put('commissionedId', 0 );
            }else{
                Session::put('commissionedId', $user->Cd_Comissionado );
            }

            return $next($request);
        }else{
            return redirect('/login');            
        }
    }
}
