<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioCreateRequest extends FormRequest
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
            'nombres'=>'required',
            'apellidos'=>'required',
            'email'=>'required|unique:usuario',
            'password'=>'required',
            'idtipousuario'=>'required',
        	'numerodocumento'=>'required',
        	'celular'=>'required',
        ];
    }
}
