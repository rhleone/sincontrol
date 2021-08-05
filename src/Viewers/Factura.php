<?php
/**
  * This file is part of consoletvs/invoices.
  *
  * (c) Erik Campobadal <soc@erik.cat>
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

namespace Oness\Sincontrol\Viewers;

use Carbon\Carbon;
use  Oness\Sincontrol\Traits\Setters;
use Illuminate\Support\Collection;
use Oness\Sincontrol\Classes\NumerosLiteral;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Storage;

/**
 * 
 * @author Roger Leon <rhleone@gmail.com>
 */
class Factura
{
    use Setters;

    /**
     * Invoice name.
     *
     * @var string
     */
    public $name;

    /**
     * Factura template.
     *
     * @var string
     */
    public $template;

    /**
     * Invoice item collection.
     *
     * @var Illuminate\Support\Collection
     */
    public $items;

    /**
     * Factura currency.
     *
     * @var string
     */
    public $currency;

    /**
     * Factura number.
     *
     * @var int
     */
    public $number = null;

    /**
     * Factura auth.
     *
     * @var number
     */
    public $auth = null;

    /**
     * Factura code.
     *
     * @var int
     */
    public $code = null;

    /**
     * Factura title.
     *
     * @var string
     */
    public $title = null;

    /**
     * Factura subtitle.
     *
     * @var string
     */
    public $subtitle = null;
    
    /**
     * Factura legend.
     *
     * @var string
     */
    public $legend = null;

    /**
     * Factura activity.
     *
     * @var string
     */
    public $activity = null;

    /**
     * Factura decimal precision.
     *
     * @var int
     */
    public $decimals;

    /**
     * Factura logo.
     *
     * @var string
     */
    public $logo;

    /**
     * Factura Logo Height.
     *
     * @var int
     */
    public $logo_height;

    /**
     * Factura Date.
     *
     * @var Carbon\Carbon
     */
    public $date;

    /**
     * Factura Notes.
     *
     * @var string
     */
    public $notes;

    /**
     * Factura Business Details.
     *
     * @var array
     */
    public $business_details;

    /**
     * Factura Customer Details.
     *
     * @var array
     */
    public $customer_details;

    /**
     * Factura qr Details.
     *
     * @var array
     */
    public $qr_details;
    /**
     * Factura Footnote.
     *
     * @var array
     */
    public $footnote;

    /**
     * Invoice Tax Rates Default.
     *
     * @var array
     */
    public $tax_rates;

    /**
     * Invoice Due Date.
     *
     * @var Carbon\Carbon
     */
    public $due_date = null;

    /**
     * Invoice pagination.
     *
     * @var boolean
     */
    public $with_pagination;

    /**
     * Invoice header duplication.
     *
     * @var boolean
     */
    public $duplicate_header;

    /**
     * Stores the PDF object.
     *
     * @var Dompdf\Dompdf
     */
    private $pdf;

    private $numFormatter;
    /**
     * Create a new invoice instance.
     *
     * @method __construct
     *
     * @param string $name
     */

    public function __construct($name = 'Factura')
    {
        $this->name = $name;
        $this->template = config('sincontrol.invoice_design');
        $this->items = Collection::make([]);
        $this->currency = config('sincontrol.currency');
        $this->decimals = config('sincontrol.decimals');
        $this->logo =  config('sincontrol.logo');
        $this->logo_height = config('sincontrol.logo_height');
        $this->date = Carbon::now();
        $this->business_details = Collection::make(config('sincontrol.business_details'));
        $this->customer_details = Collection::make([]);
        $this->footnote = config('sincontrol.footnote');
        $this->tax_rates = config('sincontrol.tax_rates');
        $this->due_date = config('sincontrol.due_date') != null ? Carbon::parse(config('sincontrol.due_date')) : null;
        $this->with_pagination = config('sincontrol.with_pagination');
        $this->duplicate_header = config('sincontrol.duplicate_header');
        $this->numFormatter =  new NumerosLiteral;
        $this->qr_details =  Collection::make([]); 
    }

    /**
     * Return a new instance of Factura.
     *
     * @method make
     *
     * @param string $name
     *
     * @return Oness\Sincontrol\Classes\Factura
     */
    public static function make($name = 'Factura')
    {
        return new self($name);
    }

    /**
     * Select template for invoice.
     *
     * @method template
     *
     * @param string $template
     *
     * @return self
     */
    public function template($template = 'default')
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Adds an item to the invoice.
     *
     * @method addItem
     *
     * @param string $name
     * @param int    $price
     * @param int    $ammount
     * @param string $id
     * @param string $imageUrl
     *
     * @return self
     */
    public function addItem($name, $price, $ammount = 1, $id = '-', $imageUrl = null)
    {
        $this->items->push(Collection::make([
            'name'       => $name,
            'price'      => $price,
            'price_formatted' => number_format($price, $this->decimals),
            'ammount'    => $ammount,
            'totalPrice' => number_format(bcmul($price, $ammount, $this->decimals), $this->decimals),
            'id'         => $id,
            'imageUrl'   => $imageUrl,
        ]));

        return $this;
    }

    /**
     * Pop the last invoice item.
     *
     * @method popItem
     *
     * @return self
     */
    public function popItem()
    {
        $this->items->pop();

        return $this;
    }

    /**
     * Return the currency object.
     *
     * @method formatCurrency
     *
     * @return stdClass
     */
    public function formatCurrency()
    {
        $currencies = json_decode(file_get_contents(__DIR__.'/../Currencies.json'));
        $currency = $this->currency;

        return $currencies->$currency;
        
    }

    /**
     * Return the subtotal invoice price.
     *
     * @method subTotalPrice
     *
     * @return int
     */
    private function subTotalPrice()
    {
        return $this->items->sum(function ($item) {
            return bcmul($item['price'], $item['ammount'], $this->decimals);
        });
    }

    /**
     * Return formatted sub total price.
     *
     * @method subTotalPriceFormatted
     *
     * @return int
     */
    public function subTotalPriceFormatted()
    {
        return number_format($this->subTotalPrice(), $this->decimals);
    }

    /**
     * Return the total invoce price after aplying the tax.
     *
     * @method totalPrice
     *
     * @return int
     */
    private function totalPrice()
    {
        return bcadd($this->subTotalPrice(), $this->taxPrice(), $this->decimals);
    }

    /**
     * Return formatted total price.
     *
     * @method totalPriceFormatted
     *
     * @return int
     */
    public function totalPriceFormatted()
    {
        return number_format($this->totalPrice(), $this->decimals);
    }

        /**
     * Return formatted total price.
     *
     * @method totalPriceFormatted
     *
     * @return int
     */
    public function totalPriceLiteral()
    {
        return  $this->convertir_numero($this->totalPrice());
    }
    /**
     * taxPrice.
     *
     * @method taxPrice
     *
     * @return float
     */
    private function taxPrice(Object $tax_rate = null)
    {
        if (is_null($tax_rate)) {
            $tax_total = 0;
            foreach($this->tax_rates as $taxe){
                if ($taxe['tax_type'] == 'percentage') {
                    $tax_total += bcdiv(bcmul($taxe['tax'], $this->subTotalPrice(), $this->decimals), 100, $this->decimals);
                    continue;
                }
                $tax_total += $taxe['tax'];
            }
            return $tax_total;
        }
        
        if ($tax_rate->tax_type == 'percentage') {
            return bcdiv(bcmul($tax_rate->tax, $this->subTotalPrice(), $this->decimals), 100, $this->decimals);
        }

        return $tax_rate->tax;
    }

    /**
     * Return formatted tax.
     *
     * @method taxPriceFormatted
     *
     * @return int
     */
    public function taxPriceFormatted($tax_rate)
    {
        return number_format($this->taxPrice($tax_rate), $this->decimals);
    }

    /**
     * Generate the PDF.
     *
     * @method generate
     *
     * @return self
     */
    private function generate()
    {
        $this->pdf = PDF::generate($this, $this->template);

        return $this;
    }

    /**
     * Downloads the generated PDF.
     *
     * @method download
     *
     * @param string $name
     *
     * @return response
     */
    public function download($name = 'invoice')
    {
        $this->generate();

        return $this->pdf->stream($name);
    }

    public function qr(){
        
        if ( count($this->qr_details) > 0){
        $code = $this->qr_details['nit_emisor'].'|'.
                $this->qr_details['numero_factura'].'|'.
                $this->qr_details['numero_autorizacion'].'|'.
                $this->qr_details['fecha_emision'].'|'.
                $this->qr_details['total'].'|'.
                $this->qr_details['importe_base'].'|'.
                $this->qr_details['codigo_control'].'|'.
                $this->qr_details['nit_comprador'].'|'.
                $this->qr_details['importe_tasas'].'|'.
                $this->qr_details['importe_tasascero'].'|'.
                $this->qr_details['importe_nosujeto'].'|'.
                $this->qr_details['importe_descuentos'];
                
        return QrCode::size(100)->generate($code);
        }else{
        return QrCode::generate('error');
       }
    }

    public function logo_base64(){

        $image =$this->logo;
        if ($image !== false){
            return base64_encode( file_get_contents($image));
        
        }else{
            return '';
        }
    }
    
    /**
     * Save the generated PDF.
     *
     * @method save
     *
     * @param string $name
     *
     */
    public function save($name = 'invoice.pdf')
    {
        $invoice = $this->generate();

        Storage::put($name, $invoice->pdf->output());
    }

    /**
     * Show the PDF in the browser.
     *
     * @method show
     *
     * @param string $name
     *
     * @return response
     */
    public function show($name = 'invoice')
    {
        $this->generate();

        return $this->pdf->stream($name, ['Attachment' => false]);
    }

    /**
     * Return true/false if one item contains image.
     * Determine if we should display or not the image column on the invoice.
     * 
     * @method shouldDisplayImageColumn
     *
     * @return boolean
     */
    public function shouldDisplayImageColumn()
    {
        foreach($this->items as $item){
            if($item['imageUrl'] != null){
                return true;
            }
        }
    }

    private function tresnumeros($n, $last) {
		$numeros = array("-", "Uno", "Dos", "Tres", "Cuatro", "Cinco", "Seis", "Siete", "Ocho", "Nueve");
		$numerosX =   array("-", "Un", "Dos", "Tres", "Cuatro", "Cinco", "Seis", "Siete", "Ocho", "Nueve");
		$numeros100 = array("-", "Ciento", "Doscientos", "Trecientos", "Cuatrocientos", "Quinientos", "Seicientos", "Setecientos", "Ochocientos", "Novecientos");
		$numeros11 =  array("-", "Once", "Doce", "Trece", "Catorce", "Quince", "Dieciseis", "Diecisiete", "Dieciocho", "Diecinueve");
		$numeros10 =  array("-", "-", "-", "Treinta", "Cuarenta", "Cincuenta", "Sesenta", "Setenta", "Ochenta", "Noventa");

		if ($n == 100) return "Cien ";
		if ($n == 0) return "Cero ";
		$r = "";
		$cen = floor($n / 100);
		$dec = floor(($n % 100) / 10);
		$uni = $n % 10;
		if ($cen > 0) $r .= $numeros100[$cen] . " ";

		switch ($dec) {
			case 0: $special = 0; break;
			case 1: $special = 10; break;
			case 2: $special = 20; break;
			default: $r .= $numeros10[$dec] . " "; $special = 30; break;
		}
		if ($uni == 0) {
			if ($special==30);
			else if ($special==20) $r .= "Veinte ";
			else if ($special==10) $r .= "Diez ";
			else if ($special==0);
		} else {
			if ($special == 30 && !$last) $r .= "y " . $numerosX[$n%10] . " ";
			else if ($special == 30) $r .= "y " . $numeros[$n%10] . " ";
			else if ($special == 20) {
				if ($uni == 3) $r .= "Veintitres ";
				else if (!$last) $r .= "Veinti" . $numerosX[$n%10] . " ";
				else $r .= "Veinti" . $numeros[$n%10] . " ";
			} else if ($special == 10) $r .= $numeros11[$n%10] . " ";
			else if ($special == 0 && !$last) $r .= $numerosX[$n%10] . " ";
			else if ($special == 0) $r .= $numeros[$n%10] . " ";
		}
		return $r;
	}
	private function seisnumeros($n, $last) {
		if ($n == 0) return "Cero ";
		$miles = floor($n / 1000);
		$units = $n % 1000;
		$r = "";
		if ($miles == 1) $r .= "Mil ";
		else if ($miles > 1) $r .= $this->tresnumeros($miles, false) . "Mil ";
		if ($units > 0) $r .= $this->tresnumeros($units, $last);
		return $r;
	}
	private function docenumeros($n) {
		if ($n == 0) return "Cero ";
		$millo = floor($n / 1000000);
		$units = $n % 1000000;
		$r = "";
		if ($millo == 1) $r .= "Un Millon ";
		else if ($millo > 1) $r .= $this->seisnumeros($millo, false) . "Millones ";
		if ($units > 0) $r .= $this->seisnumeros($units, true);
		return $r;
	}
	private function convertir_numero($numero)
	{
		$literal=$this->docenumeros($numero);
        //$literal=$this->numFormatter->toWords($numero);
		
        $numero1=floor($numero);
		 
		$centavos=$numero-$numero1;
		if($centavos==0)
		$centavos1="00";
		else
		$centavos1=round($centavos*100);

		$cadena= $literal." $centavos1/100";
		return $cadena;
	}
}