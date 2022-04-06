<?php
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::routes();
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
//Route::post('login', 'Auth\LoginController@login');
//Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'IndexController@index')->name('index');

Route::group(['prefix' => 'debtor'], function () {
    Route::get('/{debtorId?}', 'IndexController@index');
    Route::post('/contacts/update', 'IndexController@contactsUpdate')->name('address.contacts.update');
});


Route::group(['prefix' => 'address'], function () {
    Route::post('/store', 'AddressController@store')->name('address.store');
    Route::post('/update', 'AddressController@update')->name('address.update');
});

Route::group(['prefix' => 'telephone'], function () {
    Route::post('/store', 'TelephoneController@store')->name('telephone.store');
});

Route::group(['prefix' => 'email'], function () {
    Route::post('/store', 'EmailController@store')->name('email.store');
});

Route::group(['prefix' => 'history'], function () {
    Route::get('/{debtorId}', 'HistoryController@index')->name('history');
    Route::post('/store', 'HistoryController@store')->name('history.store');
});

Route::group(['prefix' => 'agreement'], function () {
    Route::get('/show/{debtorId}', 'AgreementController@index')->name('agreement.show');
    Route::post('/confirm', 'AgreementController@confirm')->name('agreement.confirm');
    Route::get('/confirm', 'AgreementController@confirm')->name('agreement.confirm');
});

Route::get('/sipml5', function () {
    return view('templates.easycall');
});

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'token'], function () {
        Route::post('/get', 'Api\AuthController@getToken')->name('api.auth.gettoken');
    });

    Route::group(['prefix' => 'debtor'], function () {
        Route::post('/search', 'Api\DebtorController@search')->name('api.debtor.search');
        Route::post('/get', 'Api\DebtorController@get')->name('api.debtor.get');
    });

    Route::group(['prefix' => 'telephone'], function () {
        Route::post('/get', 'Api\TelephoneController@get')->name('api.telephone.get');
    });

    Route::group(['prefix' => 'email'], function () {
        Route::post('/get', 'Api\EmailController@get')->name('api.email.get');
    });

    Route::group(['prefix' => 'billet'], function () {
        Route::post('/message', 'Api\BilletController@message')->name('api.billet.message');
        Route::post('/email', 'Api\BilletController@email')->name('api.billet.email');
        Route::post('/print', 'Api\BilletController@printBillet')->name('api.billet.print');
    });

    Route::group(['prefix' => 'agreement'], function () {
        Route::post('/installment', 'Api\AgreementInstallmentController@get')->name('api.agreement-installment.get');
        Route::post('/original', 'Api\AgreementOriginalController@get')->name('api.agreement-original.get');
        Route::post('/store', 'Api\AgreementController@store')->name('api.agreement.store');
        Route::post('/cancel', 'Api\AgreementController@cancel')->name('api.agreement.cancel');
    });

    Route::group(['prefix' => 'estimate'], function () {
        Route::post('/create', 'Api\EstimateController@create')->name('api.estimate.create');
        Route::post('/get', 'Api\EstimateController@get')->name('api.estimate.get');
    });

    Route::post('/callMonitor', 'Api\CallMonitorController@index')->name('api.callMonitor.index');
    Route::post('/getExtenState', 'Api\CallMonitorController@getExtenState')->name('api.callMonitor.getExtenState');
    Route::post('/callInProgress', 'Api\CallMonitorController@callInProgress')->name('api.callMonitor.callInProgress');
});

//Auth::routes();

Route::get('/login', function () {
    return view('login');
});
Route::get('/session/expired', function (Request $request) {
    $debtorId = 0;
    return view('errors.session-expired', compact('debtorId'));
});
Route::post('login', 'Auth\AuthLdapController@login');
Route::post('logout', 'Auth\AuthLdapController@logout');
Route::get('logout', 'Auth\AuthLdapController@logout');

Route::get('/home', 'HomeController@index')->name('welcome');
