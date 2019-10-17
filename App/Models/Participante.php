<?php

    namespace App\Models;

    use App\Models\Usuario;

    class Participante extends Usuario {

        private $id;
        private $usuarioID;
        private $nome;
        private $apelido;
        private $instituicao;
        private $curso;
        private $imgUser;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function criarParticipante() {
            $query = "
                INSERT INTO usuario(login, senha, tipoUsuario) VALUES (:login, :senha, :tipoUsuario);
                INSERT INTO participante(usuarioID, nome, apelido, instituicao, curso, matricula, imgUser) VALUES (LAST_INSERT_ID(), :nome, :apelido, :instituicao, :curso, :matricula, :imgUser);
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':apelido', $this->__get('apelido'));
            $stmt->bindValue(':instituicao', $this->__get('instituicao'));
            $stmt->bindValue(':curso', $this->__get('curso'));
            $stmt->bindValue(':matricula', $this->__get('matricula'));
            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->bindValue(':tipoUsuario', 'Participante');
            $stmt->bindValue(':imgUser', $this->__get('imgUser'));
            $stmt->execute();

            return $this;
        }

        public function getImagemPerfil() {
            $query = "
                SELECT imgUser
                FROM participante
                WHERE usuarioID = :usuarioID
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':usuarioID', $this->__get('usuarioID'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function relatorioParticipacao() {
            $query = "
                SELECT DISTINCT a.id, a.tema, a.pontosPex, ia.presente
                FROM atividade as a, inscricaoatividade as ia
                WHERE a.id = ia.atividadeID AND a.eventoID = :eventoID AND ia.usuarioID = :usuarioID
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':eventoID', $this->__get('eventoID'));
            $stmt->bindValue(':usuarioID', $this->__get('usuarioID'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function somatorioPex() {
            $query = "
                SELECT DISTINCT SUM(a.pontosPex) as soma 
                FROM atividade as a, inscricaoatividade as ia
                WHERE a.id = ia.atividadeID AND a.eventoID = :eventoID AND ia.usuarioID = :usuarioID
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':eventoID', $this->__get('eventoID'));
            $stmt->bindValue(':usuarioID', $this->__get('usuarioID'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function certificadoAtividade() {
            $query = "
                SELECT a.tema, p.nome
                FROM atividade as a, participante as p
                WHERE a.id = :atividadeID AND p.usuarioID = :usuarioID
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':atividadeID', $this->__get('atividadeID'));
            $stmt->bindValue(':usuarioID', $this->__get('usuarioID'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

    }

?>