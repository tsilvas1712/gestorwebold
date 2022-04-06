<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use DB;

class Telephone extends Model
{
    protected $table = 'DevedorTelefone';
    protected $guarded = ['_token', 'oper'];
    public $timestamps = false;
    
    public function getTelephone($debtorId, $areacode, $number){
        $telephone = $this->where('Cd_devedor', $debtorId)
                          ->where('Cd_DDD', $areacode)
                          ->where('Cd_Telefone', $number)
                          ->get();
       
        if ($telephone->count() > 0) return $telephone[0];

        return $telephone;
    }

    public function getTelephones($debtorId, $type = ''){
        return DB::select("
                    select dt.Cd_DDD, dt.Cd_Telefone, dt.Cd_Classificacao
                    from devedortelefone dt (nolock) JOIN ClassificacaoTelefone ct (nolock)
                        on dt.Cd_Classificacao = ct.cd_classificacao
                    where dt.Cd_Devedor = :debtorId
                    and (dt.Tp_Telefone = :type1 or :type2 = '')
                    and IsNull(dt.Cd_Situacao, 'A') <> 'D'
                    and IsNull(dt.Cd_Classificacao, 'N') <> 'F'
                    order by ct.nr_ordem", ['debtorId' => $debtorId, 'type1' => $type, 'type2' => $type]);
    }

    public function updateTelephone($debtorId, $areacode, $number, $status){
        return $this->where('Cd_devedor', $debtorId)
                    ->where('Cd_DDD', $areacode)
                    ->where('Cd_Telefone', $number)
                    ->update(['Cd_Classificacao' => $status]);
    }

    public function storeTelephone($telephoneInfo){
        $telephone = new Telephone;
        $telephone->Cd_Devedor = $telephoneInfo['telephone-cdDevedor'];
        $telephone->Cd_DDD = $telephoneInfo['telephone-cdDdd'];
        $telephone->Cd_Telefone = $telephoneInfo['telephone-cdTelefone'];
        $telephone->Cd_Classificacao = $telephoneInfo['telephone-cdClassificacao'];
        $telephone->Cd_DDI = '';
        $telephone->Cd_Destinacao = '0';
        $telephone->Cd_Situacao = 'A';
        $telephone->fl_tipoinclusao = 'M';
        $telephone->Ds_Observacao = 'PAWeb';
        return $telephone->save();
    }

    public function sendSMS($areaCode, $number, $text){
        $sourceNumber = trim($areaCode) . trim($number);
        $userId = \User::getUserId();

        $sms = DB::select("
        Declare 
        @CodRetorno Int,
        @DescRetorno varchar(4000);

        Execute sppEnviarSMS '{$sourceNumber}', '{$text}', '{$userId}', @CodRetorno Output, @DescRetorno Output;

        Select @CodRetorno CodRetorno, @DescRetorno DescRetorno");

        
        //return $sms[0];
        $return['CodRetorno'] = '1';
        $return['DescRetorno'] = 'OK';
        return $return;
    }

    public function sendWhatsapp($areaCode, $number, $text){
        $areaCodeOut = config('app.robbu.areaCodeOut');
        $numberOut = config('app.robbu.numberOut');
        $token = config('app.robbu.token');

        $whats = new \GuzzleHttp\Client();
        $url = "http://s.robbu.com.br/wsInvenioAPI.ashx?" . 
               "token={$token}&".
               "acao=enviarmensagem&".
               "nomeusuario=GUSTAVO%20BORGES&".
               "dddtelefone={$areaCode}&".
               "numerotelefone={$number}&".
               "mensagem={$text}&".
               "canal=3&".
               "massivo=N&".
               "WhatsappSaidaDDD={$areaCodeOut}&".
               "WhatsappSaidaTelefone={$numberOut}";

        $res = $whats->get($url);

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