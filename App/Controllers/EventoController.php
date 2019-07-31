<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class EventoController extends Action {
        public function indexEvento() {
            $listaEvento = Container::getModel('Evento');
            $listaEvento->__set('administradorID', base64_decode($_GET['dXNlcklE']));
            $this->view->eventos = $listaEvento->listarEventosAdm();

            $this->render('indexEvento');
        }

        public function criarEvento() {
            $responsavelGeral = Container::getModel('ResponsavelGeral');
            $this->view->responsavel_geral = $responsavelGeral->listarResponsavelGeral();

            $this->render('criarEvento');
        }

        public function cadastrarEvento() {

            $cadastrarEvento = Container::getModel('Evento');
            echo "<pre>";
            print_r($_POST);
            print_r(base64_decode($_GET['dXNlcklE']));
            echo "</pre>";
            $cadastrarEvento->__set('administradorID', base64_decode($_GET['dXNlcklE']));
            $cadastrarEvento->__set('titulo', $_POST['titulo']);
            $cadastrarEvento->__set('local', $_POST['local']);
            $cadastrarEvento->__set('respGeralID', $_POST['responsavelGeral']);
            $cadastrarEvento->__set('dataInicio', $_POST['dataInicio']);
            $cadastrarEvento->__set('dataFim', $_POST['dataFim']);
            $cadastrarEvento->__set('descricao', $_POST['descricao']);

            $cadastrarEvento->adicionarEvento();

            header('Location: /index_evento?dXNlcklE=' . $_GET['dXNlcklE']);
        }

        public function acaoEvento() {

            if(isset($_POST['excluir'])) {
                $excluir = Container::getModel('Evento');
                $excluir->__set('id', $_POST['excluir']);
                $excluir->deletarEvento();
                
                header('Location: /index_evento?dXNlcklE=' . $_GET['dXNlcklE']);
            }
            
            if(isset($_POST['cancelar'])) {
                $cancelarEvento = Container::getModel('Evento');
                $cancelarEvento->__set('id', $_POST['cancelar']);
                $cancelarEvento->cancelarEvento();

                header('Location: /index_evento?dXNlcklE=' . $_GET['dXNlcklE']);
            }

            if(isset($_POST['ativar'])) {
                $ativarEvento = Container::getModel('Evento');
                $ativarEvento->__set('id', $_POST['ativar']);
                $ativarEvento->ativarEvento();

                header('Location: /index_evento?dXNlcklE=' . $_GET['dXNlcklE']);
            }

            if(isset($_POST['alterar'])) {
                $listaDadosEvento = Container::getModel('Evento');
                $listaDadosEvento->__set('id', $_POST['alterar']);

                $this->view->dadosEventos = $listaDadosEvento->listarDadosEvento();
                $this->view->dadosResponsavel = $listaDadosEvento->listarDadosResponsavelGeral();
                $this->render('alterarEvento');
            }

            if(isset($_POST['atividades'])) {
                $id = $_POST['atividades'];
                header('Location: /index_atividade?idEvt=' . base64_encode($id));
            }
                       
        }

        public function atualizarEvento() {
            $atualizarEvento = Container::getModel('Evento');
            $atualizarEvento->__set('id', $_POST['id']);
            $atualizarEvento->__set('titulo', $_POST['titulo']);
            $atualizarEvento->__set('local', $_POST['local']);
            $atualizarEvento->__set('respGeralID', $_POST['responsavelGeral']);
            $atualizarEvento->__set('dataInicio', $_POST['dataInicio']);
            $atualizarEvento->__set('dataFim', $_POST['dataFim']);
            $atualizarEvento->__set('descricao', $_POST['descricao']);

            $atualizarEvento->alterarEvento();

            header('Location: /index_evento?dXNlcklE=' . $_GET['dXNlcklE']);
        }

        public function responsavelGeral() {
            $this->view->responsavelGeral = [
                'login' => ''
            ];

            $responsavelGeral = Container::getModel('responsavelGeral');
            $this->view->responsavel_geral = $responsavelGeral->listarResponsavelGeral();
            
            $this->render('responsavelGeral');
        }

        public function cadastrarResponsavelGeral() {
            $responsavelGeral = Container::getModel('ResponsavelGeral');
            $responsavelGeral->__set('login', $_POST['login']);

            $responsavelGeral->criarResponsavelGeral();
            header('Location: /responsavel_geral');
        }

        public function removerResponsavelGeral() {
            $responsavelGeral = Container::getModel('ResponsavelGeral');
            $responsavelGeral->__set('id', $_POST['remover']);
            
            $responsavelGeral->deletarResponsavelGeral();
            header('Location: /responsavel_geral');
        }
    }

?>