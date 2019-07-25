<?php

    namespace App\Models;

    use MF\Model\Model;

    class Atividade extends Model {
        private $id;
        private $eventoID;
        private $tema;
        private $tipo;
        private $vagasMinimas;
        private $vagasMaximas;
        private $respAtividadeID;
        private $data;
        private $hora;
        private $duracao;
        private $local;
        private $pontosPex;
        private $palestrante;
        private $cancelada = 0;
        private $descricao;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function adicionarAtividade() {
            $query = "
                INSERT INTO atividade(eventoID, tema, tipo, vagasMinimas, vagasMaximas, respAtividadeID, data, hora, duracao, local, pontosPex, palestrante, cancelada, descricao) 
                VALUES (:eventoID, :tema, :tipo, :vagasMinimas, :vagasMaximas, :respAtividadeID, :data, :hora, :duracao, :local, :pontosPex, :palestrante, :cancelada, :descricao)
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':eventoID', $this->__get('eventoID'));
            $stmt->bindValue(':tema', $this->__get('tema'));
            $stmt->bindValue(':tipo', $this->__get('tipo'));
            $stmt->bindValue(':vagasMinimas', $this->__get('vagasMinimas'));
            $stmt->bindValue(':vagasMaximas', $this->__get('vagasMaximas'));
            $stmt->bindValue(':respAtividadeID', $this->__get('respAtividadeID'));
            $stmt->bindValue(':data', $this->__get('data'));
            $stmt->bindValue(':hora', $this->__get('hora'));
            $stmt->bindValue(':duracao', $this->__get('duracao'));
            $stmt->bindValue(':local', $this->__get('local'));
            $stmt->bindValue(':pontosPex', $this->__get('pontosPex'));
            $stmt->bindValue(':palestrante', $this->__get('palestrante'));
            $stmt->bindValue(':cancelada', $this->__get('cancelada'));
            $stmt->bindValue(':descricao', $this->__get('descricao'));
            $stmt->execute();

            return $this;
        }

        public function listarAtividades() {
            $query = "
                SELECT a.id, a.eventoID, a.tema, a.tipo, a.vagasMinimas, a.vagasMaximas, DATE_FORMAT(a.data, '%d/%m/%Y') as data, TIME_FORMAT(a.hora, '%h:%i') as hora, TIME_FORMAT(a.duracao, '%h:%i') as duracao, a.local, a.pontosPex, a.palestrante, a.descricao, p.nome 
                FROM atividade as a, participante as p, responsavelatividade as ra 
                WHERE a.eventoID = :eventoID AND p.usuarioID = ra.usuarioID AND a.respAtividadeID = ra.id 
                ORDER BY a.data;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':eventoID', $this->__get('eventoID'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function listarDadosAtividade() {
            $query = "
                SELECT a.id, a.eventoID, a.tema, a.tipo, a.vagasMinimas, a.vagasMaximas, a.data, a.hora, a.duracao, a.local, a.pontosPex, a.palestrante, a.descricao, a.respAtividadeID, p.nome 
                FROM atividade as a, participante as p, responsavelatividade as ra 
                WHERE a.id = :id AND p.usuarioID = ra.usuarioID AND a.respAtividadeID = ra.id
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function listarDadosResponsavelAtividade() {
            $query = "
                SELECT ra.id, p.nome
                FROM responsavelatividade as ra, participante as p
                WHERE ra.usuarioID = p.usuarioID
            ";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function alterarAtividade() {
            $query = "
                UPDATE atividade 
                SET tema = :tema,
                    vagasMinimas = :vagasMinimas, 
                    vagasMaximas = :vagasMaximas, 
                    respAtividadeID = :respAtividadeID,
                    data = :data, 
                    hora = :hora, 
                    duracao = :duracao, 
                    local = :local, 
                    pontosPex = :pontosPex, 
                    palestrante = :palestrante, 
                    descricao = :descricao
                    WHERE id = :id
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':tema', $this->__get('tema'));
            // $stmt->bindValue(':tipo', $this->__get('tipo'));
            $stmt->bindValue(':vagasMinimas', $this->__get('vagasMinimas'));
            $stmt->bindValue(':vagasMaximas', $this->__get('vagasMaximas'));
            $stmt->bindValue(':respAtividadeID', $this->__get('respAtividadeID'));
            $stmt->bindValue(':data', $this->__get('data'));
            $stmt->bindValue(':hora', $this->__get('hora'));
            $stmt->bindValue(':duracao', $this->__get('duracao'));
            $stmt->bindValue(':local', $this->__get('local'));
            $stmt->bindValue(':pontosPex', $this->__get('pontosPex'));
            $stmt->bindValue(':palestrante', $this->__get('palestrante'));
            $stmt->bindValue(':descricao', $this->__get('descricao'));
            $stmt->execute();
            
            return $this;
        }

        public function deletarAtividade() {
            $query = "
                DELETE FROM atividade WHERE id = :id;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return true;
        }

        
        public function getNomeAtividade() {
            $query = '
                SELECT tipo, tema FROM atividade WHERE id = :id;
            ';

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

    }

?>