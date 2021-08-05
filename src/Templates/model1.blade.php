<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{{ $invoice->name }}</title>
        <style>
            * {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                margin: 1px;
            }
            h1,h2,h3,h4,h5,h6,p,span,div { 
                font-family: DejaVu Sans; 
                font-size:9px;
                font-weight: normal;
            }
            .title{
                font-size:15px;
                font-weight: bold;
                text-align: center;
            }
            .subtitle{
                text-align: center;
                font-weight: bold;
            }
            th,td { 
                font-family: DejaVu Sans; 
                font-size:9px;
            }
            .panel {
                margin-bottom: 2px;
                background-color: #fff;
                border: 0px solid transparent;
                border-radius: 0px;
                -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
                box-shadow: 0 1px 1px rgba(0,0,0,.05);
            }
            .panel-default {
                border-color: #ddd;
            }
            .panel-body {
                padding: 5px;
            }
            table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 0px;
                border-spacing: 0;
                border-collapse: collapse;
                background-color: transparent;
            }
            thead  {
                text-align: left;
                display: table-header-group;
                vertical-align: middle;
            }
            th, td  {
                border: 1px solid #ddd;
                padding: 6px;
            }
            .well {
                min-height: 20px;
                padding: 15px;
                margin-bottom: 16px;
                background-color: #f5f5f5;
                border: 1px solid #e3e3e3;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
            }
            .text-center{
                text-align: center;
            }
            footer {
                position: absolute;
                bottom: 0;
                width: 100%;
                height: 70pt;   
            }
        </style>
        @if($invoice->duplicate_header)
            <style>
                @page { margin-top: 140px;}
                header {
                    top: -100px;
                    position: fixed;
                }
            </style>
        @endif
    </head>
    <body>
        <header>
        <div style="position:absolute; left:0pt; z-index: -1; width:100%;">
            <div style="position:absolute; top:0pt; left:0pt;">
               <img class="img-rounded"  height="{{ $invoice->logo_height }}" src="data:image/png;base64,{{$invoice->logo}}" alt="Logo"  >
            </div>
            <div style="position:absolute; top:0pt; left:0pt; width:176pt;margin-left: 105pt;">
            
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            {!! $invoice->business_details->count() == 0 ? '<i>No business details</i><br />' : '' !!}
                            {{ $invoice->business_details->get('name') }}<br />
                            {{ $invoice->business_details->get('location') }}<br />
                            Tel&eacute;fonos:{{ $invoice->business_details->get('phone') }}<br />
                            {{ $invoice->business_details->get('city') }},{{ $invoice->business_details->get('country') }}<br />
                            CASA MATRIZ
                        </div>
                    </div>
                   
                </div>
                
            </div>
            <div style="margin-left:280pt;">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {!! $invoice->business_details->count() == 0 ? '<i>No business details</i><br />' : '' !!}
                            NIT: {{ $invoice->business_details->get('id') }}<br />
                            {{ $invoice->title }}<br />
                            N&deg;:@if ($invoice->number) {{ $invoice->number }} @endif<br />
                            N&deg; AUTORIZACI&Oacute;N:<br />
                            @if ($invoice->auth) {{ $invoice->auth }} @endif<br />
                            
                        </div>
                        <p class="text-center">
                         <b class="">ORIGINAL</b> <br />
                         {{ $invoice->activity }}
                        </p>
                    </div>
                    
            </div>
          
        </header>
        <main>
            <div style="clear:both; position:relative;">
                <div >
                <h4 class="title">{{ $invoice->title }}</h4>
                <h3 class="subtitle">{{ $invoice->subtitle }}</h3>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {!! $invoice->customer_details->count() == 0 ? '<i>No customer details</i><br />' : '' !!}
                            <b>{{ $invoice->business_details->get('city') }}: </b>  {{ $invoice->date->formatLocalized(' %d de %B de %Y') }} 
                            <b>NIT/CI:</b> {{ $invoice->customer_details->get('id') }}<br />
                            <b>Se&ntilde;or(es):</b>{{ $invoice->customer_details->get('name') }}
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr style="background-color: #7393B3;">
                        <th style="width:10%">ITEM</th>
                        <th style="width:75%">CONCEPTO</th>
                        <th style="width:20%">IMPORTE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->get('name') }}</td>
                            <td>{{ $item->get('totalPrice') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                 <tr>
                    <td colspan="2" style="text-align: right;"><b>Total:</b></td>
                    <td>{{ $invoice->totalPriceFormatted() }}</td>
                  </tr>
                  <tr>
                    <td colspan="3">Son: {{ $invoice->totalPriceLiteral() }} {{ $invoice->formatCurrency()->name_plural }}</td>
                  </tr>
                </tfoot>
            </table>
            <div style="clear:both; position:relative;">
    
                    <div >
                        <div class="panel panel-default" style="border: none;">
                            <div class="panel-body" >
                               C&oacute;digo de Control: {{ $invoice->code }}<br/>
                               Fecha L&iacute;mite de Emisi&oacute;n: {{ $invoice->due_date->format('d/m/Y') }}<br/>
                               MANTENGA SUS PAGOS  POR ADELANTADO EVITE MULTAS POR RECONEXION
                               <div style="position:absolute; top:10px;left:305pt">
                               <img src="data:image/png;base64, {!! base64_encode($invoice->qr())!!}" />
                               </div>
                               
                            </div>
                        </div>
                    </div>
          
               
            </div>
            <div style="clear:both; position:relative;">
                @if($invoice->notes)
                    <div style="position:absolute; left:0pt; width:250pt;">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                {{ $invoice->notes }}
                            </div>
                        </div>
                    </div>
                @endif
               
            </div>
            @if ($invoice->footnote)
                
                <div class="well text-center" style="width: 280pt;">
                    {{ $invoice->footnote }}
                    <p style="font-size:8px;"><i>{{ $invoice->legend }}</i></p>
                </div>
            @endif
        </main>
        <!-- Page count -->
        <script type="text/php">
            if (isset($pdf) && $GLOBALS['with_pagination'] && $PAGE_COUNT > 1) {
                $pageText = "{PAGE_NUM} de {PAGE_COUNT}";
                $pdf->page_text(($pdf->get_width()/2) - (strlen($pageText) / 2), $pdf->get_height()-20, $pageText, $fontMetrics->get_font("DejaVu Sans, Arial, Helvetica, sans-serif", "normal"), 7, array(0,0,0));
            }
        </script>
        <footer>
            <div style="position:absolute; left:0pt; width:250pt;">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <b>RAZON SOCIAL:</b>{{ $invoice->customer_details->get('name') }}<br />
                                <b>NIT/CI:</b>{{ $invoice->customer_details->get('id') }}<br />
                                <b>CODIGO CLIENTE:</b> <br/>
                                <b>TOTAL PAGADO:</b>{{ $invoice->totalPriceFormatted() }}<br />
                                <b>FECHA PAGO:</b> {{ $invoice->date->format('d/m/Y')}}

                            </div>
                       </div>
            </div>
            <div style="position:absolute; left:0pt; width:250pt;margin-left: 200pt;">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <b>NIT:</b>{{ $invoice->business_details->get('id') }}<br />
                                <b>NRO FACTURA:</b>{{ $invoice->number }}<br />
                                <b>NRO AUTORIZACION:</b>{{ $invoice->auth }}<br />
                            </div>
                       </div>
            </div>
        </footer>
    </body>
</html>