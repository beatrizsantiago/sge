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

        public function criarResponsavelGeral() {
            $query = "
                insert into responsavelatividade(usuarioID) select id from usuario where login = :login;
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->execute();

            return $this;
        }

        public function listarResponsavelAtividade() {
            $query = "
                select ra.id, p.nome, u.login 
                from responsavelatividade as ra, participante as p, usuario as u
                where ra.usuarioID = p.idUsuario and u.id = p.idUsuario;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function deletarResponsavelAtividade() {
            $query = "
                delete from responsavelatividade where id = :id;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $this;
        }
    }

?>