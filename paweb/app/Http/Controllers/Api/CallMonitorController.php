<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use App\Models\IncomingCall;
use App\Models\Debtor;
use App\User;
use DB;
class CallMonitorController extends Controller
{
    private $incomingCall;
    private $user;
    private $debtor;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.ldap');

        $this->incomingCall = new IncomingCall();
        $this->user = new User();
        $this->debtor = new Debtor();
    }

    public function getExtenState(Request $request){
		//return;
		$user_id = $request->user_id;
		$two = DB::connection('mysql')->select(DB::raw("select interface,paused from queues_members where membername = 'MCA/".$user_id."'"));
		if(count($two) > 0){
                        ///LOG::info($two[0]->paused."  TESTE PAUSA ".$request->user_id);
                        return response()->json((array("success"=>true,"response"=>array("pause"=>$two[0]->paused))));
                }else{
                        return response()->json((array("success"=>false)));
                }
    }
    private function getDebtorId()
    {
        /*
        $return['success'] = true;
        $return['debtorId'] = 12345678;
        $return['phone'] = '51985508885';

        return $return;
        */
        /**************************************/

        $endpoint = config('app.izzycall.endpoint');
        $dialerUserId = $this->user->getDialerUserId();

        $client = new \GuzzleHttp\Client();
        $response = $client->post($endpoint.'getiddevedor', [ \GuzzleHttp\RequestOptions::JSON => ['user_id' => $dialerUserId] ]);

        $return['success'] = false;
        $return['debtorId'] = 0;
        $return['phone'] = '';
        $return['dialerId'] = 0;

        if ($response->getStatusCode() == 200){
            $json = json_decode($response->getBody());

            if ($json->success){
                $return['success'] = true;
                $return['debtorId'] = $json->response->id_devedor;
                $return['phone'] = $json->response->phone;
                $return['dialerId'] = $json->response->job_id;
            }
        }

        return $return;
    }

    public function index(Request $request)
    {
        $count = 0;
        $return['success'] = false;
        $return['debtorId'] = 0;
        $return['debtorName'] = '';
        $return['phone'] = '';
        $return['receptive'] = false;
        $return['dialerId'] = 0;
        
        do {
            sleep(1);
            $call = $this->incomingCall->getIncomingCall();
            $count++;
        } while ( ($call->count() == 0) && ($count < 10) );

        if ($call->count() > 0){
            $this->incomingCall->clearCalls();

            if ($call->Fl_Tipo == 'R'){
                $return['success'] = true;
                $return['receptive'] = true;
                $phone = $call->Cd_Telefone;
            }else{
                //> get debtorId from API Izzycall
                $res = $this->getDebtorId();

                if ($res['success']){
                    $return['success'] = true;

                    $return['debtorId'] = $res['debtorId'];
                    $return['dialerId'] = $res['dialerId'];
                    
                    $debtor = $this->debtor->getDebtor($res['debtorId']);
                    if ($debtor){
                        $return['debtorName'] = $debtor->Ds_Nome;
                    }
                    $phone = $res['phone'];

                    $return['phone'] = $phone;

                    Session::put('Cd_ddd', substr($phone,0,2) );
                    Session::put('Cd_Telefone', substr($phone,2,9) );
                    Session::put('dialerId', $res['dialerId'] );
                }
            }
        }

        return $return;
    }

    public function callInProgress(Request $request)
    {
        $count = 0;

        $call = $this->incomingCall->getCallInProgress();
        $return['success'] = ($call->count() > 0);

        return $return;
    }

}
