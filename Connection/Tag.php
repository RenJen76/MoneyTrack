<?php 

    // namespace Connection;

    // use Database;

    class Tag extends Database
    {

        public $tableName = 'tags';

        public function __construct()
        {
            parent::__construct();
        }

        public function findTagByName($tagName)
        {
            $tag = $this->query("select * from $this->tableName where tag_name = '$tagName'");
            if ($tag) {
                return $tag[0];
            }
            return null;
        }

        public function findTagById($tagId)
        {
            $tag = $this->query("select * from $this->tableName where tag_id = '$tagId'");
            if ($tag) {
                return $tag[0];
            }
            return null;
        }

        public function createTag($tagName)
        {
            return $this->save(['tag_name' => $tagName]);
        }

        public function findOrCreate($tagName)
        {
            $tag = $this->findTagByName($tagName);

            if (!$tag) {
                return $this->findTagById($this->createTag($tagName));
            }

            return $tag;
        }
        
        public function getAll()
        {
            return $this->query("select * from $this->tableName");
        }
    }
?>