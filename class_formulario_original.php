<?php

class formulario {

      // public variables
      private $db;
      public $css_tabla_fondo;
      public $css_tabla_items;

      

      function __construct() {
            $this->db  = new db();
      }

      public function abrir($titulo, $size=920, $target="misma") {
          print "<div class='fondo_formulario_div'>";          
           // print "<script src='/jquery-1.4.2.min.js' type='text/javascript' charset='utf-8'></script>";
          // print "<script src='/jquery.uniform.min.js' type='text/javascript' charset='utf-8'></script>";
          print "<link type='text/css' href='/css/ui-lightness/jquery-ui-1.8.4.custom.css' rel='stylesheet' />";
          // print "<script type='text/javascript' src='/js/jquery-ui-1.8.4.custom.min.js'></script>";
          /*
          print "<script type='text/javascript' charset='utf-8'>";
          print "$(function(){";
          print "$('input, textarea, select, button').uniform();";
          print "});";
          print "</script>";
          */
          print "<link rel='stylesheet' href='/uniform.default.css' type='text/css' media='screen'>";
          print "<style type='text/css' media='screen'>";
          print "body {";
          print "font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;";
          print "color: #666;";
          // print "padding: 40px;";
          print "}";
          print "h1 {";
          print "margin-top: 0;";
          print "}";
          print "ul {";
          print "list-style: none;";
          print "padding: 0;";
          print "margin: 0;";
          print "}";
          print "li {";
          print "margin-bottom: 20px;";
          print "clear: both;";
          print "}";
          print "label {";
          print "font-size: 10px;";
          print "font-weight: bold;";
          print "text-transform: uppercase;";
          print "display: block;";
          print "margin-bottom: 3px;";
          print "clear: both;";
          print "}";
          print "</style>";
          
          print "<h1>" . $titulo . "</h1><br>";
          print "<form name='form' method='post' action='" . $_SERVER["PHP_SELF"] . "' ";
          if ($target=="nueva") {
            print " target='_blank' class='niceform'";
          }
          print " enctype='multipart/form-data' class='niceform'>\n";
          print "<ul>";
      }
      
      public function encabezado($titulo){
          print "<h1>" . $titulo . "</h1><br>";
      }

      public function text_box($leyenda,$variable,$tamanio,$tamanio_maximo,$defecto,$ayuda) {
          print "<li>";
          print "<label for='$variable'>" . $leyenda . "</label>";
          print "<input type='text' name='" . $variable . "' id='" . $variable . "' size='" . $tamanio . "' maxlength='" . $tamanio_maximo . "' value='" . $defecto . "'> " . $ayuda;
          print "</li>";
          
      }

      public function clave_box($leyenda,$variable,$tamanio,$tamanio_maximo,$defecto,$ayuda) {
        print "<li>";
        print "<label for='password'>" . $leyenda . "</label>";
        print "<input type='password' name='" . $variable . "' id='" . $variable . "' size='" . $tamanio . "' maxlength='" . $tamanio_maximo . "' value='" . $defecto . "' /> " . $ayuda;
        print "</li>";              
      }
      
      
      public function text_area_box($leyenda,$variable,$lineas,$columnas,$defecto,$ayuda) {
        print "<li>";
        print "<label for='comments'>" . $leyenda . "</label>";
        print "<textarea name='" . $variable . "' id='" . $variable . "' rows='" . $lineas . "' cols='" . $columnas . "'>" . $defecto . "</textarea>";
        print "</li>";
      }
      

      public function text_view($leyenda,$variable,$ayuda) {
          print "<li>";
          print "<label for='$variable'>" . $leyenda . "</label>";
          print $variable . $ayuda;
          print "</li>";
      }

      public function check_box($leyenda, $variable, $value, $ayuda) {
            print "<li>";
            print "<label for='interests'>" . $leyenda . "</label>";
            print "<input type='checkbox' name='" . $variable . "' id='" . $variable . "' value='" . $variable . "' checked='checked' /><label for='interestsNews' class='opt'></label>";
            print "</li>";
          
      }

      public function text_oculto($variable,$valor) {
              print "<input name='";
              print $variable;
              print "' type='hidden' id='";
              print $variable;
              print "' value='";
              print $valor;
              print "'>\n";
      }

      public function text_oculto_fecha($variable,$fecha) {
              print "<input name='";
              print $variable . "_anio";
              print "' type='hidden' id='";
              print $variable . "_anio";
              print "' value='";
              print substr($fecha,0,4);
              print "'>\n";
              print "<input name='";
              print $variable . "_mes";
              print "' type='hidden' id='";
              print $variable . "_mes";
              print "' value='";
              print substr($fecha,5,2);
              print "'>\n";
              print "<input name='";
              print $variable . "_dia";
              print "' type='hidden' id='";
              print $variable . "_dia";
              print "' value='";
              print substr($fecha,8,2);
              print "'>\n";
      }


      public function date_box2($leyenda, $variable, $fecha_defecto,$ayuda) {
        print "<li>";
        print "<label for='" . $variable . "'>" . $leyenda . "</label>";
        print "<meta charset='UTF-8'/>";
        /*
        print "<script type='text/javascript'>";
        print "$(function() {";
        print "$('#datepicker').datepicker({";
        print "changeMonth: true,";
        print "changeYear: true,";
        print "minDate: '-100Y',";
        print "maxDate: '-18Y'";
        print "});";
        print "});";
        print "</script>";
        */
        print "<div class='demo'>";
        print "<p>Date: <input type='text' name='" . $variable . "' id='datepicker' value='" . $fecha_defecto . "'>";
        print " " . $ayuda . "</p>";
        print "</div><!-- End demo -->";
        print "</li>";
      }



      public function date_box($leyenda, $variable, $fecha_defecto) {
          
        $fecha_anio=intval(substr($fecha_defecto,0,4));
        $fecha_mes=intval(substr($fecha_defecto,5,2));
        $fecha_dia=intval(substr($fecha_defecto,8,2));
        
        if ($fecha_anio==""){
            $fecha_actual=getdate();
            $fecha_anio=$fecha_actual[year];
            $fecha_mes=$fecha_actual[mon];
            $fecha_dia=$fecha_actual[mday];
        }
        
        print "<li>";
        print "<label for='" . $variable . "'>" . $leyenda . "</label>";
        
        print "<select name='" . $variable . "_dia' id='" . $variable . "_dia'>";
        for ($i=1; $i<32; $i++){
             print "<option value='";
             if ($i<10) { $o="0".$i; } else { $o=$i; }
             print "$o'";
             if (intval($o)==$fecha_dia){
                print " selected ";
             }
             print ">$o</option>\n";
        }
        print "</select> ";

        print "<select name='" . $variable . "_mes' id='" . $variable . "_mes'>";
        for ($i=1; $i<13; $i++){
             print "<option value='";
             if ($i<10) { $o="0".$i; } else { $o=$i; }
             print "$o' ";
             if ($o==$fecha_mes){
                print " selected ";
             }
             print ">$o</option>\n";
        }
        print "</select> ";
        
        print "<select name='" . $variable . "_anio' id='" . $variable . "_anio'>";
        for ($i=2013; $i>1900; $i--){
             print "<option value='$i'";
             if ($i==$fecha_anio){
                print " selected ";
             }
             print ">$i</option>\n";
        }
        print "</select>";
        print "</li>";
      }

      
      public function date_box_limpio($leyenda, $variable, $fecha_defecto) {
          
      $fecha_anio=intval(substr($fecha_defecto,0,4));
      $fecha_mes=intval(substr($fecha_defecto,5,2));
      $fecha_dia=intval(substr($fecha_defecto,8,2));
        if ($fecha_anio==""){
            $fecha_actual=getdate();
            $fecha_anio=$fecha_actual[year];
            $fecha_mes=$fecha_actual[mon];
            $fecha_dia=$fecha_actual[mday];
        }
        print $leyenda . ": ";
        print "<select name='" . $variable . "_dia' id='" . $variable . "_dia'>";
        for ($i=1; $i<32; $i++){
             print "<option value='";
             if ($i<10) { $o="0".$i; } else { $o=$i; }
             print "$o'";
             if (intval($o)==$fecha_dia){
                print " selected ";
             }
             print ">$o</option>\n";
        }
        print "</select> ";
        print "<select name='" . $variable . "_mes' id='" . $variable . "_mes'>";
        for ($i=1; $i<13; $i++){
             print "<option value='";
             if ($i<10) { $o="0".$i; } else { $o=$i; }
             print "$o' ";
             if ($o==$fecha_mes){
                print " selected ";
             }
             print ">$o</option>\n";
        }
        print "</select> ";
        print "<select name='" . $variable . "_anio' id='" . $variable . "_anio'>";
        for ($i=2011; $i>1900; $i--){
             print "<option value='$i'";
             if ($i==$fecha_anio){
                print " selected ";
             }
             print ">$i</option>\n";
        }
        print "</select>";
      }
      
      
      
      
      
      public function combo_box($leyenda, $variable, $tabla, $campo_ver, $campo_valor, $valor_defecto, $todos=0, $filtro="") {
        print "<li>";
        print "<label for='" . $variable . "'>" . $leyenda . "</label>";
        print "<select size='0' name='" . $variable . "' id='" . $variable . "'>";
        $this->db->sql  = "select $campo_ver, $campo_valor from $tabla ";
        if ($filtro<>"") {
        	$this->db->sql .= " where " . $filtro;
        }
		$this->db->sql .= " order by $campo_ver";

        if(!$this->db->query_db()) {

                   print "<option value=''";
                   print " selected>No hay datos cargados</option>\n";
            print "</select>";
            
        } else {
            if ($todos==1) {
                   print "<option value=''";
                   print " selected></option>\n";
            }
            do {
                   print "<option value='" . $this->db->campo($campo_valor) . "'";
                   if ($valor_defecto==$this->db->campo($campo_valor)) {
                       print "selected";
                   }
                   print ">" . $this->db->campo($campo_ver) . "</option>\n";
            } while ($this->db->reg_siguiente());
            print "</select>";
        }
        print "</li>";
      }



      public function combo_box_limpio($leyenda, $variable, $tabla, $campo_ver, $campo_valor, $valor_defecto, $todos=0, $filtro="") {
        print $leyenda . ": ";
        print "<select size='0' name='" . $variable . "' id='" . $variable . "'>";
        $this->db->sql  = "select $campo_ver, $campo_valor from $tabla ";
        if ($filtro<>"") {
            $this->db->sql .= " where " . $filtro;
        }
        $this->db->sql .= " order by $campo_ver";

        $this->db->query_db();
        if ($todos==1) {
               print "<option value=''";
               print "></option>\n";
        }
        do {
               print "<option value='" . $this->db->campo($campo_valor) . "'";
               if ($valor_defecto==$this->db->campo($campo_valor)) {
                   print "selected";
               }
               print ">" . $this->db->campo($campo_ver) . "</option>\n";
        } while ($this->db->reg_siguiente());
        print "</select>";
      }
      

      public function combo_box_select($leyenda, $variable, $tabla, $campo_ver, $campo_valor, $valor_defecto, $campo_filtro, $valor_filtro) {
        print "<li>";
        print "<label for='" . $variable . "'>" . $leyenda . "</label>";
        print "<select  size='0' name='"  . $variable . "' id='" . $variable . "'>\n";
        $sql_string="select $campo_ver, $campo_valor from $tabla ";
        $sql_string.="where ". $campo_filtro . "=". $valor_filtro . " ";
        $sql_string.="order by $campo_ver";

        $this->db->sql=$sql_string;
        $this->db->query_db();

        if ($tabla=="comercios_rubros") {
               print "<option value=' '";
                   //print "selected";
               print "> </option>\n";

        }
        do {
               print "<option value='" . $this->db->campo($campo_valor) . "'";
               if ($valor_defecto==$this->db->campo($campo_valor)) {
                   print "selected";
               }
               print ">" . $this->db->campo($campo_ver) . "</option>\n";

        } while ($this->db->reg_siguiente());
        print "</select>";
        print "</li>";
      }

       public function combo_opciones($leyenda, $variable, $valores, $defecto,$todos=0) {
           
            print "<li>";
            print "<label for='" . $variable . "'>" . $leyenda . "</label>";
            print "<select size='0' name='" . $variable . "' id='" . $variable . "'>";

            if ($todos==1) {
                print "<option value=''";
                print "></option>\n";
            }

            foreach ($valores as $value) {
                print "<option value='";
                print $value;
                print "' ";
                if ($defecto==$value) {
                    print "selected";
                }
                print ">";
                print $value;
                print "</option>\n";
            }
            print "</select>";
            print "</li>";

       }


      public function cerrar($leyenda) {
            $this->abrir_renglon();
            $this->boton($leyenda);
            $this->cerrar_renglon();
            $this->cerrar_formulario();
      }

      public function boton($leyenda) {
             print "<input type='submit' name='accion' value='" . $leyenda . "'>";
      }

        public function file_box($leyenda,$variable,$ayuda="") {
            print "<li>";
            print "<label for='upload'>" . $leyenda . "</label>";
            print "<input type='file' name='" . $variable . "' id='" . $variable . "' />";
            print " " . $ayuda;
            print "</li>";
        }

      public function cerrar_formulario() {
             print "</ul>";
             print "</form>";
             print "</div>";             
      }
      
      
      
      
      public function abrir_renglon() {
        print "<dl>";
      }
      public function cerrar_renglon() {
        print "</dl>";
      }
      
      
      
      public function tabla_open($tamanio=920, $valores) {
            print "<table width='" . $tamanio . "' border='0'>";
            print "<tr class='fondo_formulario_tabla_titulo'>";
            foreach ($valores as $value) {
                print "<td>";
                print $value;
                print "</td>";
            }
            print "</tr>";
      }
      
      public function tabla_line($valores) {
            print "<tr>";
            
            foreach ($valores as $value) {
                print "<td>";
                print $value;
                print "</td>";
            }
            print "</tr>";
            
      }


      public function tabla_close() {
            print "</table>";
      }
      
      
      

}
?>