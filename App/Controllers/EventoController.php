<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class EventoController extends Action {
        public function indexEvento() {
            if(isset($_GET['dXNlcklE'])) {
                $fotoPerfil = Container::getModel('ResponsavelGeral');
                $fotoPerfil->__set('usuarioID', base64_decode($_GET['dXNlcklE']));
                $this->view->fotoPerfil = $fotoPerfil->getImagemPerfil();
            }

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
            if(isset($_GET['dXNlcklE'])) {
                $responsavelGeral->__set('usuarioID', base64_decode($_GET['dXNlcklE']));
                $this->view->fotoPerfil = $responsavelGeral->getImagemPerfil();
            }
            $this->view->responsavel_geral = $responsavelGeral->listarResponsavelGeral();

            $this->view->evento = [
                'titulo' => '',
                'local' => '',
                'dataInicio' => '',
                'dataFim' => '',
                'descricao' => ''
            ];

            $this->view->erroEvento = false;
            $this->view->erroTitulo = false;
            $this->view->erroLocal = false;
            $this->view->erroResponsavelGeral = false;
            $this->view->erroDataInicio = false;
            $this->view->erroDataFim = false;
            $this->view->erroImage = false;

            $this->render('criarEvento');
        }

        public function cadastrarEvento() {
            $alfabeto = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $tamanho = 20;
            $letra = "";
            $resultado = "";

            for ($i = 0; $i < $tamanho; $i++) { 
                $letra = substr($alfabeto, rand(0, 35), 1);
                $resultado .= $letra;
            }

            date_default_timezone_set('America/Sao_Paulo');
            $agora = getDate();

            $codigo_data = $agora['year'] . "_" . $agora['yday'] . $agora['hours'] . $agora['minutes'] . $agora['seconds'];
            $nomeUnico = "foto_" . $codigo_data . "_" . $resultado;

            $uploaddir = './assets/img-eventos/';
            $uploadfile = basename($_FILES['imgEvento']['name']);

            $novoNome = $nomeUnico . strrchr($uploadfile,".");
            $caminhoImg = $uploaddir . $novoNome;

            move_uploaded_file($_FILES['imgEvento']['tmp_name'], $caminhoImg);
            
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

            $this->view->evento = [
                'titulo' => $_POST['titulo'],
                'local' => $_POST['local'],
                'responsavelGeral' => $_POST['responsavelGeral'],
                'dataInicio' => $_POST['dataInicio'],
                'dataFim' => $_POST['dataFim'],
                'descricao' => $_POST['descricao']
            ];

            if($_POST['titulo'] == '' || strlen($_POST['titulo']) < 3 || $_POST['local'] == '' || strlen($_POST['local']) < 3 || $_POST['responsavelGeral'] == '' || $_POST['dataInicio'] == '' || $_POST['dataInicio'] < date("Y-m-d") || $_POST['dataFim'] == '' || $_POST['dataFim'] > date("Y")+1 . "-" . date("m") . "-" . date("d") || $_FILES['imgEvento']['size'] > 15728640) {

                $this->view->erroEvento = true;

                if ($_POST['titulo'] == '' || strlen($_POST['titulo']) < 3) {
                    $this->view->erroTitulo = true;
                }
                
                if ($_POST['local'] == '' || strlen($_POST['local']) < 3) {
                    $this->view->erroLocal = true;
                }
                
                if ($_POST['responsavelGeral'] == '') {
                    $this->view->erroResponsavelGeral = true;
                }
                
                if ($_POST['dataInicio'] == '' || $_POST['dataInicio'] < date("Y-m-d")) {
                    $this->view->erroDataInicio = true;
                }
                
                if ($_POST['dataFim'] == '' || $_POST['dataFim'] > date("Y")+1 . "-" . date("m") . "-" . date("d")) {
                    $this->view->erroDataFim = true;
                }

                if ($_FILES['imgEvento']['size'] > 15728640) {
                    $this->view->erroImage = true;
                }
                
                $responsavelGeral = Container::getModel('ResponsavelGeral');
                $this->view->responsavel_geral = $responsavelGeral->listarResponsavelGeral();
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
                if(isset($_GET['dXNlcklE'])) {
                    $fotoPerfil = Container::getModel('ResponsavelGeral');
                    $fotoPerfil->__set('usuarioID', base64_decode($_GET['dXNlcklE']));
                    $this->view->fotoPerfil = $fotoPerfil->getImagemPerfil();
                }

                $listaDadosEvento = Container::getModel('Evento');
                $listaDadosEvento->__set('id', $_POST['alterar']);

                $this->view->dadosEventos = $listaDadosEvento->listarDadosEvento();
                $this->view->dadosResponsavel = $listaDadosEvento->listarDadosResponsavelGeral();
                $this->view->erroEvento = false;
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

            if($_POST['titulo'] == '' || strlen($_POST['titulo']) < 3 || $_POST['local'] == '' || strlen($_POST['local']) < 3 || $_POST['responsavelGeral'] == '' || $_POST['dataInicio'] == '' || $_POST['dataInicio'] < date("Y-m-d") || $_POST['dataFim'] == '' || $_POST['dataFim'] > date("Y")+1 . "-" . date("m") . "-" . date("d")) {
                $this->view->dadosEventos = $atualizarEvento->listarDadosEvento();
                $this->view->dadosResponsavel = $atualizarEvento->listarDadosResponsavelGeral();
                $this->view->erroEvento = true;

                $this->render('alterarEvento');
            } else {
                $atualizarEvento->alterarEvento();
                
                if(isset($_GET['dXNlcklE'])) {
                    header('Location: /index_evento?dXNlcklE=' . $_GET['dXNlcklE']);
                } else {
                    header('Location: /index_evento');
                }
            }
        }

        public function responsavelGeral() {
            $this->view->responsavelGeral = [
                'login' => ''
            ];

            $this->view->erroEmail = false;
            $this->view->erroEmailCadastrado = false;

            $responsavelGeral = Container::getModel('responsavelGeral');
            $this->view->responsavel_geral = $responsavelGeral->listarResponsavelGeral();
            
            $this->render('responsavelGeral');
        }

        public function cadastrarResponsavelGeral() {
            $responsavelGeral = Container::getModel('ResponsavelGeral');
            $responsavelGeral->__set('login', $_POST['login']);

            if(count($responsavelGeral->getResponsavelGeralLogin()) > 0 || $_POST['login'] == '') {
                $this->view->responsavelGeral = [
                    'login' => $_POST['login']
                ];

                if(count($responsavelGeral->getResponsavelGeralLogin()) > 0) {
                    $this->view->erroEmailCadastrado = true;
                }
                
                if ($_POST['login'] == '') {
                    $this->view->erroEmail = true;
                }

                $this->view->responsavel_geral = $responsavelGeral->listarResponsavelGeral();
                $this->render('responsavelGeral');
            } else {
                $responsavelGeral->criarResponsavelGeral();
                header('Location: /responsavel_geral');
            }

        }

        public function removerResponsavelGeral() {
            $responsavelGeral = Container::getModel('ResponsavelGeral');
            $responsavelGeral->__set('id', $_POST['remover']);
            
            $responsavelGeral->deletarResponsavelGeral();
            header('Location: /responsavel_geral');
        }
    }
