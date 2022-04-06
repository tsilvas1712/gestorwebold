<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Telephone;

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

    public function get(Request $request)
    {
        $debtorId = $request->input('debtorId');
        $type = $request->input('type');
        
        return $this->telephone->getTelephones($debtorId, $type);
    }
}
