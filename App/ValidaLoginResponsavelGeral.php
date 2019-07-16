<?php

session_start();
  
  if(!isset($_SESSION['id']) || $_SESSION['id'] == '') {
    header('Location: /?login=erro');
  }

  if(
    $_SESSION['tipoUsuario'] == 'Participante' || 
    $_SESSION['tipoUsuario'] == 'ResponsavelAtividade' || 
    $_SESSION['tipoUsuario'] == 'Organizador' || 
    $_SESSION['tipoUsuario'] == '' || 
    !$_SESSION['tipoUsuario']
  ) {
    session_start();
    session_destroy();
    header('Location: /?auth=usuarioinvalido');
}

?>