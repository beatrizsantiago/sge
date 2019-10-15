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
            $this->view->titulo = $listaAtividade->getTituloEvento();
            $this->render('indexAtividade');
        }

        public function criarAtividade() {
            $dadosAtividade = Container::getModel('atividade');

            $this->view->responsavel_atividade = $dadosAtividade->listarDadosResponsavelAtividade();
            $this->view->tipo_atividade = $dadosAtividade->listartipoAtividade();

            $this->view->atividade = [
                'tema' => '',
                'vagasMinimas' => '',
                'vagasMaximas' => '',
                'data' => '',
                'hora' => '',
                'duracao' => '',
                'local' => '',
                'pontosPex' => '',
                'palestrante' => '',
                'descricao' => ''
            ];

            $this->view->erroAtividade = false;
            $this->view->erroTema = false;
            $this->view->erroVagasMinimas = false;
            $this->view->erroVagasMaximas = false;
            $this->view->erroData = false;
            $this->view->erroHora = false;
            $this->view->erroDuracao = false;
            $this->view->erroLocal = false;
            $this->view->erroPontosPex = false;
            $this->view->erroPalestrante = false;

            $this->render('criarAtividade');
        }

        public function cadastrarAtividade() {

            // echo "<pre>";
            // print_r($_FILES);
            // echo "</pre>";

            $uploaddir = './assets/img-palestrantes/';
            $uploadfile = $uploaddir . basename($_FILES['imgPalestrante']['name']);

            move_uploaded_file($_FILES['imgPalestrante']['tmp_name'], $uploadfile);

            $caminhoImg = "./assets/img-palestrantes/" . $_FILES['imgPalestrante']['name'];

            $atividade = Container::getModel('Atividade');
            $atividade->__set('eventoID', base64_decode($_GET['idEvt']));
            $atividade->__set('tema', $_POST['tema']);
            $atividade->__set('tipoID', $_POST['tipo']);
            $atividade->__set('vagasMinimas', $_POST['vagasMinimas']);
            $atividade->__set('vagasMaximas', $_POST['vagasMaximas']);
            $atividade->__set('respAtividadeID', $_POST['responsavelAtividade']);
            $atividade->__set('data', $_POST['data']);
            $atividade->__set('hora', $_POST['hora']);
            $atividade->__set('duracao', $_POST['duracao']);
            $atividade->__set('local', $_POST['local']);
            $atividade->__set('pontosPex', $_POST['pontosPex']);
            $atividade->__set('palestrante', $_POST['palestrante']);
            $atividade->__set('imgPalestrante', $caminhoImg);
            $atividade->__set('descricao', $_POST['descricao']);

            $this->view->atividade = [
                'tema' => $_POST['tema'],
                'vagasMinimas' => $_POST['vagasMinimas'],
                'vagasMaximas' => $_POST['vagasMaximas'],
                'data' => $_POST['data'],
                'hora' => $_POST['hora'],
                'duracao' => $_POST['duracao'],
                'local' => $_POST['local'],
                'pontosPex' => $_POST['pontosPex'],
                'palestrante' => $_POST['palestrante'],
                'descricao' => $_POST['descricao']
            ];

            if ($_POST['tema'] == '' || strlen($_POST['tema']) < 3 || $_POST['vagasMinimas'] == '' || $_POST['vagasMaximas'] == '' || $_POST['data'] == '' || $_POST['hora'] == '' || $_POST['duracao'] == '' || $_POST['local'] == '' || $_POST['pontosPex'] == '' || $_POST['palestrante'] == '') {

                $this->view->erroAtividade = true;

                if ($_POST['tema'] == '' || strlen($_POST['tema']) < 3) {
                    $this->view->erroTema = true;
                }

                if ($_POST['vagasMinimas'] == '') {
                    $this->view->erroVagasMinimas = true;
                }
                
                if ($_POST['vagasMaximas'] == '') {
                    $this->view->erroVagasMaximas = true;
                }
                
                if ($_POST['data'] == '') {
                    $this->view->erroData = true;
                }
                
                if ($_POST['hora'] == '') {
                    $this->view->erroHora = true;
                }
                
                if ($_POST['duracao'] == '') {
                    $this->view->erroDuracao = true;
                }
                
                if ($_POST['local'] == '') {
                    $this->view->erroLocal = true;
                }
                
                if ($_POST['pontosPex'] == '') {
                    $this->view->erroPontosPex = true;
                }
                
                if ($_POST['palestrante'] == '') {
                    $this->view->erroPalestrante = true;
                }

                $this->render('criarAtividade');
                
            } else {
                $atividade->adicionarAtividade();
    
                if(isset($_GET['dXNlcklE'])) {
                    header('location: /index_atividade?dXNlcklE=' . $_GET['dXNlcklE'] . '&idEvt=' . $_GET['idEvt']);
                } else {
                    header('location: /index_atividade?idEvt=' . $_GET['idEvt']);
                }
            }
        }

        public function acaoAtividade() {

            if(isset($_POST['excluir'])) {
                $excluir = Container::getModel('Atividade');
                $excluir->__set('id', $_POST['excluir']);
                $excluir->deletarAtividade();

                if(isset($_GET['dXNlcklE'])) {
                    header('location: /index_atividade?dXNlcklE=' . $_GET['dXNlcklE'] . '&idEvt=' . $_GET['idEvt']);
                } else {
                    header('location: /index_atividade?idEvt=' . $_GET['idEvt']);
                }
            }

            if(isset($_POST['cancelar'])) {
                $cancelarAtividade = Container::getModel('Atividade');
                $cancelarAtividade->__set('id', $_POST['cancelar']);
                $cancelarAtividade->cancelarAtividade();

                if(isset($_GET['dXNlcklE'])) {
                    header('location: /index_atividade?dXNlcklE=' . $_GET['dXNlcklE'] . '&idEvt=' . $_GET['idEvt']);
                } else {
                    header('location: /index_atividade?idEvt=' . $_GET['idEvt']);
                }
            }

            if(isset($_POST['ativar'])) {
                $ativarAtividade = Container::getModel('Atividade');
                $ativarAtividade->__set('id', $_POST['ativar']);
                $ativarAtividade->ativarAtividade();

                if(isset($_GET['dXNlcklE'])) {
                    header('location: /index_atividade?dXNlcklE=' . $_GET['dXNlcklE'] . '&idEvt=' . $_GET['idEvt']);
                } else {
                    header('location: /index_atividade?idEvt=' . $_GET['idEvt']);
                }
            }

            if(isset($_POST['alterar'])) {
                $listaDadosAtividade = Container::getModel('Atividade');
                $listaDadosAtividade->__set('id', $_POST['alterar']);

                $this->view->dadosAtividades = $listaDadosAtividade->listarDadosAtividade();
                $this->view->dadosResponsavel = $listaDadosAtividade->listarDadosResponsavelAtividade();
                $this->view->tipoAtividade = $listaDadosAtividade->listarTipoAtividade();
                $this->view->erroAtividade = false;
                
                $this->render('alterarAtividade');
            }

            if(isset($_POST['participantes'])) {
                if(isset($_GET['dXNlcklE'])) {
                    header('Location: /listar_participante?dXNlcklE=' . $_GET['dXNlcklE'] . '&idEvt=' . $_GET['idEvt'] . '&idAtv=' . base64_Encode($_POST['participantes']));
                } else {
                    header('Location: /listar_participante?idEvt=' . $_GET['idEvt'] . '&idAtv=' . base64_Encode($_POST['participantes']));
                }
            }
                       
        }

        public function listarParticipante() {
            $listarInscritos = Container::getModel('InscricaoAtividade');
            $listarInscritos->__set('id', base64_decode($_GET['idAtv']));

            $this->view->inscritos = $listarInscritos->listarInscritos();
            $this->view->tituloAtividade = $listarInscritos->getTituloAtividade();
            $this->render('listarParticipantes');
        }

        public function cadastrarParticipante() {
            $this->view->participante = [
                'nome' => '',
                'instituicao' => '',
                'curso' => '',
                'matricula' => '',
                'login' => '',
                'senha' => ''
            ];
            $this->view->erroCadastro = false;
            $this->render('cadastrarParticipante');
        }

        public function adicionarParticipante() {
            $adicionar = Container::getModel('InscricaoAtividade');
            $adicionar->__set('login', $_POST['login']);
            $adicionar->__set('atividadeID', base64_decode($_GET['idAtv']));
            $adicionar->adicionarInscricao();

            if(isset($_GET['dXNlcklEQXR2'])) {
                header('Location: /listar_participante?dXNlcklEQXR2=' . $_GET['dXNlcklEQXR2'] . '&idEvt=' . $_GET['idEvt'] . '&idAtv=' . $_GET['idAtv']);
            } else if(isset($_GET['dXNlcklE'])) {
                header('Location: /listar_participante?dXNlcklE=' . $_GET['dXNlcklE'] . '&idEvt=' . $_GET['idEvt'] . '&idAtv=' . $_GET['idAtv']);
            } else {
                header('Location: /listar_participante?idEvt=' . $_GET['idEvt'] . '&idAtv=' . $_GET['idAtv']);
            }
        }

        public function acaoListaParticipante() {
            if(isset($_POST['remover'])) {
                $remover = Container::getModel('InscricaoAtividade');
                $remover->__set('login', $_POST['remover']);
                $remover->__set('atividadeID', base64_decode($_GET['idAtv']));
                $remover->removerInscricao();

                if(isset($_GET['dXNlcklEQXR2'])) {
                    header('Location: /listar_participante?dXNlcklEQXR2=' . $_GET['dXNlcklEQXR2'] . '&idEvt=' . $_GET['idEvt'] . '&idAtv=' . $_GET['idAtv']);
                } else if(isset($_GET['dXNlcklE'])) {
                    header('Location: /listar_participante?dXNlcklE=' . $_GET['dXNlcklE'] . '&idEvt=' . $_GET['idEvt'] . '&idAtv=' . $_GET['idAtv']);
                } else {
                    header('Location: /listar_participante?idEvt=' . $_GET['idEvt'] . '&idAtv=' . $_GET['idAtv']);
                }

            }

            if(isset($_POST['confirmar'])) {
                $confirmar = Container::getModel('InscricaoAtividade');
                $confirmar->__set('login', $_POST['confirmar']);
                $confirmar->__set('atividadeID', base64_decode($_GET['idAtv']));
                $confirmar->confirmarInscricao();

                if(isset($_GET['dXNlcklEQXR2'])) {
                    header('Location: /listar_participante?dXNlcklEQXR2=' . $_GET['dXNlcklEQXR2'] . '&idEvt=' . $_GET['idEvt'] . '&idAtv=' . $_GET['idAtv']);
                } else if(isset($_GET['dXNlcklE'])) {
                    header('Location: /listar_participante?dXNlcklE=' . $_GET['dXNlcklE'] . '&idEvt=' . $_GET['idEvt'] . '&idAtv=' . $_GET['idAtv']);
                } else {
                    header('Location: /listar_participante?idEvt=' . $_GET['idEvt'] . '&idAtv=' . $_GET['idAtv']);
                }
            }
        }

        public function atualizarAtividade() {
            $atualizarAtividade = Container::getModel('Atividade');
            $atualizarAtividade->__set('id', base64_decode($_GET['idAtv']));
            $atualizarAtividade->__set('tema', $_POST['tema']);
            $atualizarAtividade->__set('tipoID', $_POST['tipo']);
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

            if($_POST['tema'] == '' || strlen($_POST['tema']) < 3 || $_POST['vagasMinimas'] == '' || $_POST['vagasMaximas'] == '' || $_POST['data'] == '' || $_POST['hora'] == '' || $_POST['duracao'] == '' || $_POST['local'] == '' || $_POST['pontosPex'] == '' || $_POST['palestrante'] == '') {
                $listaDadosAtividade = Container::getModel('Atividade');
                $listaDadosAtividade->__set('id', base64_decode($_GET['idAtv']));

                $this->view->dadosAtividades = $listaDadosAtividade->listarDadosAtividade();
                $this->view->dadosResponsavel = $listaDadosAtividade->listarDadosResponsavelAtividade();
                $this->view->tipoAtividade = $listaDadosAtividade->listarTipoAtividade();
                $this->view->erroAtividade = true;

                $this->render('alterarAtividade');
            } else {
                $atualizarAtividade->alterarAtividade();
                
                if(isset($_GET['dXNlcklE'])) {
                    header('location: /index_atividade?dXNlcklE=' . $_GET['dXNlcklE'] . '&idEvt=' . $_GET['idEvt']);
                } else {
                    header('location: /index_atividade?idEvt=' . $_GET['idEvt']);
                }
            }
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

            if(isset($_GET['dXNlcklE'])) {
                header('Location: /responsavel_atividade?dXNlcklE=' . $_GET['dXNlcklE'] . '&idEvt=' . $_GET['idEvt']);
            } else {
                header('Location: /responsavel_atividade?idEvt=' . $_GET['idEvt']);
            }
        }

        public function removerResponsavelAtividade() {
            $responsavelAtividade = Container::getModel('ResponsavelAtividade');
            $responsavelAtividade->__set('id', $_POST['remover']);
            $responsavelAtividade->deletarResponsavelAtividade();

            if(isset($_GET['dXNlcklE'])) {
                header('Location: /responsavel_atividade?dXNlcklE=' . $_GET['dXNlcklE'] . '&idEvt=' . $_GET['idEvt']);
            } else {
                header('Location: /responsavel_atividade?idEvt=' . $_GET['idEvt']);
            }
        }
    }

?>