<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Http\Requests\AddressFormRequest;

class AddressController extends Controller
{
    private $address;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Address $address)
    {
        $this->middleware('auth.ldap');

        $this->address = $address;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressFormRequest $request)
    {
        $dataForm = $request->all();
        $debtorId = $dataForm['address-cdDevedor'];        

        if ($this->address->storeAddress($dataForm)){
            return redirect()->back()->with('alert', 'Endereço incluído com sucesso!');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $dataForm = $request->all();
        $debtorId = $dataForm['address-cdDevedor'];
        $json = json_decode($dataForm['address-json']);

        foreach ($json as $item) {
            if (! $this->address->updateAddress($debtorId, $item->id, $item->status)){
                return redirect()->back();
            }
        }

        return redirect()->back()->with('alert', 'Endereços alterados com sucesso!');
    }
}
