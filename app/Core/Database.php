<?php
namespace App\Core;
use PDO;
use Exception;

class Database extends PDO {
    public function __construct() {
        if (! $env = parse_ini_file(dirname(__FILE__) ."../.env")) {
            throw new Exception("Unable to open env file.", 500);
        }

        $dns = "mysql:host=" . $env['DB_HOST'] . ";dbname=" . $env['DB_NAME'] . ";charset=utf8";
        
        parent::__construct($dns, $env['DB_USER'], $env['DB_PASSWORD']);
    }
}