<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConcursoRequest extends FormRequest
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
            'título'                                        => 'required|max:100',
            'quantidade_de_vagas'                           => 'required',
            'descrição'                                     => 'required|max:1000',
            'data_de_início_da_inscrição'                   => 'required',
            'data_de_término_da_inscrição'                  => 'required|after:data_de_início_da_inscrição',
            'data_limite_para_isenção'                      => 'required|after:data_de_início_da_inscrição',
            'data_limite_para_pagamento'                    => 'required|after:data_de_início_da_inscrição',
            'data_de_início_para_envio_dos_documentos'      => 'required|after:data_de_término_da_inscrição',
            'data_final_para_envio_dos_documentos'          => 'required|after:data_de_início_para_envio_dos_documentos',
            'data_do_resultado_do_concurso'                 => 'required|after:data_final_para_envio_dos_documentos',
            'edital_geral'                                  => 'nullable|file|mimes:pdf|max:2048',
            'edital_específico'                             => 'nullable|file|mimes:pdf|max:2048',
            'declaração_de_veracidade'                      => 'nullable|file|mimes:pdf,docx|max:2048',
            'opcoes_vaga'                                   => 'required',
            'opcoes_vaga.*'                                 => 'required',
            'tipo'                                          => 'required',
        ];
    }
}
