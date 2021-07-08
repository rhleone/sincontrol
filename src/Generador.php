<?php 

namespace Oness\Sincontrol;

class Generador{

	private static $rcImp;

	private static $verhoeffImp;

	public function __construct(){
		
		self::$rcImp = new AllegedRC4;
		self::$verhoeffImp = new Verhoeff;
		
	}
   
    
    function generar($numautorizacion, $numfactura, $nitcliente, $fecha, $monto, $clave)
	{
		$numfactura = $this->appendVerhoeff($numfactura, 2);
		$nitcliente = $this->appendVerhoeff($nitcliente, 2);
		$fecha = $this->appendVerhoeff($fecha, 2);
		$monto = $this->appendVerhoeff($this->roundUp($monto), 2);
		$suma = $numfactura + $nitcliente + $fecha + $monto;
		$suma = $this->appendVerhoeff($suma, 5);
		$dv = substr($suma, -5);
		$cads = array($numautorizacion, $numfactura, $nitcliente, $fecha, $monto);
		$msg = '';
		$p = 0;
		for ($i=0; $i<5; $i++)
		{
			$msg .= $cads[$i] . substr($clave, $p, 1+$dv[$i]);
			$p += 1 + $dv[$i];
		}
		$codif = self::$rcImp->rc4($msg, $clave.$dv);
		$st = 0;
		$sp = array(0,0,0,0,0);
		$codif_length = strlen($codif);
		for ($i=0; $i<$codif_length; $i++)
		{
			$st += ord($codif[$i]);
			$sp[$i%5] += ord($codif[$i]);
		}
		$stt = 0;
		for ($i=0; $i<5; $i++)
			$stt += (int)(($st * $sp[$i]) / (1 + $dv[$i]));

            return implode('-',str_split(self::$rcImp->rc4($this->base64($stt),$clave.$dv), 2));
	}

	private function base64($n)
	{
		$d = array(
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 
			'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 
			'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 
			'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 
			'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 
			'y', 'z', '+', '/' );
		$c = 1; $r = '';
		while ($c > 0)
		{
			$c = (int)($n / 64);
			$r = $d[$n%64] . $r;
			$n = $c;
		}
		return $r;
	}
	private function appendVerhoeff($n, $c)
	{
		for (;$c>0; $c--) $n .= self::$verhoeffImp->CheckSumDigit($n);
		return $n;
	}
    /**
     * Redondea hacia arriba
     * @param value cadena con valor numerico de la forma 123 123.4 123,4
     */
    function roundUp($value){        
        //reemplaza (,) por (.)        
        $value2 = str_replace(',','.',$value);
        //redondea a 0 decimales        
        return round($value2, 0, PHP_ROUND_HALF_UP);
    }


}

new Generador();