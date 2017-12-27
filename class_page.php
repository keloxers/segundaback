<?php

class page {

    public $id_pagina;
    public $titulo;
    public $contenido;
    public $estado;


    public $campo_indice;
    public $tipo_busqueda;
    public $id_busqueda1;
    public $id_busqueda2;
    private $db;


/*

    id_page
    titulo
    contenido
    estado            
    
*/

    function __construct() {
        $this->box = new mensaje();
        $this->db = new db();
    }

    private function tomar_post() {
        if (isset($_REQUEST["vbuscarcampo"])) {
            $this->buscar_campo=$_REQUEST["vbuscarcampo"]; }
        if (isset($_REQUEST["vbuscarvalor"])) {
            $this->buscar_valor=$_REQUEST["vbuscarvalor"]; }

        if (isset($_REQUEST["id_page"])) {
            $this->id_page=$_REQUEST["id_page"]; }
        if (isset($_REQUEST["titulo"])) {
            $this->titulo=$_REQUEST["titulo"]; }
        if (isset($_REQUEST["contenido"])) {
            $this->contenido=$_REQUEST["contenido"]; }
        if (isset($_REQUEST["estado"])) {
            $this->estado=$_REQUEST["estado"]; }

                
        if (isset($_REQUEST["campo_indice"])) {
            $this->campo_indice=$_REQUEST["campo_indice"]; }
        if (isset($_REQUEST["tipo_busqueda"])) {
            $this->tipo_busqueda=$_REQUEST["tipo_busqueda"]; }
        if (isset($_REQUEST["id_busqueda1"])) {
            $this->id_busqueda1=$_REQUEST["id_busqueda1"]; }
        if (isset($_REQUEST["id_busqueda2"])) {
            $this->id_busqueda2=$_REQUEST["id_busqueda2"]; }

}

  public function cargar_registro() {
         $this->id_page =$this->db->campo("id_page");
         $this->titulo =$this->db->campo("titulo");
         $this->contenido =$this->db->campo("contenido");
         $this->estado =$this->db->campo("estado");
  }


  public function modificar() {
          $this->tomar_post();
          if ($this->titulo==""){
              $this->box->mensaje="El campo titulo no puede estar vacio.";
              $this->box->show_error();
              die;
          }
                              
          $this->armar_sql("modificar");
          
          $this->db->query_db();
          if ( $this->db->reg_afectados > 0 ) {
              $this->box->mensaje="Se modificó correctamente la pagina.";
              $this->box->show_ok();
          }
  }

   public function borrar() {
          $this->tomar_post();
          $this->db->sql = "DELETE FROM pages where id_page=" . $this->id_page;
          $this->db->query_db();
          if ($this->db->reg_afectados > 0 ) {
              $this->box->mensaje="Se borró correctamente la pagina.";
              $this->box->show_ok();
          } else {
              $this->box->mensaje="NO se borró la pagina.";
              $this->box->show_error();
          }

   }

   public function confirmar_borrar() {
          $this->tomar_post();
          $this->db->sql = "SELECT * FROM pages where id_page=" . $this->id_page;
          $this->db->query_db();
          $formulario = new formulario();
          $formulario->abrir("Paginas");
          $formulario->text_view("id",$this->db->campo("id_page"),"");
          $formulario->text_oculto("id_page",$this->db->campo("id_page"));
          $formulario->text_view("titulo",$this->db->campo("titulo"),"");
          $formulario->abrir_renglon();
          $formulario->boton("Confirma Borrar Pagina");
          $formulario->cerrar_renglon();
          $formulario->cerrar_formulario();
    }

  public function show_formulario_agregar() {
  	 $this->tomar_post();
	 $formulario = new formulario();
            $formulario->abrir("Paginas");

            if ($this->id_page > 0 ){
                $formulario->text_view("id",$this->id_page,"");
                $formulario->text_oculto("id_page",$this->id_page);
                $this->db->sql = "SELECT * FROM pages where id_page=" . $this->id_page;
                $this->db->query_db();
                $this->cargar_registro();
                $boton_texto="Modificar Pagina";
            } else {
                $formulario->text_view("id","asignación automática","");
                $this->titulo="";
                $this->contenido="";
                $this->estado="activo";
                $boton_texto="Agregar Pagina";
            }
            $formulario->text_box("Titulo","titulo",30,30,$this->titulo,"");
            $formulario->text_area_box("Contenido","contenido",70,15,$this->contenido,"");
            $formulario->combo_opciones("Estado","estado",array("activo","inactivo"),$this->estado);                    
            
            $formulario->cerrar($boton_texto);
  }

  public function show_form_filtro_listado() {

            $formulario = new formulario();
            $formulario->abrir("Filtro para Listado",400);
            $formulario->combo_opciones("Por", "campo_indice", array("id_marca", "marca"), $this->campo_indice);
            $formulario->cerrar ("Listado Ordenado");

   }

   public function agregar() {
          $this->tomar_post();
          if ($this->titulo==""){
                $this->box->mensaje="El campo titulo no puede estar vacio.";
                $this->box->show_error();
          die; }
          $this->db->sql = "select * from pages where titulo='" . $this->titulo . "'";
          $this->db->query_db();
          if ($this->db->reg_total > 0) {
                $this->box->mensaje="Ya existe esa pagina.";
                $this->box->show_error();
                die;
          }
          
          $this->estado ='activo';

          $this->armar_sql("nuevo");

          $this->db->query_db();
          if ($this->db->insertado()) {
                $this->box->mensaje="Se agregó correctamente la pagina.";
                $this->box->show_ok();
          }
  }

   private function armar_sql($accion) {
            if ($accion=="nuevo"){
                $this->db->sql = "INSERT INTO \n";
            } else {
                $this->db->sql = "UPDATE \n";
            }
            $this->db->sql .= "pages SET \n";
            $this->db->sql .= "titulo='". $this->titulo . "', \n";
            $this->db->sql .= "contenido='". $this->contenido . "', \n";
            $this->db->sql .= "estado='". $this->estado . "'\n";

            // print $this->db->sql;
            
            if ($accion<>"nuevo"){
                $this->db->sql .= "where id_page=" . $this->id_page . "\n";
            }
          }

   public function show_listado($pageInicio) {
            $this->tomar_post();
            $this->db->sql="select * from pages order by titulo"; // . " limit " . $pageInicio . ",30";
            $this->db->query_db();
            $this->view_listado();
          }

   public function view_listado() {

          print "<table width='640' border='1' class='tabla'>\n";
          print "<tr>";
          print "<td class='tablaTitulo'>Acción</td>";
          print "<td class='tablaTitulo'>Id</td>";
          print "<td class='tablaTitulo'>Titulo</td>";
          print "<td class='tablaTitulo'>Estado</td>";          
          $icon = new icon();
          
          print "</tr>";
          do {
                 print "<tr>";
                 print "<td class='tabla_Items'>";
                     $venlace=$_SERVER["PHP_SELF"];
                     print "<a href='$venlace?accion=editar_page&id_page=" . $this->db->campo("id_page") . "'>";
                     $icon->editar(16);
                     print " Editar" . "</a> ";
                     print "<a href='$venlace?accion=borrar_page&id_page=" . $this->db->campo("id_page") . "'>";
                     $icon->borrar(16);
                     print " Borrar" . "</a> ";
                 print "</td>";
                 print "<td class='tabla_Items'align='center'>" . $this->db->campo("id_page") . "</td>";
                 print "<td class='tabla_Items'>";
		         print $this->db->campo("titulo");
                 print "</td>";
                 print "<td class='tabla_Items'>";
                 print $this->db->campo("estado");
                 print "</td>";
                 
        } while ($this->db->reg_siguiente());
        print "</table>";
}

   public function show_formulario_busqueda() {
          print "<form method='post' action='" . $_SERVER["PHP_SELF"] . "' enctype='multipart/form-data'>";
          print "Buscar por:<select name='vbuscarcampo' id='vbuscarcampo'>";
          print ("<option value='id_page'> Id </option>");
          print ("<option value='titulo' selected> titulo </option>");
          print "</select> ";
          print "<input name='vbuscarvalor' type='text' id='vbuscarvalor' size='50' maxlength='50' value=''>";
          print "'<br>\n";
          print "<input id='tipo_busqueda' type='radio' name='tipo_busqueda' value='exacto'> Exacto \n";
          print "<input id='tipo_busqueda' type='radio' name='tipo_busqueda' value='inicial'> Inicial \n";
          print "<input id='tipo_busqueda' type='radio' name='tipo_busqueda' value='contenga' checked> Contenga \n";
          print "<input type='submit' name='accion' value='Buscar Pagina'><br>";
          print "</form>";
          }


   public function buscar_post() {
          $this->tomar_post();

          $this->db->sql="select * from pages where ";
          $this->db->sql.= $this->buscar_campo;

          switch ($this->tipo_busqueda) {
                  case "exacto":
                        $this->db->sql.= " = '" . $this->buscar_valor . "'";
                        break;
                  case "inicial":
                        $this->db->sql.= " Like '" . $this->buscar_valor . "%'";
                        break;
                  case "contenga":
                        $this->db->sql.= " Like '%" . $this->buscar_valor . "%'";
                        break;
         }

         $this->db->sql.= " order by titulo";

          if (!$this->db->query_db()) {
                $this->box->mensaje="No se encontraron coincidencias.";
                $this->box->show_error();
                return;
          }
          $this->num=$this->db->reg_total;
          $this->view_listado();
          }

   public function que($id_page,$campo) {
          $this->db->sql="select * from pages where id_page=" . $id_page;
          $this->db->query_db();
          if ($this->db->reg_total > 0) {
             return $this->db->campo($campo);
          }
    }

      public function form_filtro_listado(){
            $formulario = new formulario();
            $formulario->abrir("Listado Maestro de paginas",400,"nueva");
            $formulario->combo_box("Desde Pagina","id_busqueda1","pages","titulo","id_page", $this->id_busqueda1);
            $formulario->combo_box(" Hasta Pagina","id_busqueda2","pages","titulo","id_page", $this->id_busqueda2);
            $formulario->text_oculto("mostrar_menu",false);
            $formulario->cerrar("Listado Maestro");
 }


 public function mostrar_listado() {
            $this->tomar_post();
            $marca = new marca();

            $this->db->sql .= "select * from pages \n";
            $this->db->sql .= "order by titulo";

            $this->db->query_db();
            $this->num=$this->db->reg_total;
            $reporte = new reporte("vertical","LISTADO MAESTRO DE marcaS","Desde: " . $marca->que($this->id_busqueda1, "marca") . "  Hasta: " . $marca->que($this->id_busqueda2, "marca"));
            $reporte->col_xPos = array ( 5,15);
            $reporte->col_tamanos = array (5,5);
            $reporte->col_nombres_columnas = array ("Id marca","marca");
            $reporte->col_alineacion = array("center","left");
            $reporte->inicializar();
            $estado = false;
            do {
                if ( $this->db->campo("id_marca")==$this->id_busqueda1) {
                    $estado = true;
                }

                    if ($estado) {
                        $reporte->renglon = array (
                        $this->db->campo("id_marca"),
                        $this->db->campo("marca")
                     );
                        $reporte->imprimir_renglon();
                     }
                    if ( $this->db->campo("id_marca")==$this->id_busqueda2) {
                        $estado = false;
                    }
            } while ($this->db->reg_siguiente());
            $reporte->renglon = array ("","");
            $reporte->imprimir_renglon();
            $reporte->mostrar();

         }

 public function ver_page() {
            $this->tomar_post();

            $this->db->sql .= "select * from pages \n";
            $this->db->sql .= "where id_page=" . $this->id_page;

            if (!$this->db->query_db()) {
                print "No existe la página";
                return;
            }

            $this->cargar_registro();

          print "<table width='640' border='0' class='tabla'>\n";
          print "<tr>";
          print "<td class='tabla_Items'>";          
          print $this->contenido;          
          print "</td>";
          print "</table>";




         }
         
         
         
}

?>
