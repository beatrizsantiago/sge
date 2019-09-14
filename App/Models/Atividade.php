<?php

    namespace App\Models;

    use MF\Model\Model;

    class Atividade extends Model {
        private $id;
        private $eventoID;
        private $tema;
        private $tipoID;
        private $vagasMinimas;
        private $vagasMaximas;
        private $respAtividadeID;
        private $data;
        private $hora;
        private $duracao;
        private $local;
        private $pontosPex;
        private $palestrante;
        private $imgPalestrante;
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
                INSERT INTO atividade(eventoID, tema, tipoID, vagasMinimas, vagasMaximas, respAtividadeID, data, hora, duracao, local, pontosPex, palestrante, imgPalestrante, cancelada, descricao) 
                VALUES (:eventoID, :tema, :tipoID, :vagasMinimas, :vagasMaximas, :respAtividadeID, :data, :hora, :duracao, :local, :pontosPex, :palestrante, :imgPalestrante, :cancelada, :descricao)
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':eventoID', $this->__get('eventoID'));
            $stmt->bindValue(':tema', $this->__get('tema'));
            $stmt->bindValue(':tipoID', $this->__get('tipoID'));
            $stmt->bindValue(':vagasMinimas', $this->__get('vagasMinimas'));
            $stmt->bindValue(':vagasMaximas', $this->__get('vagasMaximas'));
            $stmt->bindValue(':respAtividadeID', $this->__get('respAtividadeID'));
            $stmt->bindValue(':data', $this->__get('data'));
            $stmt->bindValue(':hora', $this->__get('hora'));
            $stmt->bindValue(':duracao', $this->__get('duracao'));
            $stmt->bindValue(':local', $this->__get('local'));
            $stmt->bindValue(':pontosPex', $this->__get('pontosPex'));
            $stmt->bindValue(':palestrante', $this->__get('palestrante'));
            $stmt->bindValue(':imgPalestrante', $this->__get('imgPalestrante'));
            $stmt->bindValue(':cancelada', $this->__get('cancelada'));
            $stmt->bindValue(':descricao', $this->__get('descricao'));
            $stmt->execute();

            return $this;
        }

        public function getTituloEvento() {
            $query = "
                SELECT DISTINCT e.titulo 
                FROM evento as e 
                WHERE e.id = :eventoID;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':eventoID', $this->__get('eventoID'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function listarAtividades() {

            $query = "
                SELECT a.id, a.eventoID, a.tema, ta.tipo, a.vagasMinimas, a.vagasMaximas, DATE_FORMAT(a.data, '%d/%m/%Y') as data, TIME_FORMAT(a.hora, '%h:%i') as hora, TIME_FORMAT(a.duracao, '%h:%i') as duracao, a.local, a.pontosPex, a.palestrante, a.imgPalestrante, a.cancelada, a.descricao, p.nome, ta.cor, COUNT(ia.usuarioID) as qtdInscritos   
                FROM atividade as a 
                    LEFT JOIN inscricaoatividade as ia ON a.id = ia.atividadeID
                    INNER JOIN responsavelatividade as ra ON a.respAtividadeID = ra.id
                    INNER JOIN participante as p ON p.usuarioID = ra.usuarioID
                    INNER JOIN tipoatividade as ta ON a.tipoID = ta.id
                WHERE a.eventoID = :eventoID 
                GROUP BY ia.atividadeID
                HAVING count(ia.atividadeID) >= 0
                ORDER BY a.data;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':eventoID', $this->__get('eventoID'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function listarAtividadesParticipante() {

            $query = "
                SELECT a.id, a.eventoID, a.tema, ta.tipo, a.vagasMinimas, a.vagasMaximas, a.data, a.hora, a.duracao, a.local, a.pontosPex, a.palestrante, a.imgPalestrante, a.cancelada, a.descricao, p.nome, ta.cor, ia.usuarioID, ia.atividadeID, COUNT(iatv.usuarioID) as qtdInscritos  
                FROM atividade as a 
                    LEFT JOIN (
                        SELECT * FROM inscricaoatividade WHERE usuarioID = :usuarioID
                    ) as ia ON a.id = ia.atividadeID 
                    LEFT JOIN inscricaoatividade as iatv ON a.id = iatv.atividadeID
                    LEFT JOIN responsavelatividade as ra ON a.respAtividadeID = ra.id
                    INNER JOIN participante as p ON p.usuarioID = ra.usuarioID
                    INNER JOIN tipoatividade as ta ON a.tipoID = ta.id
                WHERE a.eventoID = :eventoID  
                GROUP BY iatv.atividadeID
                HAVING count(iatv.atividadeID) >= 0 
                ORDER BY a.data, a.hora;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':usuarioID', $this->__get('usuarioID'));
            $stmt->bindValue(':eventoID', $this->__get('eventoID'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function listarTipoAtividade() {
            $query = "
                SELECT id, tipo 
                FROM tipoatividade
            ";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function listarDadosAtividade() {
            $query = "
                SELECT a.id, a.eventoID, a.tema, a.tipoID, ta.tipo, a.vagasMinimas, a.vagasMaximas, a.data, a.hora, a.duracao, a.local, a.pontosPex, a.palestrante, a.descricao, a.respAtividadeID, p.nome 
                FROM atividade as a, participante as p, responsavelatividade as ra, tipoatividade as ta
                WHERE a.id = :id AND p.usuarioID = ra.usuarioID AND a.respAtividadeID = ra.id AND a.tipoID = ta.id
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
                    tipoID = :tipoID,
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
            $stmt->bindValue(':tipoID', $this->__get('tipoID'));
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

        public function cancelarAtividade() {
            $query = "
                UPDATE atividade 
                SET cancelada = true
                WHERE id = :id
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            
            return $this;
        }

        public function ativarAtividade() {
            $query = "
                UPDATE atividade 
                SET cancelada = false
                WHERE id = :id
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id', $this->__get('id'));
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
                SELECT ta.tipo, a.tema 
                FROM atividade as a, tipoatividade as ta
                WHERE a.id = :id AND a.tipoID = ta.id;
            ';

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function gerenciaAtividades() {
            $query = "
                SELECT a.id, a.eventoID, a.tema, ta.tipo, a.vagasMinimas, a.vagasMaximas, DATE_FORMAT(a.data, '%d/%m/%Y') as data, TIME_FORMAT(a.hora, '%h:%i') as hora, TIME_FORMAT(a.duracao, '%h:%i') as duracao, a.local, a.pontosPex, a.palestrante, a.imgPalestrante, a.cancelada, a.descricao, e.titulo, p.nome, ta.cor, COUNT(ia.usuarioID) as qtdInscritos  
                FROM atividade as a 
                    LEFT JOIN inscricaoatividade as ia ON a.id = ia.atividadeID
                    INNER JOIN evento as e ON a.eventoID = e.id
                    INNER JOIN responsavelatividade as ra ON a.respAtividadeID = ra.id
                    INNER JOIN participante as p ON p.usuarioID = ra.usuarioID
                    INNER JOIN tipoatividade as ta ON a.tipoID = ta.id
                WHERE a.respAtividadeID = :respAtividadeID
                GROUP BY ia.atividadeID
                HAVING count(ia.atividadeID) >= 0
                ORDER BY data;
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':respAtividadeID', $this->__get('respAtividadeID'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function inscritoAtividade() {
            $query = "
                SELECT COUNT(ia.usuarioID)
                FROM inscricaoatividade as ia
                WHERE ia.atividadeID = :atividadeID
            ";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

    }

?>