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
                SELECT DISTINCT p.nome, u.login, p.curso, p.matricula, ia.usuarioID, ia.atividadeID 
                FROM participante as p, usuario as u, inscricaoatividade as ia, atividade as a
                WHERE p.usuarioID = u.id AND ia.usuarioID = u.id AND ia.atividadeID = a.id AND ia.atividadeID = :id;
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function adicionarInscricao() {
            $query = "
                INSERT INTO inscricaoatividade(usuarioID, atividadeID) 
                SELECT u.id, a.id
                FROM usuario as u, atividade as a
                WHERE u.login = :login AND a.id = :atividadeID;
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->bindValue(':atividadeID', $this->__get('atividadeID'));
            $stmt->execute();

            return $this;
        }

        public function removerInscricao() {
            $query = "
                DELETE FROM inscricaoatividade 
                WHERE usuarioID = (
                    SELECT id FROM usuario WHERE login = :login
                );
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->execute();

            return true;
        }

        public function getTituloAtividade() {
            $query = "
                SELECT DISTINCT a.tema 
                FROM atividade as a
                WHERE a.id = :id;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

    }

?>