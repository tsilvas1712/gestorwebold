<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Address extends Model
{
    protected $table = 'DevedorEndereco';
    protected $guarded = ['_token', 'oper'];
    public $timestamps = false;
    
    public function getAddresses($id){
        $addresses = $this
                        ->select('Cd_Endereco', 'Ds_Logradouro', 'Ds_NumeroEnd', 'Ds_Complemento', 'Ds_Bairro', 'Ds_Cidade', 'Sg_UF', 'Cd_Cep', 'Cd_Classificacao')
                        ->where('Cd_Devedor', $id)
                        ->orderBy('Cd_Endereco', 'Desc')
                        ->get();
        
        $addresses = convert_from_latin1_to_utf8_recursively($addresses);

        return $addresses;
    }

    public function storeAddress($dataForm){
        $address = new Address;
        $address->Cd_Devedor = $dataForm['address-cdDevedor'];
        $address->Ds_Logradouro = $dataForm['address-dsRua'];
        $address->Ds_NumeroEnd = $dataForm['address-dsNumero'];
        $address->Ds_Complemento = $dataForm['address-dsCompl'];
        $address->Ds_Bairro = $dataForm['address-dsBairro'];
        $address->Ds_Cidade = $dataForm['address-dsCidade'];
        $address->Sg_UF = $dataForm['address-sgUF'];
        $address->Cd_Cep = $dataForm['address-cdCep'];
        $address->Cd_Classificacao = $dataForm['address-cdStatus'];

        return $address->save();
    }

    public function updateAddress($debtorId, $id, $status){
        return $this
                    ->where('Cd_devedor', $debtorId)
                    ->where('Cd_Endereco', $id)
                    ->update(['Cd_Classificacao' => $status]);
    }

}