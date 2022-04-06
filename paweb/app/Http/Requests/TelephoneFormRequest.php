<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TelephoneFormRequest extends FormRequest
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
            'telephone-cdDevedor'       => 'required|integer|min:1',
            'telephone-cdDdd'           => 'required|integer|min:11|max:99',
            'telephone-cdTelefone'      => 'required|integer|min:10000000|max:999999999',
            'telephone-cdClassificacao' => 'required|min:1|max:1',
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
            'telephone-cdDevedor.required' => 'Devedor n&atilde;o identificado.',
            'telephone-cdDevedor.integer' => 'Devedor n&atilde;o identificado.',
            'telephone-cdDevedor.min' => 'Devedor n&atilde;o identificado.',

            'telephone-cdDdd.required' => 'O campo [DDD] deve ser informado.',
            'telephone-cdDdd.integer' => 'Credor n&atilde;o identificado.',
            'telephone-cdDdd.min' => 'O campo [DDD] deve ser maior ou igual a :min.',
            'telephone-cdDdd.max' => 'O campo [DDD] deve ser menor ou igual a :max.',

            'telephone-cdTelefone.required' => 'O campo [Telefone] deve ser informado.',
            'telephone-cdTelefone.integer' => 'Credor n&atilde;o identificado.',
            'telephone-cdTelefone.min' => 'O campo [Telefone] deve ter 8 ou 9 caracteres.',
            'telephone-cdTelefone.max' => 'O campo [Telefone] deve ter 8 ou 9 caracteres.',

            'telephone-cdClassificacao.required' => 'O campo [Classifica&ccedil;&atilde;o] deve ser informado.',
            'telephone-cdClassificacao.min' => 'O tamanho do campo [Classifica&ccedil;&atilde;o] deve ter pelo menos :min caracteres.',
            'telephone-cdClassificacao.max' => 'O tamanho do campo [Classifica&ccedil;&atilde;o] deve ter no m&aacute;ximo :max caracteres.',
        ];
    }  
}
