<?php 
    class Database
    {

        public $connection;
        public $tableName;
        public $host        = 'localhost';
        public $dbName      = 'moneytracker';
        public $username    = '';
        public $password    = '';

        public function __construct ()
        {
            $this->connect();
        }

        public function connect()
        {
            try {

                $pdo = new PDO("mysql:host=".$this->host.";dbname=".$this->dbName, $this->username, $this->password);
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

                    die("PDO error: " . $e->getMessage());
                 
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
            if ($tableName && count($condition)>0) {

                $fields = $this->buildFields($condition);

                try {

                    $statement  = $this->connection->prepare("insert into `$this->tableName`($fields[fieldsName]) values ($fields[fieldsValue])");
                    $statement->execute($condition);
                    return true;

                } catch (Exception $e) {

                    die("PDO_ERROR: " . $e->getMessage());
   
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
    }
?>