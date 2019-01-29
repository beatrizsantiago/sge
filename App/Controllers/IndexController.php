<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class IndexController extends Action {
        public function index() {
            $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
            $this->render('index');
        }

        public function cadastroUsuario() {
            $this->view->usuario = [
                'nome' => '',
                'instituicao' => '',
                'curso' => '',
                'login' => '',
                'senha' => ''
            ];
            $this->view->erroCadastro = false;
            $this->render('cadastroUsuario');
        }

        public function cadastrar() {

            $usuario = Container::getModel('Usuario');
            $usuario->__set('nome', $_POST['nome']);
            $usuario->__set('apelido', explode(" ", $_POST['nome'])[0]);
            $usuario->__set('instituicao', $_POST['instituicao']);
            $usuario->__set('curso', $_POST['curso']);
            $usuario->__set('login', $_POST['login']);
            $usuario->__set('senha', md5($_POST['senha']));

            if(count($usuario->getUsuarioLogin()) == 0) {
                $usuario->criarUsuario();
                $this->render('sucessoCadastro');
            } else {
                $this->view->usuario = [
                    'nome' => $_POST['nome'],
                    'instituicao' => $_POST['instituicao'],
                    'curso' => $_POST['curso'],
                    'login' => $_POST['login'],
                    'senha' => $_POST['senha']
                ];
                $this->view->erroCadastro = true;
            }

        }
    }

?>