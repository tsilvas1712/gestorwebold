<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'Usuario';
    public $user;

    //protected $fillable = [
    //    'name', 'email', 'password',
    //];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getUser($id=''){
        if ($id == ''){
            $id = $this->getUserId();
        }
        if ($id == '0'){
            return '';
        }

        $this->user = $this->where('Cd_Usuario', $id)->get()->first();
        $this->user = convert_from_latin1_to_utf8_recursively($this->user);
        return $this->user;
    }

    public static function getDialerUserId(){
        $dialerUserId = Session::get('dialerUserId');
        if ($dialerUserId == null) $dialerUserId = '0';
        return $dialerUserId;
    }

    public static function getDialerExtension(){
        $dialerExtension = Session::get('dialerExtension');
        if ($dialerExtension == null) $dialerExtension = '0';
        return $dialerExtension;
    }

    public static function getDialerPassword(){
        $dialerPassword = Session::get('dialerPassword');
        if ($dialerPassword == null) $dialerPassword = '0';
        return $dialerPassword;
    }

    public static function setDialerUserId($username){
        //$username = 'CATIA.OLIVEIRA';
        //{"user_id":181,"ramal":"2192","ramal_password":"123"}

        $endpoint = config('app.izzycall.endpoint');
        $data['username'] = $username;
        $data = json_encode($data);

        $client = new \GuzzleHttp\Client();
        $response = $client->post($endpoint.'getuserid', [ \GuzzleHttp\RequestOptions::JSON => ['username' => $username] ]);

        if ($response->getStatusCode() == 200){
            $json = json_decode($response->getBody());

            if ($json->success){
                $return['userId'] = $json->response->user_id;
                $return['extension'] = $json->response->ramal;
                $return['password'] = $json->response->ramal_password;
            }else{
                $return = 0;
            }
        }else{
            $return = 0;
        }

        return $return;
    }

    public static function getUserId(){
        $userId = Session::get('userId');
        if ($userId == null) $userId = '0';
        return $userId;
    }

    public static function getUserName(){
        $user = (new static)->getUser();
        if ($user == '') return $user;
        return $user->Ds_Usuario;
    }

    public static function getUserComissionadoId(){
        return (new static)->getUser()->Cd_Comissionado;
    }


}
