<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function store(Request $request){
       if($request->input('type')==='deposit'){
                return $this->deposit(
                  $request->input('destination'),
                  $request->input('amount')
                );
        }else if($request->input('type')==='withdraw'){
                return $this->withdraw(
                    $request->input('origin'),
                    $request->input('amount')
                );
        }else if($request->input('type')==='transfer'){
            return $this->transfer(
                $request->input('origin'),
                $request->input('destination'),
                $request->input('amount')
            );
        }
    }

    private function deposit($destionation,$amount){
            $account=Account::firstOrCreate([//Si no lo encuentra, crea un registro (cuenta) nuevo
                'id'=>$destionation
            ]);
            $account->balance+=$amount;
            $account->save();
            return response()->json(['destination'=>
                [
                'id'=>$account->id,
                'balance'=>$account->balance,
                ]
            ],201);
    }
    private function withdraw($origin,$amount){
        $account = Account::findOrFail($origin); //404 si no existe
        $account->balance-= $amount;
        $account->save();
        return response()->json(['origin'=>
            [
                'id'=>$account->id,
                'balance'=>$account->balance,
            ]
        ],201);
    }

    private function transfer($origin,$destination,$amount){
        $accountOrigin = Account::findOrFail($origin); //404 si no existe
        $accountDestination = Account::firstOrCreate([
            'id'=>$destination
        ]); //La crea si no existe
        DB::transaction(function() use ($accountOrigin, $accountDestination,$amount){ //para evitar inconsistencias usamos transacciones
            $accountOrigin->balance-= $amount;
            $accountDestination->balance+= $amount;
            $accountOrigin->save();
            $accountDestination->save();
        });
        return response()->json([
            'origin'=>
            [
                'id'=>$accountOrigin->id,
                'balance'=>$accountOrigin->balance,
            ],
            'destination'=>
            [
                    'id'=>$accountDestination->id,
                    'balance'=>$accountDestination->balance,
            ]
        ],201);
    }
}
