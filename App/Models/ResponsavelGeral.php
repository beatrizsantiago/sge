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
                UPDATE usuario as u SET u.tipoUsuario = 'ResponsavelGeral' WHERE u.login = :login;
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->execute();

            return $this;
        }

        public function listarResponsavelGeral() {
            $query = "
                SELECT rg.id, p.nome, p.matricula, u.login 
                FROM responsavelgeral as rg, participante as p, usuario as u
                WHERE rg.usuarioID = p.usuarioID AND u.id = p.usuarioID;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function deletarResponsavelGeral() {
            $query = "
                UPDATE usuario as u SET u.tipoUsuario = 'Participante' 
                WHERE u.id = (
                    SELECT rg.usuarioID 
                    FROM responsavelgeral as rg 
                    WHERE rg.id = :id
                );
                DELETE FROM responsavelgeral WHERE id = :id;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $this;
        }

        public function getResponsavelGeralLogin() {
            $query = "
                SELECT u.login 
                FROM usuario as u, responsavelgeral as rg
                WHERE u.id = rg.usuarioID AND u.login = :login
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getImagemPerfil() {
            $query = "
                SELECT p.imgUser
                FROM participante as p 
                    LEFT JOIN responsavelgeral as rg ON (rg.usuarioID = p.usuarioID)
                WHERE rg.id = :usuarioID
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':usuarioID', $this->__get('usuarioID'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

?>