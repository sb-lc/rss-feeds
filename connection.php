<?php
class Db {

    private static $instance = NULL;

    private static $host = 'localhost';
    private static $dbname = 'testDb';
    private static $dbuser = 'testUser';
    private static $dbpass = 'testPass';

    public static function getInstance() {
        if (!isset(self::$instance)) {
            try{
                $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                self::$instance = new PDO('mysql:host=localhost;dbname='.self::$dbname, self::$dbuser, self::$dbpass, $pdo_options);
                //->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch( Exception $e ){
                die('could not connect to database');
            }
        }
        return self::$instance;
    }
}
