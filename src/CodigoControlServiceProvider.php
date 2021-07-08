<?php
namespace Oness\Sincontrol;

use Illuminate\Support\ServiceProvider;

class CodigoControlServiceProvider extends ServiceProvider{
 
  public function register()
  {
    //
    $this->app->bind('codigocontrol',function ($app){
        return new Generador;
    });
  }

  public function boot()
  {
    //
  }
}
