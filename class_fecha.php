<?php

class fecha {
        public $fecha;
        public $periodo;
        public $anio;


        public function hoy() {
                return date("Y-m-d");
                }

        public function DateAdd($v,$d=null , $f="Y/m/d"){
               // echo DateAdd(2);  // 2 days after
               // echo DateAdd(-2,0,"Y-m-d");  // 2 days before with gigen format
               // echo DateAdd(3,"01/01/2000");  // 3 days after given date
               $d=($d?$d:date("Y-m-d"));
               return date($f,strtotime($v." days",strtotime($d)));
        }

        public function que_dia($d){
               return date("d",strtotime($d));

        }

        public function que_mes($d){
               return date("m",strtotime($d));

        }


        public function que_anio($d){
               return date("Y",strtotime($d));
        }

        public function format ($fecha){
              $anio = substr($fecha,0,4);
              $mes = substr($fecha,5,2);
              $dia = substr($fecha,8,2);
			  $fecha_formateada = $dia . "/" . $mes . "/" . $anio;
              return $fecha_formateada ;
        }

        public function format_mysql ($fecha){
              $mes = substr($fecha,0,2);
              $dia = substr($fecha,3,2);
              $anio = substr($fecha,6,4);
              $fecha_formateada = $anio. "/" . $mes . "/" . $dia ;
              return $fecha_formateada ;
        }
        
        
        public function dia_semana ($fecha){
                $dias_semana = array(0 => "Domingo", 1 => "Lunes", 2 => "Martes", 3 => "Miercoles", 4 => "Jueves", 5 => "Viernes", 6 => "Sabado");
                $fecha=strtotime($fecha);
				$dia = intval(date("w", $fecha));
              	return $dias_semana[$dia];
		}
        
        
        // Calcula la edad (formato: año/mes/dia)
        public function edad($edad){
                list($anio,$mes,$dia) = explode("-",$edad);
                $anio_dif = date("Y") - $anio;
                $mes_dif = date("m") - $mes;
                $dia_dif = date("d") - $dia;
                if ($dia_dif < 0 || $mes_dif < 0)
                $anio_dif--;
                return $anio_dif;
        }


}

?>
