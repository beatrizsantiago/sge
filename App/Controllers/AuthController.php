<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AuthController extends Action {
        public function autenticar() {
            $usuario = Container::getModel('Usuario');
            $usuario->__set('login', $_POST['login']);
            $usuario->__set('senha', md5($_POST['senha']));

            $usuario->autenticar();
            $administradorID = $usuario->getAdministradorId();

            if($usuario->__get('id') != '' && $usuario->__get('login')) {
                session_start();
                $_SESSION['id'] = $usuario->__get('id');
                $_SESSION['login'] = $usuario->__get('login');
                $_SESSION['tipoUsuario'] = $usuario->__get('tipoUsuario');
                
                if($administradorID != '') {
                    $_SESSION['administradorID'] = $administradorID[0]['id'];
                }

                switch ($_SESSION['tipoUsuario']) {
                    case 'Administrador': header('Location: /index_evento?dXNlcklE=' .  base64_encode($_SESSION['administradorID']));
                    break;

                    default: header('Location: /index_participante');
                    break;
                }
                
            } else {
                header('location: /?login=erro');
            }
        }

        public function sair() {
            session_start();
            session_destroy();
            header('Location: /');
        }
    }

?>