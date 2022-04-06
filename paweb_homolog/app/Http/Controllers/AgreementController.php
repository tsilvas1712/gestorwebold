<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Models\Debtor;
use App\Models\Agreement;
use App\Models\Address;
use App\Models\Email;
use App\Models\Telephone;
use App\Models\Billet;
use App\Models\TelephoneLevel;
use App\Models\EmailLevel;
use App\Models\AddressLevel;
use App\Models\States;
use App\Models\Simulation;

class AgreementController extends Controller
{
    private $debtor;
    private $agreement;
    private $billet;
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
                                Agreement $agreement,
                                Billet $billet, 
                                TelephoneLevel $telephoneLevel, 
                                EmailLevel $emailLevel,
                                AddressLevel $addressLevel,
                                States $states,
                                Address $address,
                                Telephone $telephone, 
                                Email $email
                                )
    {
        $this->middleware('auth.ldap');

        $this->debtor = $debtor;
        $this->agreement = $agreement;
        $this->billet = $billet;
        $this->telephoneLevel = $telephoneLevel;
        $this->emailLevel = $emailLevel;
        $this->addressLevel = $addressLevel;
        $this->states = $states;
        $this->address = $address;
        $this->telephone = $telephone;
        $this->email = $email;

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
        $agreements = $this->agreement->getAgreements($debtorId);
        $billets = $this->billet->getBillets($debtorId);
        $telephoneLevels = $this->telephoneLevel->getTelephoneLevels();
        $emailLevels = $this->emailLevel->getEmailLevels();
        $addressLevels = $this->addressLevel->getAddressLevels();
        $states = $this->states->getStates();

        return view('agreements', compact('agreements', 'billets',  'debtor', 'debtorId', 'telephoneLevels', 'emailLevels', 'addressLevels', 'states'));
    }

    public function confirm(Request $request)
    {
        if ($request->method() == "POST"){
            $dataForm = $request->all();
            $debtorId = $dataForm['agreement-confirm-debtorId'];
            $simulationId = $dataForm['agreement-confirm-simulationId'];

            Session::put('debtorId', $debtorId );
            Session::put('simulationId', $simulationId );
        }else{
            $debtorId = Session::get('debtorId');
            $simulationId = Session::get('simulationId');
        }

        $simulationId = Crypt::decrypt($simulationId);
        $simulation = new Simulation();
        $simulationInstallments = $simulation->getSimulation($simulationId);

        if ($debtorId == 0){
            return view('index', compact('debtorId'));
        }

        $addresses = $this->address->getAddresses($debtorId);
        $telephones = $this->telephone->getTelephones($debtorId);
        $emails = $this->email->getEmails($debtorId);
        $telephoneLevels = $this->telephoneLevel->getTelephoneLevels();
        $emailLevels = $this->emailLevel->getEmailLevels();
        $addressLevels = $this->addressLevel->getAddressLevels();
        $states = $this->states->getStates();

        $current_areaCode = Session::get('Cd_ddd');
        $current_phone = Session::get('Cd_Telefone');

        return view('agreement-confirm', compact('debtorId', 'simulationInstallments', 'addresses', 'telephones', 'emails', 'addressLevels', 'emailLevels', 'telephoneLevels', 'states', 'current_areaCode', 'current_phone'));
    }
}
