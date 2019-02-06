<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class ParticipanteController extends Action {

        public function cadastroParticipante() {
            $this->view->participante = [
                'nome' => '',
                'instituicao' => '',
                'curso' => '',
                'login' => '',
                'senha' => ''
            ];
            $this->view->erroCadastro = false;
            $this->render('cadastroParticipante');
        }

        public function cadastrar() {

            $participante = Container::getModel('Participante');
            $participante->__set('nome', $_POST['nome']);
            $participante->__set('apelido', explode(" ", $_POST['nome'])[0]);
            $participante->__set('instituicao', $_POST['instituicao']);
            $participante->__set('curso', $_POST['curso']);
            $participante->__set('login', $_POST['login']);
            $participante->__set('senha', md5($_POST['senha']));

            if(count($participante->getUsuarioLogin()) == 0) {
                $participante->criarParticipante();
                $this->render('sucessoCadastro');
            } else {
                $this->view->participante = [
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