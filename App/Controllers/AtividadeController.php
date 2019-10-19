<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AtividadeController extends Action {

        public function indexAtividade() {
            isset($_GET['dXNlcklE']) ? AtividadeController::getPerfil('dXNlcklE') : null;

            $eventoID = base64_decode($_GET['idEvt']);

            $listaAtividade = Container::getModel('Atividade');
            $listaAtividade->__set('eventoID', $eventoID);

            $this->view->atividades = $listaAtividade->listarAtividades();
            $this->view->titulo = $listaAtividade->getTituloEvento();
            $this->render('indexAtividade');
        }

        public function criarAtividade() {
            isset($_GET['dXNlcklE']) ? AtividadeController::getPerfil('dXNlcklE') : null;

            $dadosAtividade = Container::getModel('atividade');

            $this->view->responsavel_atividade = $dadosAtividade->listarDadosResponsavelAtividade();
            $this->view->tipo_atividade = $dadosAtividade->listartipoAtividade();

            $this->view->atividade = [
                'tema' => '',
                'vagasMinimas' => '',
                'vagasMaximas' => '',
                'tipo' => '',
                'responsavelAtividade' => '',
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
            $this->view->erroTipo = false;
            $this->view->erroVagasMinimas = false;
            $this->view->erroVagasMaximas = false;
            $this->view->erroResponsavelAtividade = false;
            $this->view->erroData = false;
            $this->view->erroDataMenor = false;
            $this->view->erroDataMaior = false;
            $this->view->erroHora = false;
            $this->view->erroDuracao = false;
            $this->view->erroLocal = false;
            $this->view->erroPontosPex = false;
            $this->view->erroPalestrante = false;
            $this->view->erroImage = false;

            $this->render('criarAtividade');
        }

        public function cadastrarAtividade() {
            if($_FILES['imgPalestrante']['name']) {
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

                $uploaddir = './assets/img-palestrantes/';
                $uploadfile = basename($_FILES['imgPalestrante']['name']);

                $novoNome = $nomeUnico . strrchr($uploadfile,".");
                $caminhoImg = $uploaddir . $novoNome;

                move_uploaded_file($_FILES['imgPalestrante']['tmp_name'], $caminhoImg);
            } else {
                $caminhoImg = '';
            }

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
                'tipo' => $_POST['tipo'],
                'vagasMinimas' => $_POST['vagasMinimas'],
                'vagasMaximas' => $_POST['vagasMaximas'],
                'responsavelAtividade' => $_POST['responsavelAtividade'],
                'data' => $_POST['data'],
                'hora' => $_POST['hora'],
                'duracao' => $_POST['duracao'],
                'local' => $_POST['local'],
                'pontosPex' => $_POST['pontosPex'],
                'palestrante' => $_POST['palestrante'],
                'descricao' => $_POST['descricao']
            ];

            $datas = Container::getModel('Evento');
            $datas->__set('id', base64_decode($_GET['idEvt']));
            $validationDatas = $datas->getDatas();

            if ($_POST['tema'] == '' || strlen($_POST['tema']) < 3 || $_POST['tipo'] == '' || $_POST['vagasMinimas'] == '' || $_POST['vagasMaximas'] == '' || $_POST['responsavelAtividade'] == '' || $_POST['data'] == '' || $_POST['data'] < $validationDatas[0]['dataInicio'] || $_POST['data'] > $validationDatas[0]['dataFim'] || $_POST['hora'] == '' || $_POST['duracao'] == '' || $_POST['local'] == '' || $_POST['pontosPex'] == '' || $_POST['palestrante'] == '' || $_FILES['imgPalestrante']['size'] > 835584) {

                $this->view->erroAtividade = true;

                ($_POST['tema'] == '' || strlen($_POST['tema']) < 3) ? $this->view->erroTema = true : null;
                ($_POST['tipo'] == '') ? $this->view->erroTipo = true : null;
                ($_POST['vagasMinimas'] == '') ? $this->view->erroVagasMinimas = true : null;
                ($_POST['vagasMaximas'] == '') ? $this->view->erroVagasMaximas = true : null;
                ($_POST['responsavelAtividade'] == '') ? $this->view->erroResponsavelAtividade = true : null;
                ($_POST['data'] == '') ? $this->view->erroData = true : null;
                ($_POST['data'] < $validationDatas[0]['dataInicio']) ? $this->view->erroDataMenor = true : null;
                ($_POST['data'] > $validationDatas[0]['dataFim']) ? $this->view->erroDataMaior = true : null;
                ($_POST['hora'] == '') ? $this->view->erroHora = true : null;
                ($_POST['duracao'] == '') ? $this->view->erroDuracao = true : null;
                ($_POST['local'] == '') ? $this->view->erroLocal = true : null;
                ($_POST['pontosPex'] == '') ? $this->view->erroPontosPex = true : null;
                ($_POST['palestrante'] == '') ? $this->view->erroPalestrante = true : null;
                ($_FILES['imgPalestrante']['size'] > 835584) ? $this->view->erroImage = true : null;

                isset($_GET['dXNlcklE']) ? AtividadeController::getPerfil('dXNlcklE') : null;

                $this->view->responsavel_atividade = $atividade->listarDadosResponsavelAtividade();
                $this->view->tipo_atividade = $atividade->listartipoAtividade();
                $this->render('criarAtividade');
                
            } else {
                $atividade->adicionarAtividade();
                AtividadeController::locationAtividade();
            }
        }

        public function acaoAtividade() {

            if(isset($_POST['excluir'])) {
                $excluir = Container::getModel('Atividade');
                $excluir->__set('id', $_POST['excluir']);
                $excluir->deletarAtividade();

                AtividadeController::locationAtividade();
            }

            if(isset($_POST['cancelar'])) {
                $cancelarAtividade = Container::getModel('Atividade');
                $cancelarAtividade->__set('id', $_POST['cancelar']);
                $cancelarAtividade->cancelarAtividade();

                AtividadeController::locationAtividade();
            }

            if(isset($_POST['ativar'])) {
                $ativarAtividade = Container::getModel('Atividade');
                $ativarAtividade->__set('id', $_POST['ativar']);
                $ativarAtividade->ativarAtividade();

                AtividadeController::locationAtividade();
            }

            if(isset($_POST['alterar'])) {
                isset($_GET['dXNlcklE']) ? AtividadeController::getPerfil('dXNlcklE') : null;

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
            isset($_GET['dXNlcklE']) ? AtividadeController::getPerfil('dXNlcklE') : null;
            isset($_GET['dXNlcklEQXR2']) ? AtividadeController::getPerfil('dXNlcklEQXR2') : null;

            $listarInscritos = Container::getModel('InscricaoAtividade');
            $listarInscritos->__set('id', base64_decode($_GET['idAtv']));

            $this->view->inscritos = $listarInscritos->listarInscritos();
            $this->view->tituloAtividade = $listarInscritos->getTituloAtividade();
            $this->render('listarParticipantes');
        }

        public function cadastrarParticipante() {
            isset($_GET['dXNlcklE']) ? AtividadeController::getPerfil('dXNlcklE') : null;
            isset($_GET['dXNlcklEQXR2']) ? AtividadeController::getPerfil('dXNlcklEQXR2') : null;

            $this->view->participante = [
                'nome' => '',
                'instituicao' => '',
                'curso' => '',
                'matricula' => '',
                'login' => '',
                'senha' => '',
                'confirmarSenha' => ''
            ];

            $this->view->erroCadastro = false;
            $this->view->erroNome = false;
            $this->view->erroInstituicao = false;
            $this->view->erroCurso = false;
            $this->view->erroMatricula = false;
            $this->view->erroEmail = false;
            $this->view->erroEmailRepetido = false;
            $this->view->erroSenha = false;
            $this->view->erroConfirmarSenha = false;

            $this->render('cadastrarParticipante');
        }

        public function inserirParticipante() {
            $participante = Container::getModel('Participante');
            $participante->__set('nome', $_POST['nome']);
            $participante->__set('apelido', explode(" ", $_POST['nome'])[0]);
            $participante->__set('instituicao', $_POST['instituicao']);
            $participante->__set('curso', $_POST['curso']);
            $participante->__set('matricula', $_POST['matricula']);
            $participante->__set('login', $_POST['login']);
            $participante->__set('senha', md5($_POST['senha']));

            $this->view->participante = [
                'nome' => $_POST['nome'],
                'instituicao' => $_POST['instituicao'],
                'curso' => $_POST['curso'],
                'matricula' => $_POST['matricula'],
                'login' => $_POST['login'],
                'senha' => $_POST['senha'],
                'confirmarSenha' => $_POST['confirmarSenha']
            ];

            if ($_POST['nome'] == '' || strlen($_POST['nome']) < 3 || $_POST['instituicao'] == '' || $_POST['curso'] == '' || $_POST['matricula'] == '' || !is_numeric($_POST['matricula']) || $_POST['login'] == '' || count($participante->getUsuarioLogin()) > 0 || $_POST['senha'] == '' || strlen($_POST['senha']) < 6 || $_POST['confirmarSenha'] != $_POST['senha']) {

                $this->view->erroCadastro = true;

                ($_POST['nome'] == '' || strlen($_POST['nome']) < 3) ? $this->view->erroNome = true : null;
                ($_POST['instituicao'] == '') ? $this->view->erroInstituicao = true : null;
                ($_POST['curso'] == '') ? $this->view->erroCurso = true : null;
                ($_POST['matricula'] == '' || !is_numeric($_POST['matricula'])) ? $this->view->erroMatricula = true : null;
                ($_POST['login'] == '') ? $this->view->erroEmail = true : null;
                (count($participante->getUsuarioLogin()) > 0) ? $this->view->erroEmailRepetido = true : null;
                ($_POST['senha'] == '' || strlen($_POST['senha']) < 6) ? $this->view->erroSenha = true : null;
                ($_POST['confirmarSenha'] != $_POST['senha']) ? $this->view->erroConfirmarSenha = true : null;

                isset($_GET['dXNlcklE']) ? AtividadeController::getPerfil('dXNlcklE') : null;
                isset($_GET['dXNlcklEQXR2']) ? AtividadeController::getPerfil('dXNlcklEQXR2') : null;
                 
                $this->render('cadastrarParticipante');
            
            } else {
                $participante->criarParticipante();
                if(isset($_GET['dXNlcklEQXR2'])) {
                    header('Location: /cadastrar_participante?dXNlcklEQXR2=' . $_GET['dXNlcklEQXR2'] . '&idEvt=' . $_GET['idEvt'] . '&idAtv=' . $_GET['idAtv']);
                } else {
                    header('Location: /cadastrar_participante?idEvt=' . $_GET['idEvt'] . '&idAtv=' . $_GET['idAtv']);
                }
            }
        }

        public function adicionarParticipante() {
            $adicionar = Container::getModel('InscricaoAtividade');
            $adicionar->__set('login', $_POST['login']);
            $adicionar->__set('atividadeID', base64_decode($_GET['idAtv']));
            $adicionar->adicionarInscricao();

            AtividadeController::locationListarParticipante();
        }

        public function acaoListaParticipante() {
            if(isset($_POST['remover'])) {
                $remover = Container::getModel('InscricaoAtividade');
                $remover->__set('login', $_POST['remover']);
                $remover->__set('atividadeID', base64_decode($_GET['idAtv']));
                $remover->removerInscricao();

                AtividadeController::locationListarParticipante();
            }

            if(isset($_POST['confirmar'])) {
                $confirmar = Container::getModel('InscricaoAtividade');
                $confirmar->__set('login', $_POST['confirmar']);
                $confirmar->__set('atividadeID', base64_decode($_GET['idAtv']));
                $confirmar->confirmarInscricao();

                AtividadeController::locationListarParticipante();
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

            $datas = Container::getModel('Evento');
            $datas->__set('id', base64_decode($_GET['idEvt']));
            $validationDatas = $datas->getDatas();

            if($_POST['tema'] == '' || strlen($_POST['tema']) < 3 || $_POST['tipo'] == '' || $_POST['vagasMinimas'] == '' || $_POST['vagasMaximas'] == '' || $_POST['responsavelAtividade'] == '' || $_POST['data'] == '' || $_POST['data'] < $validationDatas[0]['dataInicio'] || $_POST['data'] > $validationDatas[0]['dataFim'] || $_POST['hora'] == '' || $_POST['duracao'] == '' || $_POST['local'] == '' || $_POST['pontosPex'] == '' || $_POST['palestrante'] == '') {
                isset($_GET['dXNlcklE']) ? AtividadeController::getPerfil('dXNlcklE') : null;

                $this->view->dadosAtividades = $atualizarAtividade->listarDadosAtividade();
                $this->view->dadosResponsavel = $atualizarAtividade->listarDadosResponsavelAtividade();
                $this->view->tipoAtividade = $atualizarAtividade->listarTipoAtividade();
                $this->view->erroAtividade = true;

                $this->render('alterarAtividade');
            } else {
                $atualizarAtividade->alterarAtividade();
                AtividadeController::locationAtividade();
            }
        }

        public function responsavelAtividade() {
            isset($_GET['dXNlcklE']) ? AtividadeController::getPerfil('dXNlcklE') : null;

            $this->view->responsavelAtividade = [
                'login' => ''
            ];

            $this->view->erroEmail = false;
            $this->view->erroEmailCadastrado = false;

            $responsavelAtividade = Container::getModel('responsavelAtividade');

            $this->view->responsavel_atividade = $responsavelAtividade->listarResponsavelAtividade();
            $this->render('responsavelAtividade');
        }

        public function cadastrarResponsavelAtividade() {
            $responsavelAtividade = Container::getModel('ResponsavelAtividade');
            $responsavelAtividade->__set('login', $_POST['login']);

            if(count($responsavelAtividade->getResponsavelAtividadeLogin()) > 0 || $_POST['login'] == '') {
                $this->view->responsavelAtividade = [
                    'login' => $_POST['login']
                ];

                (count($responsavelAtividade->getResponsavelAtividadeLogin()) > 0) ? $this->view->erroEmailCadastrado = true : null;
                ($_POST['login'] == '') ? $this->view->erroEmail = true : null;

                isset($_GET['dXNlcklE']) ? AtividadeController::getPerfil('dXNlcklE') : null;

                $this->view->responsavel_atividade = $responsavelAtividade->listarResponsavelAtividade();
                $this->render('responsavelAtividade');
            } else {
                $responsavelAtividade->criarResponsavelAtividade();
                AtividadeController::locationResponsavelAtividade();
            }
        }

        public function removerResponsavelAtividade() {
            $responsavelAtividade = Container::getModel('ResponsavelAtividade');
            $responsavelAtividade->__set('id', $_POST['remover']);
            $responsavelAtividade->deletarResponsavelAtividade();
            
            AtividadeController::locationResponsavelAtividade();
        }

        // >>>>>>>>>>>>>>>>> FUNÇÕES GERAIS <<<<<<<<<<<<<<<<<<<<

        public function getPerfil($usuario) {
            if($usuario == 'dXNlcklE') {
                $fotoPerfil = Container::getModel('ResponsavelGeral');
                $fotoPerfil->__set('usuarioID', base64_decode($_GET['dXNlcklE']));
                $this->view->fotoPerfil = $fotoPerfil->getImagemPerfil();
            }
            
            if($usuario == 'dXNlcklEQXR2') {
                $fotoPerfil = Container::getModel('ResponsavelAtividade');
                $fotoPerfil->__set('usuarioID', base64_decode($_GET['dXNlcklEQXR2']));
                $this->view->fotoPerfil = $fotoPerfil->getImagemPerfil();
            }
        }

        public function locationAtividade() {
            isset($_GET['dXNlcklE']) ? header('location: /index_atividade?dXNlcklE=' . $_GET['dXNlcklE'] . '&idEvt=' . $_GET['idEvt']) : header('location: /index_atividade?idEvt=' . $_GET['idEvt']);
        }

        public function locationListarParticipante() {
            if(isset($_GET['dXNlcklEQXR2'])) {
                header('Location: /listar_participante?dXNlcklEQXR2=' . $_GET['dXNlcklEQXR2'] . '&idEvt=' . $_GET['idEvt'] . '&idAtv=' . $_GET['idAtv']);
            } else if(isset($_GET['dXNlcklE'])) {
                header('Location: /listar_participante?dXNlcklE=' . $_GET['dXNlcklE'] . '&idEvt=' . $_GET['idEvt'] . '&idAtv=' . $_GET['idAtv']);
            } else {
                header('Location: /listar_participante?idEvt=' . $_GET['idEvt'] . '&idAtv=' . $_GET['idAtv']);
            }
        }

        public function locationResponsavelAtividade() {
            if(isset($_GET['dXNlcklE'])) {
                header('Location: /responsavel_atividade?dXNlcklE=' . $_GET['dXNlcklE'] . '&idEvt=' . $_GET['idEvt']);
            } else {
                header('Location: /responsavel_atividade?idEvt=' . $_GET['idEvt']);
            }
        }
    }

?>