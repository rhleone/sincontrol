<?php 

namespace Oness\Sincontrol\Facades;

use Illuminate\Support\Facades\Facade;

class GeneradorCodigoControl extends Facade{

    protected static function getFacadeAccessor(){

        return 'codigocontrol';
    }
}