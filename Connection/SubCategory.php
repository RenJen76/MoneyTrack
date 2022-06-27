<?php 

    // namespace Connection;

    // use Database;

    class SubCategory extends Database
    {

        public $tableName = 'subcategory_list';

        public function __construct()
        {
            parent::__construct();
        }

        public function findByName($subCategoryName)
        {
            $subCategory = $this->query("select * from $this->tableName where subcategory_name = '$subCategoryName'");
            if ($subCategory) {
                return $subCategory[0];
            }
            return null;
        }

        public function findById($subCategoryId)
        {
            $subCategory = $this->query("select * from $this->tableName where subcategory_id = '$subCategoryId'");
            if ($subCategory) {
                return $subCategory[0];
            }
            return null;
        }

        public function create($subCategoryName, $categoryId = 0)
        {
            return $this->save([
                'subcategory_name' => $subCategoryName,
                'category_id'      => $categoryId,
                'create_at'        => date("Y-m-d H:i:s")
            ]);
        }

        public function findOrCreate($subCategoryName, $categoryId = 0)
        {
            $subCategory = $this->findByName($subCategoryName);

            if (!$subCategory) {
                return $this->findById($this->create($subCategoryName, $categoryId));
            }

            return $subCategory;
        }
    }
?>