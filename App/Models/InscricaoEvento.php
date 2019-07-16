<?php

    namespace App\Models;

    use MF\Model\Model;

    class InscricaoEvento extends Model {
        private $usuarioID;
        private $eventoID;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function inscreverEvento() {
            $query = "
                INSERT INTO inscricaoevento(usuarioID, eventoID) 
                VALUES (:usuarioID, :eventoID);
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':usuarioID', $this->__get('usuarioID'));
            $stmt->bindValue(':eventoID', $this->__get('eventoID'));
            $stmt->execute();

            return $this;
        }

        public function cancelarInscricaoEvento() {
            $query ="
                DELETE FROM inscricaoevento 
                WHERE usuarioID = :usuarioID AND eventoID = :eventoID;
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':usuarioID', $this->__get('usuarioID'));
            $stmt->bindValue(':eventoID', $this->__get('eventoID'));
            $stmt->execute();

            return true;
        }
    }

?>