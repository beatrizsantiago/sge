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

            $routes['cadastroUsuario'] = [
                'route' => '/cadastro_usuario',
                'controller' => 'IndexController',
                'action' => 'cadastroUsuario'
            ];

            $routes['cadastrar'] = [
                'route' => '/cadastrar',
                'controller' => 'IndexController',
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
                'controller' => 'AdmController',
                'action' => 'indexEvento'
            ];

            $routes['criarEvento'] = [
                'route' => '/criar_evento',
                'controller' => 'AdmController',
                'action' => 'criarEvento'
            ];

            $routes['cadastrarEvento'] = [
                'route' => '/cadastrar_evento',
                'controller' => 'AdmController',
                'action' => 'cadastrarEvento'
            ];

            $routes['acaoEvento'] = [
                'route' => '/acao_evento',
                'controller' => 'AdmController',
                'action' => 'acaoEvento'
            ];
            
            $routes['responsavelGeral'] = [
                'route' => '/responsavel_geral',
                'controller' => 'AdmController',
                'action' => 'responsavelGeral'
            ];

            $routes['cadastrarResponsavelGeral'] = [
                'route' => '/cadastrar_responsavel_geral',
                'controller' => 'AdmController',
                'action' => 'cadastrarResponsavelGeral'
            ];

            $routes['removerResponsavelGeral'] = [
                'route' => '/remover_responsavel_geral',
                'controller' => 'AdmController',
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

            $this->setRoutes($routes);
        }

    }

?>