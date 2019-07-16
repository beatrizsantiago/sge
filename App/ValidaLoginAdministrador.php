<?php

session_start();
  
  if(!isset($_SESSION['id']) || $_SESSION['id'] == '') {
    header('Location: /?login=erro');
  }

  if($_SESSION['tipoUsuario'] != 'Administrador') {
    session_start();
    session_destroy();
    header('Location: /?auth=usuarioinvalido');
  }

?>