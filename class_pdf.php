<?php
include 'class_cezpdf.php';
class pdf {
    public $yPos;
    public $xPos;
    Public $pagina_actual=1;
    public $pdf;
    public $ancho_pagina;
    public $imagen_fondo;
    public $orientacion_pagina;
    public $luxeFont = './fonts/Helvetica.afm';
    public $mainFont = './fonts/Times-Roman.afm';
    public $codeFont = './fonts/Courier.afm';
    public $tamano_fuente_normal=8;
    function __construct($orientacion_pagina="vertical", $image_fondo) {
            if ($orientacion_pagina=="horizontal") {
                $this->ancho_pagina=821;
                $this->orientacion_pagina='landscape';
            } else {
                $this->ancho_pagina=574;
                $this->orientacion_pagina='portrait';
            }
            error_reporting(E_ALL);
            set_time_limit(1800);
            $this->pdf = new Cezpdf('a4',$this->orientacion_pagina);
            $this->pdf->selectFont( $this->codeFont );

            $this->pegar_imagen($image_fondo, 10, 10);
   }

   public function pegar_imagen($imagen, $xPos, $yPos) {
            $this->pdf->addjpegfromfile($imagen, $xPos, $yPos, $this->ancho_pagina);
   }

   public function pegar_imagen_especial($imagen, $xPos, $yPos, $w, $h) {
            $this->pdf->addjpegfromfile($imagen, $xPos, $yPos, $w, $h);
   }
   
   public function texto($yPos, $xPos, $tamano_texto, $tamano_font, $texto, $alineacion ) {
        $this->pdf->addTextWrap($this->pdf->ezchageUnit($yPos), $this->pdf->ezchageUnit($xPos), $this->pdf->ezchageUnit($tamano_texto), $tamano_font, $texto, $alineacion);
   }

   public function nueva_pagina() {
        $this->pdf->ezNewPage();
        $this->pagina_actual++;
    }

   public function mostrar() {
        $this->pdf->ezStream();
   }

}
?>
