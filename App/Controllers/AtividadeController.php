<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AtividadeController extends Action {
        public function indexAtividade() {
            $listaAtividade = Container::getModel('Atividade');
            $eventoID = base64_decode($_GET['idEvt']);
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
            $atividade->__set('eventoID', base64_decode($_GET['idEvt']));
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

            header('location: /index_atividade?idEvt=' . $_GET['idEvt']);
        }

        public function acaoAtividade() {

            if(isset($_POST['excluir'])) {
                $excluir = Container::getModel('Atividade');
                $excluir->__set('id', $_POST['excluir']);

                $excluir->deletarAtividade();
                header('Location: /index_atividade?idEvt=' . $_GET['idEvt']);
            }

            if(isset($_POST['cancelar'])) {
                print_r($_POST['cancelar']);
            }

            if(isset($_POST['alterar'])) {
                print_r("Id Atividade: " . $_POST['alterar']);
                echo "<br>";
                print_r("Id Evento: " . base64_decode($_GET['idEvt']));
                $eventoID = $_GET['idEvt'];
                $atividadeID = $_POST['alterar'];
                header('Location: /alterar_atividade?idEvt='. $eventoID .'&idAtv=' . base64_encode($atividadeID));
            }

            if(isset($_POST['participantes'])) {
                print_r($_POST['participantes']);
            }
            
            if(isset($_POST['definirOrganizacao'])) {
                print_r($_POST['definirOrganizacao']);
            }
                       
        }

        public function alterarAtividade() {
            $listaDadosAtividade = Container::getModel('Atividade');
            $atividadeID = base64_decode($_GET['idAtv']);
            echo $atividadeID . "<br>";
            $listaDadosAtividade->__set('id', $atividadeID);
            $this->view->dadosAtividades = $listaDadosAtividade->listarDadosAtividade();

            $this->render('alterarAtividade');
        }

        public function atualizarAtividade() {
            echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            $atualizarAtividade = Container::getModel('Atividade');
            $atualizarAtividade->__set('id', base64_decode($_GET['idAtv']));
            $atualizarAtividade->__set('tema', $_POST['tema']);
            // $atualizarAtividade->__set('tipo', $_POST['tipo']);
            $atualizarAtividade->__set('vagasMinimas', $_POST['vagasMinimas']);
            $atualizarAtividade->__set('vagasMaximas', $_POST['vagasMaximas']);
            // $atualizarAtividade->__set('respAtividadeID', $_POST['responsavelAtividade']);
            $atualizarAtividade->__set('data', $_POST['data']);
            $atualizarAtividade->__set('hora', $_POST['hora']);
            $atualizarAtividade->__set('duracao', $_POST['duracao']);
            $atualizarAtividade->__set('local', $_POST['local']);
            $atualizarAtividade->__set('pontosPex', $_POST['pontosPex']);
            $atualizarAtividade->__set('palestrante', $_POST['palestrante']);
            $atualizarAtividade->__set('descricao', $_POST['descricao']);
            
            $atualizarAtividade->alterarAtividade();

            // echo "<pre>";
            // print_r($atualizarAtividade);
            // echo "</pre>";

            header('Location: /index_atividade?idEvt=' . $_GET['idEvt']);
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
            header('Location: /responsavel_atividade');
        }

        public function removerResponsavelAtividade() {
            $responsavelAtividade = Container::getModel('ResponsavelAtividade');
            $responsavelAtividade->__set('id', $_POST['remover']);
            
            $responsavelAtividade->deletarResponsavelAtividade();
            // print_r($_POST);
            header('Location: /responsavel_atividade');
        }
    }

?>