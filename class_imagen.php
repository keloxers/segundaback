<?php

class imagen {

    public $id_imagen;
    public $id_usuario;
    public $file_name;

    public $campo_indice;
    public $tipo_busqueda;
    public $id_busqueda1;
    public $id_busqueda2;
    private $db;


/*
	id_imagen
	id_usuario
	file_name
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

        if (isset($_REQUEST["id_imagen"])) {
            $this->id_imagen=$_REQUEST["id_imagen"]; }
        if (isset($_REQUEST["id_usuario"])) {
            $this->id_usuario=$_REQUEST["id_usuario"]; }
        if (isset($_REQUEST["file_name"])) {
            $this->file_name=$_REQUEST["file_name"]; }

        if (isset($_REQUEST["campo_indice"])) {
            $this->campo_indice=$_REQUEST["campo_indice"]; }
        if (isset($_REQUEST["tipo_busqueda"])) {
            $this->tipo_busqueda=$_REQUEST["tipo_busqueda"]; }
        if (isset($_REQUEST["id_busqueda1"])) {
            $this->id_busqueda1=$_REQUEST["id_busqueda1"]; }
        if (isset($_REQUEST["id_busqueda2"])) {
            $this->id_busqueda2=$_REQUEST["id_busqueda2"]; }

}

public function cargar_db() {
                $this->id_imagen = $this->db->campo("id_imagen");
                $this->id_usuario = $this->db->campo("id_usuario");
                $this->file_name = $this->db->campo("file_name");                
}


  public function modificar() {
          $this->tomar_post();
          $this->armar_sql("modificar");
          $this->db->query_db();
          if ( $this->db->reg_afectados > 0 ) {
               return true;
          }
  }

   public function borrar() {
          $this->tomar_post();
          $archivo=$this->que($this->id_usuario,"file_name");
          $this->db->sql = "DELETE FROM imagenes where id_usuario=" . $this->id_usuario;
          // print "SQL: " . $this->db->sql ."<br>";
          $this->db->query_db();
          if ($this->db->reg_afectados > 0 ) {

		@unlink("imagenes/galeria/m/" . $archivo . ".jpg");
		@unlink("imagenes/galeria/g/" . $archivo . ".jpg");
                return true;
          } else {
                return false;
          }

   }

   public function confirmar_borrar() {
          $this->tomar_post();
          $this->db->sql = "SELECT * FROM categorias where id_categoria=" . $this->id_categoria;
          $this->db->query_db();
          $formulario = new formulario();
          $formulario->abrir("Categorias");
          $formulario->text_view("id",$this->db->campo("id_categoria"),"");
          $formulario->text_oculto("id_categoria",$this->db->campo("id_categoria"));
          $formulario->text_view("categoria",$this->db->campo("categoria"),"");
          $formulario->abrir_renglon();
          $formulario->boton("Confirma Borrar");
          $formulario->cerrar_renglon();
          $formulario->cerrar_formulario();
    }

  public function show_formulario_agregar() {
  	 $this->tomar_post();
	 $formulario = new formulario();
            $formulario->abrir("Categorias");
            // $this->categoria="";
            if ($this->id_categoria > 0 ){
                $formulario->text_view("id",$this->id_categoria,"");
                $formulario->text_oculto("id_categoria",$this->id_categoria);
                $this->db->sql = "SELECT * FROM categorias where id_categoria=" . $this->id_categoria;
                $this->db->query_db();
                $this->id_padre=$this->db->campo("id_padre");
                $this->categoria=$this->db->campo("categoria");
		$formulario->text_box("id_padre","id padre",30,30,$this->id_padre,"");
                $boton_texto="Modificar";
            } else {
                $formulario->text_view("id","asignacion autom�tica","");
		if ($this->id_padre > 0) {
	                $formulario->text_view("id_padre",$this->id_padre,"");
                } else {
	                $this->id_padre="0";
	                $formulario->text_view("id_padre","Raiz","");
                }
                $formulario->text_oculto("id_padre",$this->id_padre);
                $this->categoria="";
                $boton_texto="Agregar";
            }

            $formulario->text_box("categoria","categoria",30,30,$this->categoria,"");
            $formulario->cerrar($boton_texto);
  }

  public function show_form_filtro_listado() {
            $formulario = new formulario();
            $formulario->abrir("Filtro para Listado",400);
            $formulario->combo_opciones("Por", "campo_indice", array("id_categoria", "categoria"), $this->campo_indice);
            $formulario->cerrar ("Listado Ordenado");
   }

   public function agregar() {
          $this->tomar_post();
          if ($this->file_name==""){
                $this->box->mensaje="El campo file_name no puede estar vacio.";
                $this->box->show_error();
          die; }

          $this->armar_sql("nuevo");
          // print "SQL: " . $this->db->sql . "<br>";

          $this->db->query_db();
          if (!$this->db->insertado()) {
              return false;
          } else {
              return true;
          }
  }

   private function armar_sql($accion) {
            if ($accion=="nuevo"){
                $this->db->sql = "INSERT INTO \n";
            } else {
                $this->db->sql = "UPDATE \n";
            }
            $this->db->sql .= "imagenes SET \n";
            $this->db->sql .= "id_usuario=". $this->id_usuario . ", \n";
            $this->db->sql .= "file_name='". $this->file_name . "'\n";

            if ($accion<>"nuevo"){
                $this->db->sql .= "where id_imagen=" . $this->id_imagen . "\n";
            }
          }
          
    public function buscar($id_usuario) {
        $this->db->sql="select * from imagenes where ";
        $this->db->sql.= "id_usuario=" . $id_usuario;
        // print "SQL: " . $this->db->sql . "<br>";
        if ($this->db->query_db() ){
            $this->cargar_db();
            return true;            
        } else {
            return false;
        }
    }

    
   public function show_listado($pageInicio) {
            $this->tomar_post();
            $this->db->sql="select * from categorias order by id_padre"; // . " limit " . $pageInicio . ",30";
            $this->db->query_db();
            $this->view_listado();
          }

   public function view_listado() {


          print "<table width='" . VV_ANCHO_PAGE . "' border='1' class='tabla'>\n";
          print "<tr>";
          print "<td class='tablaTitulo'>Accion</td>";
          print "<td class='tablaTitulo'>Id</td>";
          print "<td class='tablaTitulo'>Id Padre</td>";
          print "<td class='tablaTitulo'>Categoria</td>";
          print "<td class='tablaTitulo'>Acci�n</td>";
          print "<td class='tablaTitulo'>Articulos</td>";

          $categoria = new categoria();


          print "</tr>";
          do {
                 print "<tr>";
                 print "<td class='tabla_Items'>";
                     $venlace=$_SERVER["PHP_SELF"];
                     print "<a href='$venlace?accion=editar&id_categoria=" . $this->db->campo("id_categoria") . "'>" . "<img src='/images/edit.png' width='16' height='16' border='0'> editar" . "</a> ";
                     print "<a href='$venlace?accion=borrar&id_categoria=" . $this->db->campo("id_categoria") . "'>" . "<img src='/images/delete.png' width='16' height='16' border='0'> borrar" . "</a> ";
                 print "</td>";
                 print "<td class='tabla_Items'align='center'>" . $this->db->campo("id_categoria") . "</td>";
                 print "<td class='tabla_Items'align='center'>";
                 if ($this->db->campo("id_padre")==0) {
                 	print "RAIZ";
                 } else {
			print $categoria->que($this->db->campo("id_padre"),"categoria");
                 }
                 print "</td>";
                 print "<td class='tabla_Items'>";
		 print "<a href='$venlace?accion=buscar&";
		 print "vbuscarcampo=id_padre&";
		 print "vbuscarvalor=" . $this->db->campo("id_categoria") . "&";
		 print "tipo_busqueda=exacto" . " ";
                 print "'>" . "<img src='/images/bullet_go.png' width='16' height='16' border='0'>";
		 print $this->db->campo("categoria")  . "</a> ";
                 print "</td>";

	  	 print "<td class='tabla_Items'>" . "<a href='$venlace?accion=form_agregar&id_padre=" . $this->db->campo("id_categoria") . "'>" . "<img src='/images/add.png' width='16' height='16' border='0'> hijo" . "</a>". "</td>";

	  	 print "<td class='tabla_Items'>" . "<a href='articulos.php?accion=form_agregar&id_categoria=" . $this->db->campo("id_categoria") . "'>" . "<img src='/images/add.png' width='16' height='16' border='0'> articulo" . "</a>";
	  	 print " <a href='articulos.php?accion=form_agregar&id_categoria=" . $this->db->campo("id_categoria") . "'>" . "<img src='/images/page_white_text.png' width='16' height='16' border='0'> Ver" . "</a>". "</td>";

                 print "</tr>\n";
        } while ($this->db->reg_siguiente());
            print "</table>";
}

   public function show_formulario_busqueda() {
          print "<form method='post' action='" . $_SERVER["PHP_SELF"] . "' enctype='multipart/form-data'>";
          print "Buscar por:<select name='vbuscarcampo' id='vbuscarcampo'>";
          print ("<option value='id_categoria'> Id </option>");
          print ("<option value='categoria' selected> categoria </option>");
          print "</select> ";
          print "<input name='vbuscarvalor' type='text' id='vbuscarvalor' size='50' maxlength='50' value=''>";
          print "'<br>\n";
          print "<input id='tipo_busqueda' type='radio' name='tipo_busqueda' value='exacto' checked> Exacto \n";
          print "<input id='tipo_busqueda' type='radio' name='tipo_busqueda' value='inicial'> Inicial \n";
          print "<input id='tipo_busqueda' type='radio' name='tipo_busqueda' value='contenga'> Contenga \n";
          print "<input type='submit' name='accion' value='buscar'><br>";
          print "</form>";
          }


   public function buscar_post() {
          $this->tomar_post();

          $this->db->sql="select * from categorias where ";
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

         $this->db->sql.= " order by id_padre";

          if (!$this->db->query_db()) {
                $this->box->mensaje="No se encontraron coincidencias.";
                $this->box->show_error();
                Die;
          }
          $this->num=$this->db->reg_total;
          $this->view_listado();
          }

   public function que($id_usuario,$campo) {
          $this->db->sql="select * from imagenes where id_usuario=" . $id_usuario;
          $this->db->query_db();
          if ($this->db->reg_total > 0) {
             return $this->db->campo($campo);
          }
    }

      public function form_filtro_listado(){
            $formulario = new formulario();
            $formulario->abrir("Listado Maestro de Categorias",400,"nueva");
            $formulario->combo_box("Desde categoria","id_busqueda1","categorias","categoria","id_categoria", $this->id_busqueda1);
            $formulario->combo_box(" Hasta categoria","id_busqueda2","categorias","categoria","id_categoria", $this->id_busqueda2);
            $formulario->text_oculto("mostrar_menu",false);
            $formulario->cerrar("Listado Maestro");
 }


 public function mostrar_listado() {
            $this->tomar_post();
            $categoria = new categoria();

            $this->db->sql .= "select * from categorias \n";
            $this->db->sql .= "order by categoria";

            $this->db->query_db();
            $this->num=$this->db->reg_total;
            $reporte = new reporte("vertical","LISTADO MAESTRO DE CATEGORIAS","Desde: " . $categoria->que($this->id_busqueda1, "categoria") . "  Hasta: " . $categoria->que($this->id_busqueda2, "categoria"));
            $reporte->col_xPos = array ( 5,15);
            $reporte->col_tamanos = array (5,5);
            $reporte->col_nombres_columnas = array ("Id Categoria","Categoria");
            $reporte->col_alineacion = array("center","left");
            $reporte->inicializar();
            $estado = false;
            do {
                if ( $this->db->campo("id_categoria")==$this->id_busqueda1) {
                    $estado = true;
                }

                    if ($estado) {
                        $reporte->renglon = array (
                        $this->db->campo("id_categoria"),
                        $this->db->campo("categoria")
                     );
                        $reporte->imprimir_renglon();
                     }
                    if ( $this->db->campo("id_categoria")==$this->id_busqueda2) {
                        $estado = false;
                    }
            } while ($this->db->reg_siguiente());
            $reporte->renglon = array ("","");
            $reporte->imprimir_renglon();
            $reporte->mostrar();

         }

   public function contar_imagenes($id_usuario) {
   	  $db = new db();
          $db->sql="select count(*) from imagenes where id_usuario=" . $id_usuario;
          $db->query_db();
	  $imagenes=$db->campo("count(*)");
 	  return $imagenes;

   }



}




?>
