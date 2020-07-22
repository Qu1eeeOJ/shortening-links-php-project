<?php

namespace App\Vendor\DB;

use PDO;

class DB
{

    protected static $pdo = null;
    protected $host, $db, $username, $password, $charset, $opt, $dsn;

    public function __construct()
    {
        $conf = require_once APP . '/config/db.php';

        $this->host = $conf['host'];
        $this->db = $conf['db'];
        $this->username = $conf['username'];
        $this->password = $conf['password'];
        $this->charset = $conf['charset'];
        $this->opt = $conf['opt'];

        $this->dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";

        $this->pdo = new PDO($this->dsn, $this->username, $this->password, $this->opt);
    }

    /**
     * Getting a PDO instance
     *
     * @return PDO
     */
    public static function getInstance()
    {
        if (!self::$pdo) {
            self::$pdo = new self;
        }

        return self::$pdo;
    }

    /**
     * Run a dry query
     *
     * @param string $sql
     * @return $this
     */
    public function query(String $sql): self
    {
        $this->stmt = $this->pdo->query($sql);

        return $this;
    }

    /**
     * Executing a query with variables
     *
     * @param string $sql
     * @param array $param
     * @return $this
     */
    public function queryWithPrepare(String $sql, Array $param): self
    {
        $this->stmt = $this->pdo->prepare($sql);

        $this->execute($param);

        return $this;
    }

    /**
     * Run a query with parameters
     *
     * @param array $param
     * @return void
     */
    private function execute(Array $param): void
    {
        $this->stmt->execute($param);
    }

    /**
     * Fetch Data
     *
     * @return mixed
     */
    public function fetch()
    {
        return $this->stmt->fetch();
    }

    /**
     * Fetch All Data
     *
     * @return mixed
     */
    public function fetchAll()
    {
        return $this->stmt->fetchAll();
    }

}