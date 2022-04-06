<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Debtor;
use App\Models\History;
use App\Models\TelephoneLevel;
use App\Models\EmailLevel;
use App\Models\AddressLevel;
use App\Models\States;
use App\Http\Requests\HistoryFormRequest;

class HistoryController extends Controller
{
    private $debtor;
    private $history;
    private $telephoneLevel;
    private $emailLevel;
    private $addressLevel;
    private $states;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Debtor $debtor, 
                                History $history, 
                                TelephoneLevel $telephoneLevel, 
                                EmailLevel $emailLevel,
                                AddressLevel $addressLevel,
                                States $states)
    {
        $this->middleware('auth.ldap');

        $this->debtor = $debtor;
        $this->history = $history;
        $this->telephoneLevel = $telephoneLevel;
        $this->emailLevel = $emailLevel;
        $this->addressLevel = $addressLevel;
        $this->states = $states;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($debtorId)
    {
        if ($debtorId == 0){
            return view('index', compact('debtorId'));
        }

        $debtor = $this->debtor->getDebtor($debtorId);
        $histories = $this->history->getHistories($debtorId);

        $telephoneLevels = $this->telephoneLevel->getTelephoneLevels();
        $emailLevels = $this->emailLevel->getEmailLevels();
        $addressLevels = $this->addressLevel->getAddressLevels();
        $states = $this->states->getStates();

        return view('histories', compact('histories', 'debtor', 'debtorId', 'states', 'telephoneLevels', 'emailLevels', 'addressLevels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HistoryFormRequest $request)
    {
        $dataForm = $request->all();
        $debtorId = $dataForm['history-cdDevedor'];

        if ($this->history->storeHistory($dataForm)){
            return redirect()->back()->with('alert', 'Ocorrência incluída com sucesso!');
        }else{
            return redirect()->back();
        }
    }    
}
