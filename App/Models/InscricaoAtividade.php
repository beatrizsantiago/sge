<?php

    namespace App\Models;

    use MF\Model\Model;

    class InscricaoAtividade extends Model {
        private $usuarioID;
        private $atividadeID;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function inscreverAtividade() {
            $query = "
                INSERT INTO inscricaoatividade(usuarioID, atividadeID) 
                VALUES (:usuarioID, :atividadeID);
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':usuarioID', $this->__get('usuarioID'));
            $stmt->bindValue(':atividadeID', $this->__get('atividadeID'));
            $stmt->execute();

            return $this;
        }

        public function cancelarInscricaoAtividade() {
            $query ="
                DELETE FROM inscricaoatividade 
                WHERE usuarioID = :usuarioID AND atividadeID = :atividadeID;
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':usuarioID', $this->__get('usuarioID'));
            $stmt->bindValue(':atividadeID', $this->__get('atividadeID'));
            $stmt->execute();

            return true;
        }

        public function listarInscritos() {
            $query = "
                SELECT p.nome, u.login, p.curso, ia.usuarioID, ia.atividadeID 
                FROM participante as p, usuario as u, inscricaoatividade as ia, atividade as a
                WHERE p.usuarioID = u.id AND ia.usuarioID = u.id AND ia.atividadeID = a.id AND ia.atividadeID = :id;
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

?>