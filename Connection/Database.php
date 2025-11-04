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
        
        /**
         * update function
         *
         * @param array $updateFields
         * @param array $condition
         * @param int $limit
         * @return bool
         */
        public function update($updateFields = array(), $condition = array(), $limit = 0)
        {
            if ($this->tableName && count($updateFields)>0) {

                $whereClause  = $this->buildConditionClause($condition);
                $updateClause = $this->buildConditionClause($updateFields);

                try {

                    $sql    = "update `$this->tableName` set ";
                    $sql   .= implode(" , ", $updateClause);
                    if (count($whereClause)>0) {
                        $sql   .= " where " . implode(" AND ", $whereClause);
                        $executeFields = array_merge($updateFields, $condition);
                    } else {
                        $sql   .= " where 1 ";
                        $executeFields = $condition;
                    }
                    
                    if (intval($limit) > 0) {
                        $sql   .= " limit $limit";
                    }
                    
                    $statement  = $this->connection->prepare($sql);
                    $res        = $statement->execute($executeFields);
                    return $res > 0 ? true : false;

                } catch (Exception $e) {

                    die("PDO_ERROR: " . $e->getMessage() . " at class: " . get_class($this) . " Stack trace:" . $e->getTraceAsString() . " execute sql:" . $sql);
   
                }
            }

            return false;
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

        public function buildConditionClause($fields = array())
        {
            $where = [];
            if (count($fields)>0) {
                foreach (array_keys($fields) as $field) {
                    $where[] = "`$field`=:$field";
                }
            }
            return $where;
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