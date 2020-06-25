<?php

try {
    try {
        $db = new PgDb();
    } catch (PDOException $e) {
        PgDb::createDb();
        $db = new PgDb();
        $db->createTables();
    }

    if ($db) {
        $file = (new File('file1.log'))->parseFile(); var_dump($file);
        var_dump($db->insert($file, 'log1'));

        $file = (new File('file2.log'))->parseFile();
        var_dump($db->insert($file, 'log2'));
    }

    echo "Parse complete";
} catch (\PDOException $e) {
    echo $e->getMessage();
}

/**
 * Запись в БД
 */
class PgDb
{
    private $conn;

    public function __construct()
    {
        try {
            $dsn = "pgsql:host=localhost;port=5432;dbname=gpb;user=homestead;password=secret";
            $this->conn = new \PDO($dsn);
        } catch (PDOException $e) {
            throw new $e;
        }
    }

    public function insert(array $data, $tbl)
    {
        // составляем запрос на вставку записи
        $param = array_map(function ($str) {
            return "('" . trim(implode("', '", $str)) . "')";
        }, $data); var_dump($param);
        $sql = "INSERT INTO {$tbl} VALUES " . implode(", ", $param) . ";";
        var_dump($sql);
        return $this->conn->exec($sql);
    }

    public function isTableExists()
    {

    }

    public function createTables()
    {
        $sql = "CREATE TABLE IF NOT EXISTS log1 (
            create_date character varying(200),
            create_time character varying(200),
            ip character varying(200),
            url_from character varying(200),
            url_to character varying(200)
        );";

        $res = $this->conn->exec($sql) !== FALSE;

        $sql = "CREATE TABLE IF NOT EXISTS  log2 (
            ip character varying(200),
            browser character varying(200),
            os character varying(200)
        );";

        return $res && ($this->conn->exec($sql) !== FALSE);
    }

    static public function isDbExists()
    {
        $conn = new \PDO("pgsql:host=localhost;port=5432;dbname=postgres;user=homestead;password=secret");
        $sql = 'SELECT schema_name FROM information_schema.schemata WHERE schema_name = "gpb";';
        return (bool)$conn->query($sql);
    }

    static public function createDb()
    {
        $conn = new \PDO("pgsql:host=localhost;port=5432;dbname=postgres;user=homestead;password=secret");
        if ($conn) {
            $sql = "CREATE DATABASE gpb;";
            return $conn->exec($sql) !== FALSE;
        }
    }
}

/**
 * Парсинг логов
 */
class File
{
    protected $file;

    public function __construct($file)
    {
        $this->file = fopen($file, 'r');
    }

    public function __destruct()
    {
        fclose($this->file);
    }

    public function parseFile()
    {
        $data = [];
        while ($string = fgets($this->file)) {
            // парсим строку по разделителю "|"
            $data[] = explode("|", $string);
        }

        return $data;
    }
}