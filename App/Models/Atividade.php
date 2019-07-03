<?php

    namespace App\Models;

    use MF\Model\Model;

    class Atividade extends Model {
        private $id;
        private $eventoID = 3;
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
                insert into atividade(eventoID, tema, tipo, vagasminimas, vagasmaximas, respAtividadeID, data, hora, duracao, local, pontospex, palestrante, cancelada, descricao) 
                values (:eventoID, :tema, :tipo, :vagasminimas, :vagasmaximas, :respAtividadeID, :data, :hora, :duracao, :local, :pontospex, :palestrante, :cancelada, :descricao)
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':eventoID', $this->__get('eventoID'));
            $stmt->bindValue(':tema', $this->__get('tema'));
            $stmt->bindValue(':tipo', $this->__get('tipo'));
            $stmt->bindValue(':vagasminimas', $this->__get('vagasMinimas'));
            $stmt->bindValue(':vagasmaximas', $this->__get('vagasMaximas'));
            $stmt->bindValue(':respAtividadeID', $this->__get('respAtividadeID'));
            $stmt->bindValue(':data', $this->__get('data'));
            $stmt->bindValue(':hora', $this->__get('hora'));
            $stmt->bindValue(':duracao', $this->__get('duracao'));
            $stmt->bindValue(':local', $this->__get('local'));
            $stmt->bindValue(':pontospex', $this->__get('pontosPex'));
            $stmt->bindValue(':palestrante', $this->__get('palestrante'));
            $stmt->bindValue(':cancelada', $this->__get('cancelada'));
            $stmt->bindValue(':descricao', $this->__get('descricao'));
            $stmt->execute();

            return $this;
        }

        public function listarAtividades() {
            $query = "
                select a.id, a.eventoID, a.tema, a.tipo, a.vagasminimas, a.vagasmaximas, DATE_FORMAT(a.data, '%d/%m/%Y') as data, TIME_FORMAT(a.hora, '%h:%i') as hora, TIME_FORMAT(a.duracao, '%h:%i') as duracao, a.local, a.pontospex, a.palestrante, a.descricao, p.nome 
                from atividade as a, participante as p, responsavelatividade as ra 
                where p.usuarioID = ra.usuarioID and a.respAtividadeID = ra.id 
                order by a.data;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function deletarAtividade() {
            $query = "
                delete from atividade where id = :id;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return true;
        }
    }

?>