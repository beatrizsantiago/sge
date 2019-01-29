<?php

    namespace App\Models;

    use MF\Model\Model;

    class ResponsavelGeral extends Model {

        private $id;
        private $usuarioId;
        private $login;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function criarResponsavelGeral() {
            $query = "  
                insert into responsavelgeral(usuarioID) select id from usuario where login = :login;
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->execute();

            return $this;
        }

        public function listarResponsavelGeral() {
            $query = "
                select rg.id, p.nome, u.login 
                from responsavelgeral as rg, participante as p, usuario as u
                where rg.usuarioID = p.idUsuario and u.id = p.idUsuario;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function deletarResponsavelGeral() {
            $query = "
                delete from responsavelgeral where id = :id;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $this;
        }
    }

?>