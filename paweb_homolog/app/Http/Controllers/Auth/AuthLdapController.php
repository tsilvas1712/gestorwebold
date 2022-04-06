<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;
use Illuminate\Support\Facades\Session;

class AuthLdapController extends Controller
{
    public function logout()
    {
        Session::put('userId', '' );
        return redirect()->intended('/login');
    }

    public function loginLdap($username, $password)
    {
        $domain = "blcobranca\\";
        $response = [];
        if (Adldap::auth()->attempt($domain.$username, $password, true)){
            $user = \App\User::where($this->username(), $username)->first();

            if ( !$user ) {
                $response['return'] = false;
                $response['error'] = 'Usuário não configurado no CRM';
            }else{
                $dialerResponse = \App\User::setDialerUserId($username);

                if ($dialerResponse == 0){
                    $response['return'] = false;
                    $response['error'] = 'Usuário não cadastrado no IzzyCall';                        
                }else{
                    if ( ($dialerResponse['extension'] == null) || ($dialerResponse['extension'] == 0) ){
                        $response['return'] = false;
                        $response['error'] = 'Ramal do usuário não configurado no IzzyCall';
                    }else{
                        Session::put('dialerUserId', $dialerResponse['userId'] );
                        Session::put('dialerExtension', $dialerResponse['extension'] );
                        Session::put('dialerPassword', $dialerResponse['password'] );
                        Session::put('userId', $user->Cd_Usuario );
                        $response['return'] = true;
                        $response['error'] = '';
                    }
                }
            }
        }else{
            $response['return'] = false;
            $response['error'] = 'Usuário ou senha incorretos';
        }

        return $response;
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $response = $this->loginLdap($username, $password);

        if ($response['return']){
            return redirect()->intended('/');
        }else{
            return back()->withErrors($response['error']);
        }
    }

    public function username()
    {
        return 'Cd_UsuarioAD';
    } 

}
