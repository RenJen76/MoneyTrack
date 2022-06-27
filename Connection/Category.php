<?php 

    // namespace Connection;

    // use Database;

    class Category extends Database
    {

        public $tableName = 'category_list';

        public function __construct()
        {
            parent::__construct();
        }

        public function findByName($categoryName)
        {
            $category = $this->query("select * from $this->tableName where category_name = '$categoryName'");
            if ($category) {
                return $category[0];
            }
            return null;
        }

        public function findById($categoryId)
        {
            $category = $this->query("select * from $this->tableName where category_id = '$categoryId'");
            if ($category) {
                return $category[0];
            }
            return null;
        }

        public function create($categoryName)
        {
            return $this->save([
                'category_name' => $categoryName,
                'create_at'     => date("Y-m-d H:i:s")
            ]);
        }

        public function findOrCreate($categoryName)
        {
            $category = $this->findByName($categoryName);

            if (!$category) {
                return $this->findById($this->create($categoryName));
            }

            return $category;
        }
    }
?>