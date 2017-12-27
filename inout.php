<?php
function __autoload($class_name) {
   require_once "class_" . $class_name . '.php';
}
?>