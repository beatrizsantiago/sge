<?php

    namespace App\Models;

    use MF\Model\Model;

    class Usuario extends Model {

        private $id;
        private $login;
        private $senha;
        private $tipoUsuario;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function autenticar() {
            $query = "
                SELECT u.id, u.login, u.tipoUsuario, p.apelido
                FROM usuario as u LEFT JOIN participante as p ON (u.id = p.usuarioID)
                WHERE u.login = :login AND u.senha = :senha
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->execute();

            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

            if($usuario['id'] != '' && $usuario['login'] != '' && $usuario['tipoUsuario'] != '') {
                $this->__set('id', $usuario['id']);
                $this->__set('login', $usuario['login']);
                $this->__set('tipoUsuario', $usuario['tipoUsuario']);
                $this->__set('apelido', $usuario['apelido']);
            }

            return $this;
        }

        public function getUsuarioLogin() {
            $query = "
                SELECT login 
                FROM usuario 
                WHERE login = :login";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getResponsavelGeralId() {
            $query = "
                SELECT rg.id
                FROM responsavelgeral as rg
                WHERE rg.usuarioID = (
                    SELECT u.id 
                    FROM usuario as u 
                    WHERE u.login = :login
                );
            ";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getResponsavelAtividadeId() {
            $query = "
                SELECT ra.id
                FROM responsavelatividade as ra
                WHERE ra.usuarioID = (
                    SELECT u.id 
                    FROM usuario as u 
                    WHERE u.login = :login
                );
            ";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getParticipanteId() {
            $query = "
                SELECT u.id 
                FROM usuario as u 
                WHERE u.login = :login
            ";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

    }
