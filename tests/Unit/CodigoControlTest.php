<?php

use Oness\Sincontrol\Generador;
use Oness\Sincontrol\tests\TestCase;

class CodigoControlTest extends TestCase{

    public function test_basic_test()
    {
        $g = new Generador;
        //$this->assertTrue($g->generar(1904008691195,978256,0,20080201,26006,'pPgiFS%)v}@N4W3aQqqXCEHVS2[aDw_n%3)pFyU%bEB9)YXt%xNBub4@PZ4S9)ct') =='62-12-AF-1B');

        try{
            $filename=__DIR__ . "/5000CasosPruebaCCVer7.txt";
            $this->assertFileExists($filename);
            $handle = fopen($filename, "r");
            
            if ($handle) {        
                $count=0;
                $countError=0;        
                while (($line = fgets($handle)) !== false) {        
                    $reg = explode("|", $line);        
                    //genera codigo de control
                    $code = $g->generar($reg[0],//Numero de autorizacion
                                                   $reg[1],//Numero de factura
                                                   $reg[2],//Número de Identificación Tributaria o Carnet de Identidad
                                                   str_replace('/','',$reg[3]),//fecha de transaccion de la forma AAAAMMDD
                                                   $reg[4],//Monto de la transacción
                                                   $reg[5]//Llave de dosificación
                            );

                    $this->assertEquals($code,$reg[10]);        
                    if($code===$reg[10]){                
                        $count+=1;
                    }
                }        
               
            fclose($handle);
            $this->assertTrue($count == 5000);
            
            }else{
                $this->assertTrue(false,'El archivo no se puede abrir');
            }
        }catch ( Exception $e ){
 
            $this->assertTrue(false,'El archivo de casos de prueba no existe');
        }
    }

}