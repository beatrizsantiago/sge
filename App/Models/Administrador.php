<?php

    namespace App\Models;

    use App\Models\Usuario;

    class Administrador extends Usuario {
        private $id;
        private $usuarioID;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }
    }

?>