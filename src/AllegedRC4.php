<?php
namespace Oness\Sincontrol;

class AllegedRC4 {

    /**
     *  return Stream cipher CR4
     */
    public function rc4($msg, $key, $mode='hex')
	{
		$state = array();
		for ($i=0; $i<256; $i++) $state[] = $i;
		$x = $y = $i1 = $i2 = 0;
		$key_length = strlen($key);
		for ($i=0; $i<256; $i++)
		{
			$i2 = (ord($key[$i1])+$state[$i]+$i2) % 256;
			$this->swap($state[$i], $state[$i2]);
			$i1 = ($i1+1) % $key_length;
		}
		$msg_length = strlen($msg);
		$msg_hex = '';
		for ($i=0; $i<$msg_length; $i++)
		{
			$x = ($x + 1) % 256;
			$y = ($state[$x] + $y) % 256;
			$this->swap($state[$x], $state[$y]);
			$xi = ($state[$x] + $state[$y]) % 256;
			$r = ord($msg[$i]) ^ $state[$xi];
			$msg[$i] = chr($r);
			$msg_hex .= sprintf("%02X",$r);
		}
		return ($mode=='hex'?$msg_hex:$msg);
	}
	private function swap(&$x, &$y)
	{
		$z = $x; $x = $y; $y = $z;
	}

}