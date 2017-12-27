<?php
include 'class_cezpdf.php';

class reporte {

    public $yPos;
    public $xPos;
    public $pagina_actual=1;
    public $pagina_total;
    public $pdf;

    public $ancho_pagina;
    public $imagen_fondo;
    public $orientacion_pagina;
    public $luxeFont = './fonts/Helvetica.afm';
    public $mainFont = './fonts/Times-Roman.afm';
    public $codeFont = './fonts/Courier.afm';
    public $titulo1;
    public $titulo2;
    public $titulo3;
    public $tamano_fuente_titulo1=14;
    public $tamano_fuente_titulo2=8;
    public $tamano_fuente_titulo3=8;
    public $tamano_fuente_normal=8;
    public $tamano_fuente_reducido=5;
    public $tamano_fuente_encabezado=0;

    public $col_xPos;
    public $col_alineacion;
    public $col_tamanos;
    public $col_nombres_columnas;
    public $renglon;

    public $yInc=0.4;
    public $yPos_final=2;
    public $yPos_inicio;

    public $renglones_para_final;

    function __construct($orientacion_pagina="vertical", $titulo1="",$titulo2="", $titulo3="") {

            if ($orientacion_pagina=="horizontal") {
                $this->ancho_pagina=821;
                $this->imagen_fondo="listado_molde_horizontal.jpg";
                $this->orientacion_pagina='landscape';
                $this->xPos_nombre_columnas=17.8;
                $this->yPos_inicio=17;
                $this->yPos_titular=7.5;
                $this->xPos_titular=19.5;
                $this->yPos_pagina=20;
                $this->xPos_pagina=20;
            } else {
                $this->ancho_pagina=574;
                $this->imagen_fondo="listado_molde_vertical.jpg";
                $this->orientacion_pagina='portrait';
                $this->xPos_nombre_columnas=27;
                $this->yPos_inicio=26.5;
                $this->yPos_titular=6.5;
                $this->xPos_titular=28.4;
                $this->yPos_pagina=12;
                $this->xPos_pagina=29.2;

            }
            $this->titulo1=$titulo1;
            $this->titulo2=$titulo2;
            $this->titulo3=$titulo3;
            error_reporting(E_ALL);
            set_time_limit(1800);
            $this->pdf = new Cezpdf('a4',$this->orientacion_pagina);
   }

   public function inicializar() {
            $a = count($this->col_xPos);
            $b = count($this->col_tamanos);
            $c = count($this->col_nombres_columnas);
            $d = count($this->col_alineacion);

            if ($a<>$b or $a<>$c or $a<>$d) {
                print "ERROR para el programador: los arrays de encabezado y<br>columnas no tienen la misma cantidad de elementos<br>";
                die;
            }
            $this->pdf->selectFont( $this->codeFont );
            $this->pdf->addjpegfromfile($this->imagen_fondo,10, 10, $this->ancho_pagina);
            $this->texto($this->yPos_titular, $this->xPos_titular, 30, $this->tamano_fuente_titulo1,  $this->titulo1, 'left');
            $this->texto($this->yPos_titular, $this->xPos_titular - 0.4, 30, $this->tamano_fuente_titulo2,  $this->titulo2, 'left');
            $this->texto($this->yPos_titular, $this->xPos_titular - 0.8, 100, $this->tamano_fuente_titulo3,  $this->titulo3, 'left');
            $this->texto($this->yPos_pagina, $this->xPos_pagina, 6, $this->tamano_fuente_normal,  "Pagina: " . $this->pagina_actual, 'right');
            $this->texto($this->yPos_pagina, $this->xPos_pagina - 0.3, 6, $this->tamano_fuente_normal,  "Fecha y Hora: " . date('d/m/Y H:m:s') , 'right');
            $this->imprimir_encabezado($this->tamano_fuente_encabezado);
            $this->yPos=$this->yPos_inicio;
   }


   public function texto($yPos, $xPos, $tamano_texto, $tamano_texto, $texto, $alineacion ) {
        $this->pdf->addTextWrap($this->pdf->ezchageUnit($yPos), $this->pdf->ezchageUnit($xPos), $this->pdf->ezchageUnit($tamano_texto), $tamano_texto, $texto, $alineacion);
   }


   public function imprimir_encabezado($tamano_texto=0) {
   			if ($tamano_texto==0) {
   				$tamano_texto=$this->tamano_fuente_normal;
   			}	
        $total_columna = count($this->col_xPos);
        for($i=0; $i < $total_columna; $i++)
        {
            $this->texto($this->col_xPos[$i], $this->xPos_nombre_columnas, 50, $tamano_texto,  $this->col_nombres_columnas[$i], $this->col_alineacion[$i]);
        }
    }

   public function imprimir_renglon($tamano_texto=0, $Inc=0) {
        if ($tamano_texto==0) {
           $tamano_texto=$this->tamano_fuente_normal;
        }
        if ($Inc==0) {
           $Inc=$this->yInc;;
        }
        
        $total_columna = count($this->renglon);
        if ($this->yPos < $this->yPos_final) {
            $this->yPos=$this->yPos_inicio;
            $this->nueva_pagina();
        }
        for($i=0; $i < $total_columna; $i++)
        {
            $this->texto($this->col_xPos[$i], $this->yPos, $this->col_tamanos[$i], $tamano_texto,  $this->renglon[$i], $this->col_alineacion[$i]);
        }
        $this->yPos=$this->yPos - $Inc;

        $aritmetica = new aritmetica();
        $this->renglones_para_final = $aritmetica->round_out((($this->yPos - $this->yPos_final) / $this->yInc),0);
   }

   public function nueva_pagina() {
        $this->pdf->ezNewPage();
        $this->pagina_actual++;
        $this->inicializar();
    }


   public function mostrar() {
        $this->pdf->ezStream();
   }


}
?>
