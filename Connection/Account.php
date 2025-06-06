<?php 

    // namespace Connection;

    // use Database;

    class Account extends Database
    {

        public $tableName = 'account_list';

        public function __construct()
        {
            parent::__construct();
        }

        public function findAccountByName($accountName)
        {
            $account = $this->query("select * from $this->tableName where account_name = '$accountName'");
            if ($account) {
                return $account[0];
            }
            return null;
        }

        public function findAccountById($accountId)
        {
            $account = $this->query("select * from $this->tableName where account_id = '$accountId'");
            if ($account) {
                return $account[0];
            }
            return null;
        }

        public function createAccount($accountName)
        {
            return $this->save(['account_name' => $accountName]);
        }

        public function findOrCreate($accountName)
        {
            $account = $this->findAccountByName($accountName);

            if (!$account) {
                return $this->findAccountById($this->createAccount($accountName));
            }

            return $account;
        }
        
        public function getAll()
        {
            return $this->query("select * from $this->tableName");
        }
    }
?>