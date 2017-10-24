<?php
    require 'db_config.php';

    function getConn() {
        return new PDO('mysql:host='.DATABASE_HOST.';dbname='.DATABASE_NAME,
                        DATABASE_USER,
                        DATABASE_PWD,
                        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );
    }

?>