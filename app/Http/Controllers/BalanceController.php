<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    //localhost/laravel-api-rest/public/api/balance?account_id=100
    public function show(Request $request){
        $accountId=$request->input('account_id');
        $account=Account::findOrFail($accountId);

        return $account->balance;
    }
}
