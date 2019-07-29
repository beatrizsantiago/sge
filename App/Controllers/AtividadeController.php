<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AtividadeController extends Action {
        public function indexAtividade() {
            $eventoID = base64_decode($_GET['idEvt']);

            $listaAtividade = Container::getModel('Atividade');
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
                $cancelarAtividade = Container::getModel('Atividade');
                $cancelarAtividade->__set('id', $_POST['cancelar']);
                $cancelarAtividade->cancelarAtividade();

                header('Location: /index_atividade?idEvt=' . $_GET['idEvt']);
            }

            if(isset($_POST['ativar'])) {
                $ativarAtividade = Container::getModel('Atividade');
                $ativarAtividade->__set('id', $_POST['ativar']);
                $ativarAtividade->ativarAtividade();

                header('Location: /index_atividade?idEvt=' . $_GET['idEvt']);
            }

            if(isset($_POST['alterar'])) {
                $listaDadosAtividade = Container::getModel('Atividade');
                $listaDadosAtividade->__set('id', $_POST['alterar']);

                $this->view->dadosAtividades = $listaDadosAtividade->listarDadosAtividade();
                $this->view->dadosResponsavel = $listaDadosAtividade->listarDadosResponsavelAtividade();
                $this->render('alterarAtividade');
            }

            if(isset($_POST['participantes'])) {
                $listarInscritos = Container::getModel('InscricaoAtividade');
                $listarInscritos->__set('id', $_POST['participantes']);

                $this->view->inscritos = $listarInscritos->listarInscritos();
                $this->render('listarParticipantes');
            }
            
            if(isset($_POST['definirOrganizacao'])) {
                print_r($_POST['definirOrganizacao']);
            }
                       
        }

        public function atualizarAtividade() {
            $atualizarAtividade = Container::getModel('Atividade');
            $atualizarAtividade->__set('id', base64_decode($_GET['idAtv']));
            $atualizarAtividade->__set('tema', $_POST['tema']);
            // $atualizarAtividade->__set('tipo', $_POST['tipo']);
            $atualizarAtividade->__set('vagasMinimas', $_POST['vagasMinimas']);
            $atualizarAtividade->__set('vagasMaximas', $_POST['vagasMaximas']);
            $atualizarAtividade->__set('respAtividadeID', $_POST['responsavelAtividade']);
            $atualizarAtividade->__set('data', $_POST['data']);
            $atualizarAtividade->__set('hora', $_POST['hora']);
            $atualizarAtividade->__set('duracao', $_POST['duracao']);
            $atualizarAtividade->__set('local', $_POST['local']);
            $atualizarAtividade->__set('pontosPex', $_POST['pontosPex']);
            $atualizarAtividade->__set('palestrante', $_POST['palestrante']);
            $atualizarAtividade->__set('descricao', $_POST['descricao']);
            
            $atualizarAtividade->alterarAtividade();

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

            header('Location: /responsavel_atividade');
        }
    }

?>