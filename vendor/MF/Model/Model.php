<?php

    namespace MF\Model;

    abstract class Model {
        protected $db; //vai receber a conexão com o banco

        public function __construct(\PDO $db) {
            $this->db = $db;
        }
    }

?>