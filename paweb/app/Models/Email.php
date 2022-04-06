<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use DB;

class Email extends Model
{
    protected $table = 'DevedorEmail';
    protected $guarded = ['_token', 'oper'];
    public $timestamps = false;
    
    public function getEmail($debtorId, $email){
        $email = $this
                    ->where('Cd_devedor', $debtorId)
                    ->where('Ds_Email', $email)
                    ->get();

        if ($email->count() > 0) return $email[0];

        return $email;
    }

    public function getEmails($debtorId){
        return DB::select("
                    select de.Ds_Email, de.Cd_Classificacao
                    from DevedorEmail de (nolock) JOIN ClassificacaoEmail ce (nolock)
                        on de.Cd_Classificacao = ce.cd_classificacao
                    where Cd_Devedor = :debtorId
                    order by ce.nr_ordem", ['debtorId' => $debtorId]);
    }

    public function updateEmail($debtorId, $email, $status){
        return $this
                    ->where('Cd_devedor', $debtorId)
                    ->where('Ds_Email', $email)
                    ->update(['Cd_Classificacao' => $status]);
    }

    public function storeEmail($dataForm){
        $email = new Email;
        $email->Cd_Devedor = $dataForm['email-cdDevedor'];
        $email->Ds_Email = $dataForm['email-dsEmail'];
        $email->Cd_Classificacao = $dataForm['email-cdClassificacao'];
        $email->Cd_Credor = '0';
        $email->fl_situacao = 'A';
        return $email->save();
    }

    public function sendEmail($emailAddress, $text){
        $token = config('app.robbu.token');

        $email = new \GuzzleHttp\Client();
        $url = "http://s.robbu.com.br/wsInvenioAPI.ashx?" . 
               "token={$token}&".
               "acao=enviarmensagem&".
               "nomeusuario=GUSTAVO%20BORGES&".
               "EnderecoEmail={$emailAddress}&".
               "mensagem={$text}&".
               "canal=1&".
               "massivo=N";

        $res = $email->get($url);

        if ($res->getStatusCode() == 200){
            $json = json_decode($res->getBody());

            if (isset($json->erro->mensagem)){
                $return['success'] = 0;
                $return['return'] = $json->erro->mensagem;
            }else{
                $return['success'] = 1;
                $return['return'] = $json->sucesso->mensagem;
            }
        }else{
            $return['success'] = 0;
            $return['return'] = 'Erro interno no Robbu. Status: '. $res->getStatusCode();
        }

        return $return;
    }

}