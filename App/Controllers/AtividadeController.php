<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AtividadeController extends Action {
        public function indexAtividade() {
            $listaAtividade = Container::getModel('Atividade');
            $eventoID = base64_decode($_GET['id']);
            echo $eventoID . "<br>";
            $listaAtividade->__set('eventoID', $eventoID);
            $this->view->atividades = $listaAtividade->listarAtividades();

            $this->render('indexAtividade');
        }

        public function criarAtividade() {
            $responsavelAtividade = Container::getModel('responsavelAtividade');
            $this->view->responsavel_atividade = $responsavelAtividade->listarResponsavelAtividade();

            $this->render('criarAtividade');
        }

        public function cadastrarAtividade() {
            $atividade = Container::getModel('Atividade');
            //$atividade->__set('eventoID', $_GET['id']);
            $atividade->__set('tema', $_POST['tema']);
            $atividade->__set('tipo', $_POST['tipo']);
            $atividade->__set('vagasMinimas', $_POST['vagasMinimas']);
            $atividade->__set('vagasMaximas', $_POST['vagasMaximas']);
            $atividade->__set('respAtividadeID', $_POST['responsavelAtividade']);
            $atividade->__set('data', $_POST['data']);
            $atividade->__set('hora', $_POST['hora']);
            $atividade->__set('duracao', $_POST['duracao']);
            $atividade->__set('local', $_POST['local']);
            $atividade->__set('pontosPex', $_POST['pontosPex']);
            $atividade->__set('palestrante', $_POST['palestrante']);
            $atividade->__set('descricao', $_POST['descricao']);

            $atividade->adicionarAtividade();

            header('location: /index_atividade');
        }

        public function acaoAtividade() {

            if(isset($_POST['excluir'])) {
                $excluir = Container::getModel('Atividade');
                $excluir->__set('id', $_POST['excluir']);

                $excluir->deletarAtividade();
                header('Location: /index_atividade');
            }

            if(isset($_POST['cancelar'])) {
                print_r($_POST['cancelar']);
            }

            if(isset($_POST['alterar'])) {
                print_r($_POST['alterar']);
                $id = $_POST['alterar'];
                header('Location: /alterar_atividade?id=' . base64_encode($id));
            }

            if(isset($_POST['participantes'])) {
                print_r($_POST['participantes']);
            }
            
            if(isset($_POST['definirOrganizacao'])) {
                print_r($_POST['definirOrganizacao']);
            }
                       
        }

        public function alterarAtividade() {
            // $listaAtividade = Container::getModel('Atividade');
            // $eventoID = base64_decode($_GET['id']);

            $this->render('alterarAtividade');
        }

        public function responsavelAtividade() {
            $this->view->responsavelAtividade = [
                'login' => ''
            ];

            $responsavelAtividade = Container::getModel('responsavelAtividade');
            $this->view->responsavel_atividade = $responsavelAtividade->listarResponsavelAtividade();

            $this->render('responsavelAtividade');
        }

        public function cadastrarResponsavelAtividade() {
            $responsavelAtividade = Container::getModel('ResponsavelAtividade');
            $responsavelAtividade->__set('login', $_POST['login']);

            $responsavelAtividade->criarResponsavelAtividade();
            header('Location: /index_atividade');
        }

        public function removerResponsavelAtividade() {
            $responsavelAtividade = Container::getModel('ResponsavelAtividade');
            $responsavelAtividade->__set('id', $_POST['remover']);
            
            $responsavelAtividade->deletarResponsavelAtividade();
            print_r($_POST);
            //header('Location: /index_atividade');
        }
    }

?>