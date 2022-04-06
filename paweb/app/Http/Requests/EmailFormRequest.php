<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailFormRequest extends FormRequest
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
            'email-cdDevedor'       => 'required|integer|min:1',
            'email-dsEmail'         => 'required|max:60',
            'email-cdClassificacao' => 'required|min:1|max:1',
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
            'email-cdDevedor.required' => 'Devedor n&atilde;o identificado.',
            'email-cdDevedor.integer' => 'Devedor n&atilde;o identificado.',
            'email-cdDevedor.min' => 'Devedor n&atilde;o identificado.',

            'email-dsEmail.required' => 'O campo [Email] deve ser informado.',
            'email-dsEmail.max' => 'O campo [Email] deve ser menor que :max caracteres.',

            'email-cdClassificacao.required' => 'O campo [Classifica&ccedil;&atilde;o] deve ser informado.',
            'email-cdClassificacao.min' => 'O tamanho do campo [Classifica&ccedil;&atilde;o] deve ter pelo menos :min caracteres.',
            'email-cdClassificacao.max' => 'O tamanho do campo [Classifica&ccedil;&atilde;o] deve ter no m&aacute;ximo :max caracteres.',
        ];
    }  
}
