<?php
namespace Oness\Sincontrol\Viewers;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;

/**
 * This is the PDF class.
 *
 * @author Roger León <rhleone@gmail.com>
 */
class PDF
{
    /**
     * Generate the PDF.
     *
     * @method generate
     *
     * @param Oness\Sincontrol\Viewer\Factura $Factura
     * @param string                              $template
     *
     * @return Dompdf\Dompdf
     */
    public static function generate(Factura $Factura, $template = 'default')
    {
        $template = strtolower($template);

        $options = new Options();

        $options->setIsRemoteEnabled(true);
        $options->setIsPhpEnabled(true);
        
        if ($Factura->template == "model1") 
          $options->setDefaultPaperSize('half-letter');
        
        $pdf = new Dompdf($options);

        $context = stream_context_create([
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
                'allow_self_signed'=> true,
            ],
        ]);

        $pdf->setHttpContext($context);

        $GLOBALS['with_pagination'] = $Factura->with_pagination;

        $pdf->loadHtml(View::make('sincontrol::'.$template, ['invoice' => $Factura]));
        $pdf->render();

        return $pdf;
    }
}