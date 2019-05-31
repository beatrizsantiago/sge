<?php

    namespace MF\Init;

    abstract class Bootstrap {
        private $routes;

        abstract protected function initRoutes(); //a classe filha é obrigada a implementar

        public function __construct() {
            $this->initRoutes();
            $this->run($this->getUrl());
        }

        public function getRoutes() {
            return $this->routes;
        }

        public function setRoutes(array $routes) {
            $this->routes = $routes;
        }

        protected function run($url) {
            foreach ($this->getRoutes() as $key => $route) { //recupera isoladamente cada um do array de rotas
                if ($url == $route['route']) {
                    //redireciona para o controller referente a rota
                    $class = "App\\Controllers\\".ucfirst($route['controller']); //ucfirst primeiro caractere da string fica em caixa alta

                    $controller = new $class; //instanciando o App\Controllers\ com o controller referente
                    $action = $route['action']; //retorna a action da rota
                    $controller->$action(); //com base no objeto, dispara o método da rota
                }

                /*if($url != $route['route']) {
                    header('location: /');
                }*/
            }
        }

        protected function getUrl() {
            //$_SERVER é um array que retorna todos os detalhes do servidor da aplicação
            //REQUEST_URI recupera o que é passado na url
            //parse_url recupera o path
            //PHP_URL_PATH recupera apenas a string passada pelo path
            return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
        }

    }

?>