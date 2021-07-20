<?php 

namespace Oness\Sincontrol\Facades;

use Illuminate\Support\Facades\Facade;

class FacturaViewer extends Facade{

    protected static function getFacadeAccessor(){

        return 'factura-viewer';
    }
}