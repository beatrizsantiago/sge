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
            $cadastrarEvento->__set('diaInicio', $_POST['diaInicio']);
            $cadastrarEvento->__set('mesInicio', $_POST['mesInicio']);
            $cadastrarEvento->__set('anoInicio', $_POST['anoInicio']);
            $cadastrarEvento->__set('dataFim', $_POST['dataFim']);
            $cadastrarEvento->__set('descricao', $_POST['descricao']);

            $cadastrarEvento->adicionarEvento();

            header('Location: /index_evento');
        }

        public function acaoEvento() {

            if(isset($_POST['cancelar'])) {
                $cancelar = Container::getModel('Evento');
                $cancelar->__set('id', $_POST['cancelar']);

                $cancelar->deletarEvento();
                header('Location: /index_evento');
            }
            if(isset($_POST['alterar'])) {
                print_r($_POST['alterar']);
            }
            if(isset($_POST['atividades'])) {
                //print_r($_POST['atividades']);
                header('Location: /index_atividade');
            }
                       
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
            header('Location: /index_evento');
        }

        public function removerResponsavelGeral() {
            $responsavelGeral = Container::getModel('ResponsavelGeral');
            $responsavelGeral->__set('id', $_POST['remover']);
            
            $responsavelGeral->deletarResponsavelGeral();
            print_r($_POST['remover']);
            //header('Location: /index_evento');
        }
    }

?>