<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;
use App\Http\Requests\EmailFormRequest;

class EmailController extends Controller
{
    private $email;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Email $email)
    {
        $this->middleware('auth.ldap');

        $this->email = $email;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmailFormRequest $request)
    {
        $dataForm = $request->all();
        $debtorId = $dataForm['email-cdDevedor'];
        $emailDesc = $dataForm['email-dsEmail'];

        $email = $this->email->getEmail($debtorId, $emailDesc);

        if ($email->count() > 0){
            return redirect()->back()->withErrors('Este email já existe.');
        }

        if ($this->email->storeEmail($dataForm)){
            return redirect()->back()->with('alert', 'Email incluído com sucesso!');
        }else{
            return redirect()->back();
        }
    }    
}
