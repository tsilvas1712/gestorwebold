<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Debtor;
use App\Models\Contract;
use App\Models\Address;
use App\Models\AddressLevel;
use App\Models\Telephone;
use App\Models\TelephoneLevel;
use App\Models\Email;
use App\Models\EmailLevel;
use App\Models\History;
use App\Models\HistoryType;
use App\Models\States;

class IndexController extends Controller
{
    private $debtor;
    private $contract;
    private $address;
    private $addressLevel;
    private $telephone;
    private $telephoneLevel;
    private $email;
    private $emailLevel;
    private $history;
    private $historyType;
    private $states;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Debtor $debtor, 
                                Contract $contract,
                                Address $address,
                                AddressLevel $addressLevel,
                                Telephone $telephone, 
                                TelephoneLevel $telephoneLevel, 
                                Email $email, 
                                EmailLevel $emailLevel, 
                                History $history,
                                HistoryType $historyType,
                                States $states
                                )
    {
        $this->middleware('auth.ldap');

        $this->debtor = $debtor;
        $this->contract = $contract;
        $this->address = $address;
        $this->addressLevel = $addressLevel;
        $this->telephone = $telephone;
        $this->telephoneLevel = $telephoneLevel;
        $this->email = $email;
        $this->emailLevel = $emailLevel;
        $this->history = $history;
        $this->historyType = $historyType;
        $this->states = $states;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $debtorId = 0)
    {
        $debtor = null;
        $contracts = [];
        $statusDebtor = '';
        $addresses = [];
        $telephones = [];
        $emails = [];
        $histories = [];

        if ($debtorId > 0){
            $debtor = $this->debtor->getDebtor($debtorId);
            $contracts = $this->contract->getcontracts($debtorId);
            $addresses = $this->address->getAddresses($debtorId);
            $telephones = $this->telephone->getTelephones($debtorId);
            $emails = $this->email->getEmails($debtorId);
            $statusDebtor = $this->debtor->getStatus($debtorId, 15);
            $histories = $this->history->getHistories($debtorId);
        }

        $historyTypes = $this->historyType->getHistoryTypes();
        $telephoneLevels = $this->telephoneLevel->getTelephoneLevels();
        $emailLevels = $this->emailLevel->getEmailLevels();
        $addressLevels = $this->addressLevel->getAddressLevels();
        $states = $this->states->getStates();

        $current_areaCode = Session::get('Cd_ddd');
        $current_phone = Session::get('Cd_Telefone');

        return view('index', compact('debtor', 'contracts', 'debtorId', 'statusDebtor', 'addresses', 'telephones', 'emails', 'histories', 'historyTypes', 'telephoneLevels', 'emailLevels', 'addressLevels', 'states', 'current_areaCode', 'current_phone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function contactsUpdate(Request $request)
    {
        $dataForm = $request->all();

        $debtorId = $dataForm['contact-cdDevedor'];
        $jsonTelephone = json_decode($dataForm['telephone-json']);
        $jsonEmail = json_decode($dataForm['email-json']);

        foreach ($jsonTelephone as $item) {
            if (! $this->telephone->updateTelephone($debtorId, $item->areaCode, $item->number, $item->status)){
                return redirect()->back();
            }
        }

        foreach ($jsonEmail as $item) {
            if (! $this->email->updateEmail($debtorId, $item->email, $item->status)){
                return redirect()->back();
            }
        }

        return redirect()->back()->with('alert', 'Contatos atualizados com sucesso!');
    }
}
