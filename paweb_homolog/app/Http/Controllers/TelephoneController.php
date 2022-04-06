<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Telephone;
use App\Http\Requests\TelephoneFormRequest;

class TelephoneController extends Controller
{
    private $telephone;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Telephone $telephone)
    {
        $this->middleware('auth.ldap');

        $this->telephone = $telephone;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TelephoneFormRequest $request)
    {
        $dataForm = $request->all();
        $debtorId = $dataForm['telephone-cdDevedor'];
        $areacode = $dataForm['telephone-cdDdd'];
        $number = $dataForm['telephone-cdTelefone'];

        $telephone = $this->telephone->getTelephone($debtorId, $areacode, $number);

        if ($telephone->count() > 0){
            return redirect()->back()->withErrors('Este telefone já existe.');
        }

        if ($this->telephone->storeTelephone($dataForm)){
            return redirect()->back()->with('alert', 'Telefone incluído com sucesso!');
        }else{
            return redirect()->back();
        }
    }    
}
