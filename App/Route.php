<?php

    namespace App;

    use MF\Init\Bootstrap;

    class Route extends Bootstrap {
        
        protected function initRoutes() {
            $routes['index'] = [
                'route' => '/',
                'controller' => 'IndexController',
                'action' => 'index'
            ];

            $routes['cadastroParticipante'] = [
                'route' => '/cadastro_participante',
                'controller' => 'ParticipanteController',
                'action' => 'cadastroParticipante'
            ];

            $routes['cadastrar'] = [
                'route' => '/cadastrar',
                'controller' => 'ParticipanteController',
                'action' => 'cadastrar'
            ];

            $routes['autenticar'] = [
                'route' => '/autenticar',
                'controller' => 'AuthController',
                'action' => 'autenticar'
            ];

            $routes['sair'] = [
                'route' => '/sair',
                'controller' => 'AuthController',
                'action' => 'sair'
            ];

            $routes['indexEvento'] = [
                'route' => '/index_evento',
                'controller' => 'EventoController',
                'action' => 'indexEvento'
            ];

            $routes['criarEvento'] = [
                'route' => '/criar_evento',
                'controller' => 'EventoController',
                'action' => 'criarEvento'
            ];

            $routes['cadastrarEvento'] = [
                'route' => '/cadastrar_evento',
                'controller' => 'EventoController',
                'action' => 'cadastrarEvento'
            ];

            $routes['acaoEvento'] = [
                'route' => '/acao_evento',
                'controller' => 'EventoController',
                'action' => 'acaoEvento'
            ];

            $routes['alterarEvento'] = [
                'route' => '/alterar_evento',
                'controller' => 'EventoController',
                'action' => 'alterarEvento'
            ];

            $routes['atualizarEvento'] = [
                'route' => '/atualizar_evento',
                'controller' => 'EventoController',
                'action' => 'atualizarEvento'
            ];
            
            $routes['responsavelGeral'] = [
                'route' => '/responsavel_geral',
                'controller' => 'EventoController',
                'action' => 'responsavelGeral'
            ];

            $routes['cadastrarResponsavelGeral'] = [
                'route' => '/cadastrar_responsavel_geral',
                'controller' => 'EventoController',
                'action' => 'cadastrarResponsavelGeral'
            ];

            $routes['removerResponsavelGeral'] = [
                'route' => '/remover_responsavel_geral',
                'controller' => 'EventoController',
                'action' => 'removerResponsavelGeral'
            ];

            $routes['indexAtividade'] = [
                'route' => '/index_atividade',
                'controller' => 'AtividadeController',
                'action' => 'indexAtividade'
            ];

            $routes['atividadesEvento'] = [
                'route' => '/atividades_evento',
                'controller' => 'AtividadeController',
                'action' => 'atividadesEvento'
            ];

            $routes['criarAtividade'] = [
                'route' => '/criar_atividade',
                'controller' => 'AtividadeController',
                'action' => 'criarAtividade'
            ];

            $routes['cadastrarAtividade'] = [
                'route' => '/cadastrar_atividade',
                'controller' => 'AtividadeController',
                'action' => 'cadastrarAtividade'
            ];

            $routes['acaoAtividade'] = [
                'route' => '/acao_atividade',
                'controller' => 'AtividadeController',
                'action' => 'acaoAtividade'
            ];

            $routes['alterarAtividade'] = [
                'route' => '/alterar_atividade',
                'controller' => 'AtividadeController',
                'action' => 'alterarAtividade'
            ];

            $routes['atualizarAtividade'] = [
                'route' => '/atualizar_atividade',
                'controller' => 'AtividadeController',
                'action' => 'atualizarAtividade'
            ];

            $routes['responsavelAtividade'] = [
                'route' => '/responsavel_atividade',
                'controller' => 'AtividadeController',
                'action' => 'responsavelAtividade'
            ];

            $routes['cadastrarResponsavelAtividade'] = [
                'route' => '/cadastrar_responsavel_atividade',
                'controller' => 'AtividadeController',
                'action' => 'cadastrarResponsavelAtividade'
            ];

            $routes['removerResponsavelAtividade'] = [
                'route' => '/remover_responsavel_atividade',
                'controller' => 'AtividadeController',
                'action' => 'removerResponsavelAtividade'
            ];

            $routes['indexParticipante'] = [
                'route' => '/index_participante',
                'controller' => 'ParticipanteController',
                'action' => 'indexParticipante'
            ];

            $routes['acaoParticipanteEvento'] = [
                'route' => '/acao_participante_evento',
                'controller' => 'ParticipanteController',
                'action' => 'acaoParticipanteEvento'
            ];

            $routes['atividadesEvento'] = [
                'route' => '/atividades_evento',
                'controller' => 'ParticipanteController',
                'action' => 'atividadesEvento'
            ];

            $routes['acaoParticipanteAtividade'] = [
                'route' => '/acao_participante_atividade',
                'controller' => 'ParticipanteController',
                'action' => 'acaoParticipanteAtividade'
            ];

            $this->setRoutes($routes);
        }

    }

?>