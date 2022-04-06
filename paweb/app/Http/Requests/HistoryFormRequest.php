<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoryFormRequest extends FormRequest
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
            'history-cdDevedor'   => 'required|integer|min:1',
            'history-cdCredor'    => 'required|integer|min:1',
            'history-cdHistorico' => 'required|integer|min:1',
            'history-dsHistorico' => 'required|max:255',
            'history-dtAgenda'    => 'required|date|after_or_equal:today',
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
            'history-cdDevedor.required' => 'Devedor n&atilde;o identificado.',
            'history-cdDevedor.integer' => 'Devedor n&atilde;o identificado.',
            'history-cdDevedor.min' => 'Devedor n&atilde;o identificado.',

            'history-cdCredor.required' => 'Credor n&atilde;o identificado.',
            'history-cdCredor.integer' => 'Credor n&atilde;o identificado.',
            'history-cdCredor.min' => 'Credor n&atilde;o identificado.',

            'history-cdHistorico.required' => 'C&oacute;digo da ocorr&ecirc;ncia n&atilde;o identificado.',
            'history-cdHistorico.integer' => 'C&oacute;digo da ocorr&ecirc;ncia deve ser numeral.',
            'history-cdHistorico.min' => 'C&oacute;digo da ocorr&ecirc;ncia deve ser maior que zero.',

            'history-dsHistorico.required' => 'O texto da ocorr&ecirc;ncia deve ser informado.',
            'history-dsHistorico.max' => 'O tamanho do texto da ocorr&ecirc;ncia deve ser menor que :max caracteres.',

            'history-dtAgenda.required' => 'O campo [Dt Agenda] deve ser informado.',
            'history-dtAgenda.date' => 'O campo [Data Agenda] deve ser uma data.',
            'history-dtAgenda.after_or_equal' => 'O campo [Data Agenda] deve maior ou igual a hoje.',
        ];
    }  
}
