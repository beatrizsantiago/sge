<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class EventoController extends Action {
        public function indexEvento() {
            $listaEvento = Container::getModel('Evento');
            $this->view->eventos = $listaEvento->listarEventos();

            $this->render('indexEvento');
        }

        public function criarEvento() {
            $responsavelGeral = Container::getModel('ResponsavelGeral');
            $this->view->responsavel_geral = $responsavelGeral->listarResponsavelGeral();

            $this->render('criarEvento');
        }

        public function cadastrarEvento() {

            $cadastrarEvento = Container::getModel('Evento');
            $cadastrarEvento->__set('titulo', $_POST['titulo']);
            $cadastrarEvento->__set('local', $_POST['local']);
            $cadastrarEvento->__set('respGeralID', $_POST['responsavelGeral']);
            $cadastrarEvento->__set('dataInicio', $_POST['dataInicio']);
            $cadastrarEvento->__set('dataFim', $_POST['dataFim']);
            $cadastrarEvento->__set('descricao', $_POST['descricao']);

            $cadastrarEvento->adicionarEvento();

            header('Location: /index_evento');
        }

        public function acaoEvento() {

            if(isset($_POST['excluir'])) {
                $excluir = Container::getModel('Evento');
                $excluir->__set('id', $_POST['excluir']);

                $excluir->deletarEvento();
                header('Location: /index_evento');
            }
            
            if(isset($_POST['cancelar'])) {
                print_r($_POST['cancelar']);
            }

            if(isset($_POST['alterar'])) {
                print_r($_POST['alterar']);
                $id = $_POST['alterar'];
                header('Location: /alterar_evento?idEvt=' . base64_encode($id));
            }

            if(isset($_POST['atividades'])) {
                $id = $_POST['atividades'];
                header('Location: /index_atividade?idEvt=' . base64_encode($id));
            }
                       
        }

        public function alterarEvento() {
            $listaDadosEvento = Container::getModel('Evento');
            $eventoID = base64_decode($_GET['idEvt']);
            echo $eventoID . "<br>";
            $listaDadosEvento->__set('id', $eventoID);
            $this->view->dadosEventos = $listaDadosEvento->listarDadosEvento();

            $this->render('alterarEvento');
        }

        public function atualizarEvento() {
            $atualizarEvento = Container::getModel('Evento');
            $atualizarEvento->__set('id', $_POST['id']);
            $atualizarEvento->__set('titulo', $_POST['titulo']);
            $atualizarEvento->__set('local', $_POST['local']);
            // $atualizarEvento->__set('respGeralID', $_POST['responsavelGeral']);
            $atualizarEvento->__set('dataInicio', $_POST['dataInicio']);
            $atualizarEvento->__set('dataFim', $_POST['dataFim']);
            $atualizarEvento->__set('descricao', $_POST['descricao']);

            $atualizarEvento->alterarEvento();
            echo "<pre>";
            print_r($_POST);
            echo "</pre>";

            // header('Location: /index_evento');
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
            // print_r($_POST['remover']);
            header('Location: /responsavel_geral');
        }
    }

?>