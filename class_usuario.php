<?php

class usuario {
   
    public $id_usuario;
    public $id_empresa;
    public $usuario;
    public $clave;
    public $nombre;
    public $email;
    public $activo;
    public $tipo;
    public $session;
    public $razon_social;
    public $cuit;
    public $direccion;
    public $telefono;
    public $contacto;
    public $tipo_empresa;
    
    
    
    public $accion;
    public $page;

    public $archivo;        
/*
    id_usuario
    id_empresa
    usuario
    clave
    nombre
    email
    activo
    tipo
    session    
    url_logo
    razon_social
    cuit
    direccion
    telefono
    contacto  
  
    
*/  

    public $campo_indice;
    public $tipo_busqueda;
    public $id_busqueda1;
    public $id_busqueda2;

    public $session_actual;

    public $form_usuario;
    public $form_clave;    
    public $form_email;
    
    private $db;
    private $box;

    function __construct() {

        // ini_set('session_save_path', '/home/users/web/b2341/moo.jcalvez/kelo/virasorovirtual/cgi-bin/tmp');
        // session_name('keloxers');

        if(@session_start() == false){session_destroy();session_start();}        
        $this->session_actual=session_id();
        $this->db = new db();
        $this->box = new mensaje();

    }

    public function session_out() {
             $this->usuario_activo();        
             $this->db->sql = "UPDATE \n";
             $this->db->sql .= "usuarios SET \n";
             $this->db->sql .= "session=''\n";
             $this->db->sql .= "where id_usuario=" . $this->id_usuario . " and activo='si'\n";
             $this->db->query_db();
             $_SESSION["id_idioma"] = "";
    }
    
    
    private function cargar_db() {
        $this->id_usuario = $this->db->campo("id_usuario");
        $this->usuario = $this->db->campo("usuario");
        $this->id_empresa = $this->db->campo("id_empresa");
        $this->clave = $this->db->campo("clave");
        $this->nombre = $this->db->campo("nombre");
        $this->email = $this->db->campo("email");
        $this->activo = $this->db->campo("activo");
        $this->tipo = $this->db->campo("tipo");
        $this->session = $this->db->campo("session");
        $this->razon_social = $this->db->campo("razon_social");
        $this->cuit = $this->db->campo("cuit");
        $this->direccion = $this->db->campo("direccion");
        $this->telefono = $this->db->campo("telefono");
        $this->contacto = $this->db->campo("contacto");
        $this->tipo_empresa = $this->db->campo("tipo_empresa");

        
    }

    
    
    private function limpiar_campos() {
        $this->id_usuario = 0;
        $this->usuario = "";
        $this->id_empresa = "";
        $this->clave = "";
        $this->nombre = "";
        $this->email = "";
        $this->activo = "";
        $this->tipo = "";
        $this->session = "";
        $this->razon_social = "";
        $this->cuit = "";
        $this->direccion = "";
        $this->telefono = "";
        $this->contacto = "";
        $this->tipo_empresa = "";
    }
    
    
    private function tomar_post() {
        
        $areas=explode("/",$_SERVER["REQUEST_URI"]);
        $this->accion=$areas[1];
        

        if ($this->accion=="index.php") {
            if (isset($_REQUEST["accion"])) {
                  $this->accion=$_REQUEST["accion"];
            } else {
                $this->accion="home";
            }
        }
        
        
        switch ($this->accion) {
            case "user":
                $this->usuario=$areas[2];
                break;
            case "activate":
                $this->usuario=$areas[2];
                $this->session=$areas[3];
                
        }

        if (isset($_REQUEST["vbuscarcampo"])) {
            $this->buscar_campo=$_REQUEST["vbuscarcampo"]; }
        if (isset($_REQUEST["vbuscarvalor"])) {
            $this->buscar_valor=$_REQUEST["vbuscarvalor"]; }
        if (isset($_REQUEST["campo_indice"])) {
            $this->campo_indice=$_REQUEST["campo_indice"]; }
        if (isset($_REQUEST["tipo_busqueda"])) {
            $this->tipo_busqueda=$_REQUEST["tipo_busqueda"]; }
        if (isset($_REQUEST["id_busqueda1"])) {
            $this->id_busqueda1=$_REQUEST["id_busqueda1"]; }
        if (isset($_REQUEST["id_busqueda2"])) {
            $this->id_busqueda2=$_REQUEST["id_busqueda2"]; }
        if (isset($_REQUEST["id_usuario"])) {
            $this->id_usuario=$_REQUEST["id_usuario"]; }
        if (isset($_REQUEST["usuario"])) {
            $this->usuario=$_REQUEST["usuario"]; }
        if (isset($_REQUEST["id_empresa"])) {
            $this->id_empresa=$_REQUEST["id_empresa"]; }
        if (isset($_REQUEST["form_usuario"])) {
            $this->form_usuario=$_REQUEST["form_usuario"]; }
        if (isset($_REQUEST["clave"])) {
            $this->clave=$_REQUEST["clave"]; }
        if (isset($_REQUEST["form_clave"])) {
            $this->form_clave=$_REQUEST["form_clave"]; }
        if (isset($_REQUEST["nombre"])) {
            $this->nombre=$_REQUEST["nombre"]; }
        if (isset($_REQUEST["email"])) {
            $this->email=$_REQUEST["email"]; }
        if (isset($_REQUEST["session"])) {
            $this->session=$_REQUEST["session"]; }
        if (isset($_REQUEST["razon_social"])) {
            $this->razon_social=$_REQUEST["razon_social"]; }
        if (isset($_REQUEST["cuit"])) {
            $this->cuit=$_REQUEST["cuit"]; }
        if (isset($_REQUEST["direccion"])) {
            $this->direccion=$_REQUEST["direccion"]; }
        if (isset($_REQUEST["telefono"])) {
            $this->telefono=$_REQUEST["telefono"]; }
        if (isset($_REQUEST["contacto"])) {
            $this->contacto=$_REQUEST["contacto"]; }

        if (isset($_REQUEST["archivo"])) {
            $this->archivo=$_REQUEST["archivo"]; }
        if (isset($_REQUEST["tipo_empresa"])) {
            $this->tipo_empresa=$_REQUEST["tipo_empresa"]; }            

   }

    public function modificar() {
        $this->tomar_post();
                
        $this->db->sql = "UPDATE \n";
        $this->db->sql .= "usuarios SET \n";
        $this->db->sql .= "clave='". $this->clave . "', \n";
        $this->db->sql .= "nombre='". $this->nombre . "', \n";
        $this->db->sql .= "email='". $this->email . "', \n";            
        $this->db->sql .= "razon_social='". $this->razon_social . "', \n";
        $this->db->sql .= "cuit='". $this->cuit . "', \n";
        $this->db->sql .= "direccion='". $this->direccion . "', \n";
        $this->db->sql .= "telefono='". $this->telefono . "', \n";
        $this->db->sql .= "contacto='". $this->contacto . "', \n";
        $this->db->sql .= "tipo_empresa='". $this->tipo_empresa . "' \n";

        $this->db->sql .= " where id_usuario=" . $this->id_usuario . "\n";
        
        // print "SQL: " . $this->db->sql . "<br>";
        
        $this->db->query_db();
        if ( $this->db->reg_afectados > 0 ) {
            $this->box->mensaje="Se modifico correctamente el usuario<br>";
            $this->box->show_ok();            
        } else {
            $this->box->mensaje="No hubo cambios en los datos del usuario<br>";
            $this->box->show_ok();                        
        }
        
        $imagen = new imagen();
        
        if (!empty($_FILES['archivo']['name'])){
            if ($imagen->buscar($this->id_usuario)) {
                $imagen->id_usuario = $this->id_usuario;
                if ($imagen->borrar()) {
                    $this->box->mensaje="Se borro la imagen anterior.<br>";
                    $this->box->show_ok();
                }
            }
            $this->imagen_redimension_save();
            $this->box->mensaje="Se agrego la nueva imagen a el usuario.<br>";
            $this->box->show_ok();
            
        }

        
    }

   
   public function borrar() {
          $this->tomar_post();
          $this->db->sql = "DELETE FROM usuarios where id_usuario=" . $this->id_usuario;
          $this->db->query_db();
          if ($this->db->reg_afectados > 0 ) {
              $this->box->mensaje="Se borr� correctamente el usuario.";
              $this->box->show_ok();
          } else {
              $this->box->mensaje="NO borr� correctamente el usuario.Puede tener datos asociados.";
              $this->box->show_error();
          }
   }

   public function confirmar_borrar() {
          $this->tomar_post();
          $this->db->sql = "SELECT * FROM usuarios where id_usuario=" . $this->id_usuario;
          $this->db->query_db();
          $formulario = new formulario();
          $formulario->abrir("Usuario");
          $formulario->text_view("id",$this->db->campo("id_usuario"),"");
          $formulario->text_oculto("id_usuario",$this->db->campo("id_usuario"));
          $formulario->text_view("Usuario",$this->db->campo("usuario"),"");
          $formulario->text_view("Nombre",$this->db->campo("nombre"),"");
          $formulario->abrir_renglon();
          $formulario->boton("Confirma Borrar Usuario");
          $formulario->cerrar_renglon();
          $formulario->cerrar_formulario();
    }
    
  public function show_formulario_agregar() {
        $this->tomar_post();
                
        $this->id_usuario=$this->usuario_activo("id_usuario");

        $formulario = new formulario();
        $formulario->abrir("perfil");
      
        if ($this->id_usuario > 0) {
            $this->db->sql="select * from usuarios where id_usuario=" . $this->id_usuario . " limit 1";
            if ($this->db->query_db()) {
                $this->cargar_db();
            }
            $formulario->text_oculto("id_usuario", $this->id_usuario);
            $boton="modificar perfil";
                         
            $formulario->text_view("Usuario",$this->usuario,"");            
        } else { 
            // $this->limpiar_campos();
            $boton="Registrarse";
            $formulario->text_box("Usuario","usuario",30,50,$this->usuario,"");
        }
        
        $formulario->clave_box("Clave","clave",30,30,$this->clave,"");
        $formulario->text_box("Nombre","nombre",50,75,$this->nombre,"");
        $formulario->text_box("Email","email",50,125,$this->email,"Debera ingresar un email valido para esta cuenta");
        $formulario->text_box("Razon Social","razon_social",50,125,$this->razon_social,"");
        $formulario->text_box("Cuit","cuit",11,11,$this->cuit,"");
        $formulario->text_box("Direccion","direccion",50,125,$this->direccion,"");
        $formulario->text_box("Telefono","telefono",50,75,$this->telefono,"");
        $formulario->text_box("Contacto","contacto",50,75,$this->contacto,"");
        $formulario->combo_opciones("Tipo Empresa", "tipo_empresa", array("standart","agencias"), $this->tipo_empresa);
    
        $formulario->abrir_renglon();
        $formulario->boton($boton);
        $formulario->cerrar_renglon();
        $formulario->cerrar_formulario();
  }




    
    
  public function validacion() {
        $this->tomar_post();
        
        $validacion=true;
        
        $this->db->sql="select * from usuarios where usuario='" . $this->usuario . "' limit 1";
        if ($this->db->query_db()) {
            print "El usuario ya existe" . ".<br>";
            $validacion=false;
        }
        
        if($this->clave==""){
            print "La clave no puede estar vacia" . ".<br>";
            $validacion=false;
        }
        
        if($this->nombre==""){
            print "El nombre no puede estar vacio" . ".<br>";
            $validacion=false;
        }
        
        if($this->email==""){
            print "El email ingresado no es valido" . ".<br>";
            $validacion=false;
        }

        return $validacion;
        
  }
  
  
        
  

    public function agregar() {
            $this->tomar_post();

            if (!$this->validacion()){
                return false;
            }

            $this->email_verificado="no";
            $this->activo="no";
            $this->tipo="invitado";
            $this->session=md5($this->usuario);            
            $this->armar_sql("nuevo");
            $this->db->query_db();
            if ($this->db->insertado()) {
                
                $this->id_usuario=$this->db->insertado();
                
                print "Se agrego correctamente el usuario" . ".<br>";
                print "Muy pronto nos contactaremos con Uds. para habilitar el sistema" . ".<br>";
                print "Si tiene alguna consulta puede enviar un email a info@codexcontrol.com" . ".<br>";

            } else {
                print "Error. Cominiquese con el administrador" . ".<br>";
            }
            return true;
    }


   public function activar_usuario() {
            $this->tomar_post();
            
            if (($this->usuario=="") or ($this->session=="")) {
                print "Activacion incorrecta" . ".<br>";
                return;
            }
            
            $this->db->sql ="select * from usuarios where usuario='" . $this->usuario. "' \n";
            $this->db->sql.="and session='" . $this->session. "' limit 1\n";
            
            if ($this->db->query_db()) {
                $this->db->sql ="update usuarios set email_verificado='si', \n";
                // $this->db->sql.="session='" . md5($this->usuario). "' \n";
                $this->db->sql.="activo='si' \n";
                $this->db->sql.="where usuario='" . $this->usuario ."' limit 1\n";
                
                if ($this->db->query_db()) {
                    print "Se activo correctamente la cuenta" . ".<br>";
                } else {
                    print "Ocurrio un error al intentar activar la cuenta" . ".<br>";
                    return false;
                }
            }  else {
                    print "Activacion incorrecta" . ".<br>";
                    return false;
            }
            
            return true;

          }
    
    
    
    
   private function armar_sql($accion) {
            if ($accion=="nuevo"){
                $this->db->sql = "INSERT INTO \n";
            } else {
                $this->db->sql = "UPDATE \n";
            }
            
            $this->db->sql .= "usuarios SET \n";
            $this->db->sql .= "usuario='". $this->usuario . "', \n";
            $this->db->sql .= "clave='". $this->clave . "', \n";
            $this->db->sql .= "nombre='". $this->nombre . "', \n";
            $this->db->sql .= "email='". $this->email . "', \n";            
            $this->db->sql .= "activo='". $this->activo . "', \n";
            $this->db->sql .= "tipo='". $this->tipo . "', \n";
            $this->db->sql .= "session='". $this->session . "', \n";
            $this->db->sql .= "razon_social='". $this->razon_social . "', \n";
            $this->db->sql .= "cuit='". $this->cuit . "', \n";
            $this->db->sql .= "direccion='". $this->direccion . "', \n";
            $this->db->sql .= "telefono='". $this->telefono . "', \n";
            $this->db->sql .= "contacto='". $this->contacto . "', \n";
            $this->db->sql .= "tipo_empresa='". $this->tipo_empresa . "' \n";
            
            
            if ($accion<>"nuevo"){
                $this->db->sql .= " where id_usuario=" . $this->id_usuario . "\n";
            }
        
    }


          
          
   public function show_listado($pageInicio) {
            $this->db->sql="select * from usuarios order by id_usuario limit " . $pageInicio . ",30";
            $this->db->query_db();

            $this->view_listado();
          }


   public function view_listado() {

          print "<table width='920' border='1' class='tabla'>\n";
          print "<tr>";
          print "<td class='tablaTitulo'>Acci�n</td>";
          print "<td class='tablaTitulo'>Id</td>";
          print "<td class='tablaTitulo'>Usuario</td>";
          print "<td class='tablaTitulo'>Nombre</td>";          
          print "<td class='tablaTitulo'>Tipo</td>";                    
          print "<td class='tablaTitulo'>Activo</td>";
          $icon = new icon();

          print "</tr>";
          do {
                 print "<tr>";
                 print "<td class='tabla_Items'>";
                     $venlace=$_SERVER["PHP_SELF"];
                     print "<a href='$venlace?accion=editar_usuario&id_usuario=" . $this->db->campo("id_usuario") . "'>";
                     $icon->editar(16);
                     print " Editar" . "</a> ";
                     print "<a href='$venlace?accion=borrar_usuario&id_usuario=" . $this->db->campo("id_usuario") . "'>";
                     $icon->borrar(16);
                     print " Borrar" . "</a> ";
                 print "</td>";
                 print "<td class='tabla_Items'align='center'>" . $this->db->campo("id_usuario") . "</td>";
                 print "<td class='tabla_Items'>";
                 print $this->db->campo("usuario");
                 print "</td>";
                 print "<td class='tabla_Items'>";
                 print $this->db->campo("nombre");
                 print "</td>";
                 print "<td class='tabla_Items'>";
                 
                 if ($this->db->campo("tipo")=="invitado") {
                     print "<b>Invitado</b>";
                 } else {
                     print "<a href='$venlace?accion=cambiar_tipo&tipo=invitado&id_usuario=" . $this->db->campo("id_usuario") . "'>invitado</a>";
                 }
                 
                 if ($this->db->campo("tipo")=="cliente") {
                     print " <b>cliente</b>";
                 } else {
                     print " <a href='$venlace?accion=cambiar_tipo&tipo=cliente&id_usuario=" . $this->db->campo("id_usuario") . "'>cliente</a>";
                 }
                 if ($this->db->campo("tipo")=="administrador") {
                     print " <b>administrador</b>";
                 } else {
                     print " <a href='$venlace?accion=cambiar_tipo&tipo=administrador&id_usuario=" . $this->db->campo("id_usuario") . "'>administrador</a>";
                 }
                            
                 print "</td>";
                 print "<td class='tabla_Items'>";
                 print $this->db->campo("activo");
                 print "</td>";
                 
        } while ($this->db->reg_siguiente());
        print "</table>";

   }


//************************************************************************
//** Metodo: show_formulario_busqueda()
//** Funci�n: Muestra el formulario para realizar una busqueda.
//************************************************************************
   public function show_formulario_busqueda() {
          print "<form method='post' action='" . $_SERVER["PHP_SELF"] . "' enctype='multipart/form-data'>";
          print "Buscar por:<select name='vbuscarcampo' id='vbuscarcampo'>";
               print ("<option value='id_usuarios'> Id </option>");
               print ("<option value='usuario' selected> Usuario </option>");
               print ("<option value='activo'> Activos </option>");
          print "</select> ";
          print "<input name='vbuscarvalor' type='text' id='vbuscarvalor' size='50' maxlength='50' value=''>";
          print "<input type='submit' name='accion' value='Buscar Usuario'><br>";
          print "</form>";
          }


   public function buscar_post() {
          $this->tomar_post();
          $this->db->sql="select * from usuarios where ";
          $this->db->sql.= $this->buscar_campo . " Like " . "'";
          $this->db->sql.= $this->buscar_valor . "%'";
          $this->db->query_db();
          $this->view_listado();
          }


    public function validar_usuario() {
        $this->tomar_post();
        if (isset($this->form_usuario)) {
          $this->db->sql="select * from usuarios where ";
          $this->db->sql.= "usuario='" . $this->form_usuario . "' and activo='si'";
          if ($this->db->query_db()==false) {
            return false;
          }
          $this->cargar_db();
          if ($this->form_clave==$this->clave) {
             $this->db->sql = "UPDATE \n";
             $this->db->sql .= "usuarios SET \n";
             $this->db->sql .= "session='". $this->session_actual . "'\n";
             $this->db->sql .= "where id_usuario=" . $this->id_usuario . " and activo='si'\n";
             $this->db->query_db();
          } else {
            return false;
          }
          return true;
        }
        // return true;
        
        $this->db->sql="select * from usuarios where ";
        $this->db->sql.= "session='" . $this->session_actual . "' and activo='si'";
        
        if ($this->db->query_db()==false) {
            // print "SQL: " . $this->db->sql . "<br>";
            // print "Session actual: " . $this->session_actual . "<br>";
            $this->formulario_login();
            return;
        }
        
    }



    public function usuario_activo($campo="") {
        $this->db->sql="select * from usuarios where ";
        $this->db->sql.= "session='" . $this->session_actual . "'";
        if ($this->db->query_db()==false ){
            if ($campo=="tipo") {
                return "invitado";    
            } else {
                return false;
            }
        } else {
            $this->cargar_db();
            $_SESSION["id_idioma"] = $this->id_idioma;
            if ($campo=="") {
                return $this->db->campo("usuario");
            } else {
                return $this->db->campo($campo);
            }
        }
    }

    
    
    
   public function formulario_login() {
        $formulario = new formulario();
        $formulario->abrir("Login");
        $formulario->text_box("Usuario","form_usuario",30,50,$this->form_usuario,"");
        $formulario->clave_box("Clave","form_clave",30,30,$this->form_clave,"");
        $formulario->abrir_renglon();
        $formulario->boton("Ingresar");
        $formulario->cerrar_renglon();
        $formulario->cerrar_formulario();
    }

    
   public function formulario_recover_password() {
        $formulario = new formulario();
        $formulario->abrir("Recuperar password");
        $formulario->text_box("Email","form_email",30,50,$this->form_email,"");
        $formulario->abrir_renglon();
        $formulario->boton("Recuperar password");
        $formulario->cerrar_renglon();
        $formulario->cerrar_formulario();
    }
    
    
   public function que($id_usuario,$campo) {
          $this->db->sql="select * from usuarios where id_usuario=" . $id_usuario;
          $this->db->query_db();
          if ($this->db->reg_total > 0) {
             return $this->db->campo($campo);
          }
    }
    
   public function cambiar_tipo() {
        $this->tomar_post();       
        $this->db->sql = "UPDATE \n";
             $this->db->sql .= "usuarios SET \n";
             $this->db->sql .= "tipo='". $this->tipo . "'\n";
             $this->db->sql .= "where id_usuario=" . $this->id_usuario . " and activo='si'\n";
        if ($this->db->query_db()) {
            $this->box->mensaje="Se cambio correctamente el usuario a: " . $this->tipo;
            $this->box->show_ok();
        } else {
            $this->box->mensaje="No se pudo cambiar el tipo de usuario.";
            $this->box->show_error();
        }
    }
    
    
    public function is_admin() {
        if ($this->usuario_activo("tipo")<>"administrador") {
            print "No esta autorizado a ingresar aqui" . ".<br>";
            print "<br><br><br>Die!!!";
            die;
        }
    }    
    
             

            
}
?>