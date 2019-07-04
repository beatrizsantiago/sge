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
                INSERT INTO participante(usuarioID, nome, apelido, instituicao, curso) VALUES (LAST_INSERT_ID(), :nome, :apelido, :instituicao, :curso);
            ";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':apelido', $this->__get('apelido'));
            $stmt->bindValue(':instituicao', $this->__get('instituicao'));
            $stmt->bindValue(':curso', $this->__get('curso'));
            $stmt->bindValue(':login', $this->__get('login'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->bindValue(':tipoUsuario', 'Administrador');
            $stmt->execute();

            return $this;
        }

    }

?>