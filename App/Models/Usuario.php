<?php

    namespace App\Models;

    use MF\Model\Model;

    class Usuario extends Model {

        private $id;
        private $nome;
        private $apelido;
        private $instituicao;
        private $curso;
        private $imgUser;
        private $login;
        private $senha;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function criarUsuario() {
            $query = "
                insert into usuario(login, senha) values (:login, :senha);
                insert into participante(idUsuario, nome, apelido, instituicao, curso) values (LAST_INSERT_ID(), :nome, :apelido, :instituicao, :curso);
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':apelido', $this->__get('apelido'));
            $stmt->bindValue(':instituicao', $this->__get('instituicao'));
            $stmt->bindValue(':curso', $this->__get('curso'));
            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->execute();

            return $this;
        }

        public function getUsuarioLogin() {
            $query = "select login from usuario where login = :login";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function autenticar() {
            $query = "select id, login from usuario where login = :login and senha = :senha";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->execute();

            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

            if($usuario['id'] != '' && $usuario['login'] != '') {
                $this->__set('id', $usuario['id']);
                $this->__set('login', $usuario['login']);
            }

            return $this;
        }

    }

?>