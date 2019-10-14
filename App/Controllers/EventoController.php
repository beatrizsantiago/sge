<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class EventoController extends Action {
        public function indexEvento() {
            $listaEvento = Container::getModel('Evento');
            if(isset($_GET['dXNlcklE'])) {
                $listaEvento->__set('respGeralID', base64_decode($_GET['dXNlcklE']));
            }
            $this->view->eventos = $listaEvento->listarEventos();
            $this->view->erroCadastroEvendo = false;

            $this->render('indexEvento');
        }

        public function criarEvento() {
            $responsavelGeral = Container::getModel('ResponsavelGeral');
            $this->view->responsavel_geral = $responsavelGeral->listarResponsavelGeral();

            $this->view->evento = [
                'titulo' => '',
                'local' => '',
                'dataInicio' => '',
                'dataFim' => '',
                'descricao' => '',
            ];

            $this->view->erroEvento = false;
            $this->view->erroTitulo = false;
            $this->view->erroLocal = false;
            $this->view->erroResponsavelGeral = false;
            $this->view->erroDataInicio = false;
            $this->view->erroDataFim = false;

            $this->render('criarEvento');
        }

        public function cadastrarEvento() {

            $uploaddir = './assets/img-eventos/';
            $uploadfile = $uploaddir . basename($_FILES['imgEvento']['name']);

            move_uploaded_file($_FILES['imgEvento']['tmp_name'], $uploadfile);

            $caminhoImg = "./assets/img-eventos/" . $_FILES['imgEvento']['name'];
            
            $cadastrarEvento = Container::getModel('Evento');
            $cadastrarEvento->__set('titulo', $_POST['titulo']);
            $cadastrarEvento->__set('local', $_POST['local']);
            if(isset($_GET['dXNlcklE'])) {
                $cadastrarEvento->__set('respGeralID', base64_decode($_GET['dXNlcklE']));
            } else {
                $cadastrarEvento->__set('respGeralID', $_POST['responsavelGeral']);
            }
            $cadastrarEvento->__set('dataInicio', $_POST['dataInicio']);
            $cadastrarEvento->__set('dataFim', $_POST['dataFim']);
            $cadastrarEvento->__set('descricao', $_POST['descricao']);
            $cadastrarEvento->__set('imgEvento', $caminhoImg);

            if ($_POST['titulo'] == '' || strlen($_POST['titulo']) < 3) {
                $this->view->evento = [
                    'titulo' => $_POST['titulo'],
                    'local' => $_POST['local'],
                    // 'responsavelGeral' => $_POST['responsavelGeral'],
                    'dataInicio' => $_POST['dataInicio'],
                    'dataFim' => $_POST['dataFim'],
                    'descricao' => $_POST['descricao'],
                ];
                $this->view->erroEvento = true;
                $this->view->erroTitulo = true;
                $this->render('criarEvento');

            } else if ($_POST['local'] == '' || strlen($_POST['local']) < 3) {
                $this->view->evento = [
                    'titulo' => $_POST['titulo'],
                    'local' => $_POST['local'],
                    // 'responsavelGeral' => $_POST['responsavelGeral'],
                    'dataInicio' => $_POST['dataInicio'],
                    'dataFim' => $_POST['dataFim'],
                    'descricao' => $_POST['descricao'],
                ];
                $this->view->erroEvento = true;
                $this->view->erroLocal = true;
                $this->render('criarEvento');

            } else if ($_POST['dataInicio'] == '' || $_POST['dataInicio'] < date("Y-m-d")) {
                $this->view->evento = [
                    'titulo' => $_POST['titulo'],
                    'local' => $_POST['local'],
                    // 'responsavelGeral' => $_POST['responsavelGeral'],
                    'dataInicio' => $_POST['dataInicio'],
                    'dataFim' => $_POST['dataFim'],
                    'descricao' => $_POST['descricao'],
                ];
                $this->view->erroEvento = true;
                $this->view->erroDataInicio = true;
                $this->render('criarEvento');

            } else if ($_POST['dataFim'] == '' || $_POST['dataFim'] > date("Y")+1 . "-" . date("m") . "-" . date("d")) {
                $this->view->evento = [
                    'titulo' => $_POST['titulo'],
                    'local' => $_POST['local'],
                    // 'responsavelGeral' => $_POST['responsavelGeral'],
                    'dataInicio' => $_POST['dataInicio'],
                    'dataFim' => $_POST['dataFim'],
                    'descricao' => $_POST['descricao'],
                ];
                $this->view->erroEvento = true;
                $this->view->erroDataFim = true;
                $this->render('criarEvento');

            } else {
                $cadastrarEvento->adicionarEvento();

                if(isset($_GET['dXNlcklE'])) {
                    header('Location: /index_evento?dXNlcklE=' . $_GET['dXNlcklE']);
                } else {
                    header('Location: /index_evento');
                }
            }

        }

        public function acaoEvento() {

            if(isset($_POST['excluir'])) {
                $excluir = Container::getModel('Evento');
                $excluir->__set('id', $_POST['excluir']);
                $excluir->deletarEvento();
                
                if(isset($_GET['dXNlcklE'])) {
                    header('Location: /index_evento?dXNlcklE=' . $_GET['dXNlcklE']);
                } else {
                    header('Location: /index_evento');
                }
            }
            
            if(isset($_POST['cancelar'])) {
                $cancelarEvento = Container::getModel('Evento');
                $cancelarEvento->__set('id', $_POST['cancelar']);
                $cancelarEvento->cancelarEvento();

                if(isset($_GET['dXNlcklE'])) {
                    header('Location: /index_evento?dXNlcklE=' . $_GET['dXNlcklE']);
                } else {
                    header('Location: /index_evento');
                }
            }

            if(isset($_POST['ativar'])) {
                $ativarEvento = Container::getModel('Evento');
                $ativarEvento->__set('id', $_POST['ativar']);
                $ativarEvento->ativarEvento();

                if(isset($_GET['dXNlcklE'])) {
                    header('Location: /index_evento?dXNlcklE=' . $_GET['dXNlcklE']);
                } else {
                    header('Location: /index_evento');
                }
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
                
                if(isset($_GET['dXNlcklE'])) {
                    header('Location: /index_atividade?dXNlcklE=' . $_GET['dXNlcklE'] . '&idEvt=' . base64_encode($id));
                } else {
                    header('Location: /index_atividade?idEvt=' . base64_encode($id));
                }
            }
                       
        }

        public function atualizarEvento() {
            $atualizarEvento = Container::getModel('Evento');
            $atualizarEvento->__set('id', $_POST['id']);
            $atualizarEvento->__set('titulo', $_POST['titulo']);
            $atualizarEvento->__set('local', $_POST['local']);
            if(isset($_GET['dXNlcklE'])) {
                $atualizarEvento->__set('respGeralID', base64_decode($_GET['dXNlcklE']));
            } else {
                $atualizarEvento->__set('respGeralID', $_POST['responsavelGeral']);
            }
            $atualizarEvento->__set('dataInicio', $_POST['dataInicio']);
            $atualizarEvento->__set('dataFim', $_POST['dataFim']);
            $atualizarEvento->__set('descricao', $_POST['descricao']);

            $atualizarEvento->alterarEvento();

            if(isset($_GET['dXNlcklE'])) {
                header('Location: /index_evento?dXNlcklE=' . $_GET['dXNlcklE']);
            } else {
                header('Location: /index_evento');
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
            header('Location: /responsavel_geral');
        }

        public function removerResponsavelGeral() {
            $responsavelGeral = Container::getModel('ResponsavelGeral');
            $responsavelGeral->__set('id', $_POST['remover']);
            
            $responsavelGeral->deletarResponsavelGeral();
            header('Location: /responsavel_geral');
        }
    }
