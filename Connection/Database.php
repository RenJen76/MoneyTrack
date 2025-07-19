<?php 
    class Database
    {

        public $connection;
        public $tableName;

        public function __construct ()
        {
            $this->connect();
        }

        public function connect()
        {
            try {

                $env = parse_ini_file(__DIR__ . '/../env.ini', true);
                $pdo = new PDO("mysql:host=".$env['database']['host'].";dbname=".$env['database']['database'].";charset=utf8mb4", $env['database']['username'], $env['database']['password']);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection = $pdo;

            } catch (PDOException $pe) {

                die("PDO_ERROR: Could not connect to the database: " . $pe->getMessage());

            }            
        }

        public function query($query)
        {

            $result = array();

            if ($query) {

                try {

                    $statement = $this->connection->query($query);

                } catch (Exception $e) {

                    die("PDO error: " . $e->getMessage() . " Stack trace:" . $e->getTraceAsString());
                 
                }

                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

                    array_push($result, $row);

                }

                return $result;

            }

            return null;

        }

        public function save($condition = array())
        {
            if ($this->tableName && count($condition)>0) {

                $fields = $this->buildFields($condition);

                try {

                    $sql        = "insert into `$this->tableName`($fields[fieldsName]) values ($fields[fieldsValue])";
                    $statement  = $this->connection->prepare($sql);
                    $statement->execute($condition);
                    return $this->lastInsertId();

                } catch (Exception $e) {

                    die("PDO_ERROR: " . $e->getMessage() . " at class: " . get_class($this) . " Stack trace:" . $e->getTraceAsString() . " execute sql:" . $sql);
   
                }
            }

            return null;
        }

        public function buildFields($fields = array())
        {
            if (count($fields)>0) {
                $fields = array_keys($fields);
                return [
                    'fieldsName' => implode(",", $fields),
                    'fieldsValue'=> ':' . implode(", :", $fields)
                ];
            }

            return null;
        }

        public function lastInsertId()
        {
            return $this->connection->lastInsertId();
        } 

        public function execute($sql)
        {
            if (!$sql) {

                return null;
            }

            try {

                return $this->connection->exec($sql);

            } catch (Exception $e) {

                die("PDO_ERROR: " . $e->getMessage() . " at class: " . get_class($this) . " Stack trace:" . $e->getTraceAsString() . " execute sql:" . $sql);

            }

        }
    }
?>