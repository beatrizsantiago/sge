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

            $this->setRoutes($routes);
        }

    }

?>