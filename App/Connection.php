<?php

    namespace App;

    class Connection {
        public static function getDb() {
            try {
                $conn = new \PDO(
                    "mysql:host=localhost;dbname=sge;charset=utf8",
                    "root",
                    "1san9ti0a5GO"
                );

                return $conn;
            } catch(\PDOException $e) {
                //.. tratar de alguma forma //
            }
        }
    }

?>