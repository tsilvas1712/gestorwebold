<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function getToken(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if (($username == null) || ($password == null) ||
           ($username == '') || ($password == '') ){
            return response('Parâmetros não informados corretamente.',400);
        }else{
            $token = Crypt::encrypt($username.'¿'.$password);
            return response()->json($token)->header('Content-Type', 'application/json');
        }
    }
}
