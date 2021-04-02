<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ResetController extends Controller
{
    public function reset(){
        Artisan::call('migrate:fresh'); //Refresca las migraciones de la bd para limpiarla
        return 'ok'; //Al devolver una cadena, el code response es 200
    }
}
