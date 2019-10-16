<?php

    namespace App\Models;

    use MF\Model\Model;

    class ResponsavelAtividade extends Model {

        private $id;
        private $usuarioId;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function criarResponsavelAtividade() {
            $query = "
                INSERT INTO responsavelatividade(usuarioID) SELECT id FROM usuario WHERE login = :login;
                UPDATE usuario as u SET u.tipoUsuario = 'ResponsavelAtividade' WHERE u.login = :login;
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->execute();

            return $this;
        }

        public function listarResponsavelAtividade() {
            $query = "
                SELECT ra.id, p.nome, p.matricula, u.login 
                FROM responsavelatividade as ra, participante as p, usuario as u
                WHERE ra.usuarioID = p.usuarioID AND u.id = p.usuarioID;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function deletarResponsavelAtividade() {
            $query = "
                UPDATE usuario as u SET u.tipoUsuario = 'Participante' 
                WHERE u.id = (
                    SELECT ra.usuarioID 
                    FROM responsavelatividade as ra 
                    WHERE ra.id = :id
                );
                DELETE FROM responsavelatividade WHERE id = :id;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $this;
        }

        public function getResponsavelAtividadeLogin() {
            $query = "
                SELECT u.login 
                FROM usuario as u, responsavelatividade as ra
                WHERE u.id = ra.usuarioId AND u.login = :login
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

?>