<?php
//************************************************************************
//** Objeto: Mensajes
//**
//************************************************************************

class mensaje {
    public $mensaje;

    //************************************************************************
    //** Metodo: Show()
    //** Función:
    //************************************************************************
    public function show_error() {
        print "<table width='340' border='0'>";
        print "<tr>";
        print "<td width='60' class='boxerror'><div align='center'><img src='error.png' width='25' height='25'></div></td>";
        print "<td width='280' align='left' valign='top' class='boxerror'>";
        print $this->mensaje;
        print "</td></tr></table>";
    }

    public function show_ok() {
        print "<table width='340' border='0'>";
        print "<tr>";
        print "<td width='60' class='boxerror'><div align='center'><img src='ok.png' width='25' height='25'></div></td>";
        print "<td width='280' align='left' valign='top' class='boxerror'>";
        print $this->mensaje;
        print "</td></tr></table>";
    }

    public function show_volver() {
        print "<table width='340' border='0'>";
        print "<tr>";
        print "<td width='60' class='boxerror'><div align='center'><img src='volver.jpg' width='25' height='25'onClick='self.history.back();'></div></td>";
        print "<td width='280' align='left' valign='top' class='boxerror'>";
        print $this->mensaje;
        print "</td></tr></table>";
    }


}

?>
