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
                INSERT INTO responsavelgeral(usuarioID) SELECT id FROM usuario WHERE login = :login;
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->execute();

            return $this;
        }

        public function listarResponsavelGeral() {
            $query = "
                SELECT rg.id, p.nome, u.login 
                FROM responsavelgeral as rg, participante as p, usuario as u
                WHERE rg.usuarioID = p.usuarioID AND u.id = p.usuarioID;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function deletarResponsavelGeral() {
            $query = "
                DELETE FROM responsavelgeral WHERE id = :id;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $this;
        }
    }

?>