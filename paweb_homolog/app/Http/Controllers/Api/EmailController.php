<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Email;

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

    public function get(Request $request)
    {
        $debtorId = $request->input('debtorId');
        
        return $this->email->getEmails($debtorId);
    }
}
