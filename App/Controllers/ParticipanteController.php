<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class ParticipanteController extends Action {

        public function cadastroParticipante() {
            $this->view->participante = [
                'nome' => '',
                'instituicao' => '',
                'curso' => '',
                'matricula' => '',
                'login' => '',
                'senha' => '',
                'confirmaSenha' => ''
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

            $this->render('cadastroParticipante');
        }

        public function cadastrar() {

            $uploaddir = './assets/img-user/';
            $uploadfile = $uploaddir . basename($_FILES['imgUser']['name']);

            move_uploaded_file($_FILES['imgUser']['tmp_name'], $uploadfile);

            $caminhoImg = "./assets/img-user/" . $_FILES['imgUser']['name']; 

            $participante = Container::getModel('Participante');
            $participante->__set('nome', $_POST['nome']);
            $participante->__set('apelido', explode(" ", $_POST['nome'])[0]);
            $participante->__set('instituicao', $_POST['instituicao']);
            $participante->__set('curso', $_POST['curso']);
            $participante->__set('matricula', $_POST['matricula']);
            $participante->__set('login', $_POST['login']);
            $participante->__set('senha', md5($_POST['senha']));
            $participante->__set('imgUser', $caminhoImg);

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

                if ($_POST['nome'] == '' || strlen($_POST['nome']) < 3) {
                    $this->view->erroNome = true;
                }
                
                if($_POST['instituicao'] == '') {
                    $this->view->erroInstituicao = true;
                }
                
                if($_POST['curso'] == '') {
                    $this->view->erroCurso = true;
                }
                
                if($_POST['matricula'] == '' || !is_numeric($_POST['matricula'])) {
                    $this->view->erroMatricula = true;
                }
                
                if($_POST['login'] == '') {
                    $this->view->erroEmail = true;
                }
                
                if(count($participante->getUsuarioLogin()) > 0) {
                    $this->view->erroEmailRepetido = true;
                }
                
                if($_POST['senha'] == '' || strlen($_POST['senha']) < 6) {
                    $this->view->erroSenha = true;
                }
                
                if($_POST['confirmarSenha'] != $_POST['senha']) {
                    $this->view->erroConfirmarSenha = true;
                }
                 
                $this->render('cadastroParticipante');
            
            } else {
                $participante->criarParticipante();
                $this->render('sucessoCadastro');
            }
        }

        public function indexParticipante() {
            $listaEvento = Container::getModel('Evento');
            $listaEvento->__set('usuarioID', base64_decode($_GET['cGFydGljaXBhbnRl']));
            $this->view->eventos = $listaEvento->listarEventosParticipante();

            $this->render('indexParticipante');
        }

        public function acaoParticipanteEvento() {

            if(isset($_POST['visualizarAtividades'])) {
                $id = $_POST['visualizarAtividades'];
                $usuarioID = $_GET['cGFydGljaXBhbnRl'];
                header('Location: /atividades_evento?cGFydGljaXBhbnRl=' . $usuarioID . '&idEvt=' . base64_encode($id));
            }

            if(isset($_POST['inscreverEvento'])) {
                $eventoID = $_POST['inscreverEvento'];
                $usuarioID = $_GET['cGFydGljaXBhbnRl'];

                $inscricaoEvento = Container::getModel('InscricaoEvento');
                $inscricaoEvento->__set('eventoID', $eventoID);
                $inscricaoEvento->__set('usuarioID', base64_decode($usuarioID));
                $inscricaoEvento->inscreverEvento();

                header('Location: /index_participante?cGFydGljaXBhbnRl=' . $usuarioID);
            }

            if(isset($_POST['cancelarInscricaoEvento'])) {
                $eventoID = $_POST['cancelarInscricaoEvento'];
                $usuarioID = $_GET['cGFydGljaXBhbnRl'];

                $inscricaoEvento = Container::getModel('InscricaoEvento');
                $inscricaoEvento->__set('eventoID', $eventoID);
                $inscricaoEvento->__set('usuarioID', base64_decode($usuarioID));
                $inscricaoEvento->cancelarInscricaoEvento();

                header('Location: /index_participante?cGFydGljaXBhbnRl=' . $usuarioID);
            }
        }

        public function gerenciarAtividades() {
            $gerenciarAtividades = Container::getModel('Atividade');
            $gerenciarAtividades->__set('respAtividadeID', base64_decode($_GET['dXNlcklEQXR2']));
            $this->view->atividades = $gerenciarAtividades->gerenciaAtividades();

            $this->render('gerenciarAtividades');
        }

        public function atividadesEvento() {
            $listaAtividade = Container::getModel('Atividade');
            $usuarioID = base64_decode($_GET['cGFydGljaXBhbnRl']);
            $eventoID = base64_decode($_GET['idEvt']);
            $listaAtividade->__set('usuarioID', $usuarioID);
            $listaAtividade->__set('eventoID', $eventoID);
            $this->view->titulo = $listaAtividade->getTituloEvento();
            $this->view->atividades = $listaAtividade->listarAtividadesParticipante();

            $this->render('atividadesEvento');
        }

        public function acaoParticipanteAtividade() {
            if(isset($_POST['inscreverAtividade'])) {
                $atividadeID = $_POST['inscreverAtividade'];
                $usuarioID = $_GET['cGFydGljaXBhbnRl'];

                $inscricaoAtividade = Container::getModel('InscricaoAtividade');
                $inscricaoAtividade->__set('atividadeID', $atividadeID);
                $inscricaoAtividade->__set('usuarioID', base64_decode($usuarioID));
                $inscricaoAtividade->inscreverAtividade();

                header('Location: /atividades_evento?cGFydGljaXBhbnRl=' . $usuarioID . '&idEvt=' . $_GET['idEvt']);
            }

            if(isset($_POST['cancelarInscricaoAtividade'])) {
                $atividadeID = $_POST['cancelarInscricaoAtividade'];
                $usuarioID = $_GET['cGFydGljaXBhbnRl'];

                $inscricaoAtividade = Container::getModel('InscricaoAtividade');
                $inscricaoAtividade->__set('atividadeID', $atividadeID);
                $inscricaoAtividade->__set('usuarioID', base64_decode($usuarioID));
                $inscricaoAtividade->cancelarInscricaoAtividade();

                header('Location: /atividades_evento?cGFydGljaXBhbnRl=' . $usuarioID . '&idEvt=' . $_GET['idEvt']);
            }
        }

        public function gerarCertificado() {
            $gerarCertificado = Container::getModel('Participante');
            $gerarCertificado->__set('eventoID', base64_decode($_GET['idEvt']));
            $gerarCertificado->__set('usuarioID', base64_decode($_GET['cGFydGljaXBhbnRl']));
            $this->view->somatorio = $gerarCertificado->somatorioPex();
            $this->view->relatorio = $gerarCertificado->relatorioParticipacao();

            $this->render('gerarCertificado');
        }
    }

?>