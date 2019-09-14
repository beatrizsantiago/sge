<?php

    namespace App\Models;

    use MF\Model\Model;

    class InscricaoAtividade extends Model {
        private $usuarioID;
        private $atividadeID;
        private $presente = 0;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function inscreverAtividade() {
            $query = "
                INSERT INTO inscricaoatividade(usuarioID, atividadeID, presente) 
                VALUES (:usuarioID, :atividadeID, :presente);
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':usuarioID', $this->__get('usuarioID'));
            $stmt->bindValue(':atividadeID', $this->__get('atividadeID'));
            $stmt->bindValue(':presente', $this->__get('presente'));
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
                SELECT DISTINCT p.nome, u.login, p.curso, p.matricula, ia.usuarioID, ia.atividadeID, ia.presente 
                FROM participante as p, usuario as u, inscricaoatividade as ia, atividade as a
                WHERE p.usuarioID = u.id AND ia.usuarioID = u.id AND ia.atividadeID = a.id AND ia.atividadeID = :id
                ORDER BY p.nome ASC;
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function adicionarInscricao() {
            $query = "
                INSERT INTO inscricaoatividade(usuarioID, atividadeID, presente) 
                VALUES (
                    ( SELECT u.id FROM usuario as u WHERE u.login = :login ),
                    ( SELECT a.id FROM atividade as a WHERE a.id = :atividadeID ),
                    0
                )
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
                )
                    AND atividadeID = :atividadeID;
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->bindValue(':atividadeID', $this->__get('atividadeID'));
            $stmt->execute();

            return true;
        }

        public function confirmarInscricao() {
            $query = "
                UPDATE inscricaoatividade 
                SET presente = 1
                WHERE usuarioID = (
                    SELECT id FROM usuario WHERE login = :login
                )
                    AND atividadeID = :atividadeID;
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->bindValue(':atividadeID', $this->__get('atividadeID'));
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