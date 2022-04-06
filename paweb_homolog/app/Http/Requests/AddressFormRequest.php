<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address-cdDevedor' => 'required|integer|min:1',
            'address-dsRua'     => 'required|max:80',
            'address-dsNumero'  => 'required|max:10',
            'address-dsCompl'   => 'max:30',
            'address-dsBairro'  => 'required|max:40',
            'address-dsCidade'  => 'required|max:50',
            'address-sgUF'      => 'required|max:2',
            'address-cdCep'     => 'required|max:10',
            'address-cdStatus'  => 'required|min:1|max:1',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'address-cdDevedor.required' => 'Devedor n&atilde;o identificado.',
            'address-cdDevedor.integer' => 'Devedor n&atilde;o identificado.',
            'address-cdDevedor.min' => 'Devedor n&atilde;o identificado.',

            'address-dsRua.required' => 'O campo [Rua] deve ser informado.',
            'address-dsRua.max' => 'O tamanho do campo [Rua] deve ser menor que :max caracteres.',

            'address-dsNumero.required' => 'O campo [No.] deve ser informado.',
            'address-dsNumero.max' => 'O tamanho do campo [No.] deve ser menor que :max caracteres.',

            'address-dsCompl.max' => 'O tamanho do campo [Complemento] deve ser menor que :max caracteres.',

            'address-dsBairro.required' => 'O campo [Bairro] deve ser informado.',
            'address-dsBairromax' => 'O tamanho do campo [Bairro] deve ser menor que :max caracteres.',

            'address-dsCidade.required' => 'O campo [Cidade] deve ser informado.',
            'address-dsCidade.max' => 'O tamanho do campo [Cidade] deve ser menor que :max caracteres.',

            'address-sgUF.required' => 'O campo [Estado] deve ser informado.',
            'address-sgUF.max' => 'O tamanho do campo [Estado] deve ser menor que :max caracteres.',

            'address-cdCep.required' => 'O campo [CEP] deve ser informado.',
            'address-cdCep.max' => 'O tamanho do campo [CEP] deve ser menor que :max caracteres.',

            'address-cdStatus.required' => 'O campo [Status] deve ser informado.',
            'address-cdStatus.min' => 'O tamanho do campo [Status] deve ter pelo menos :min caracteres.',
            'address-cdStatus.max' => 'O tamanho do campo [Status] deve ter no m&aacute;ximo :max caracteres.',
        ];
    }  
}
