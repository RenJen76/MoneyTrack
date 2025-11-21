<?php 

    // namespace Connection;

    // use Database;

    class TransTag extends Database
    {

        public $tableName = 'trans_tag';

        public function __construct()
        {
            parent::__construct();
        }

        // public function findTagByName($tagName)
        // {
        //     $tag = $this->query("select * from $this->tableName where tag_name = '$tagName'");
        //     if ($tag) {
        //         return $tag[0];
        //     }
        //     return null;
        // }

        public function findTransTag($transId)
        {
            $tag = $this->query("select tag_id from $this->tableName where trans_id = '$transId'");
            if ($tag) {
                return $tag[0];
            }
            return null;
        }

        public function createTransTag($transId, $tag_id)
        {
            return $this->save([
                'trans_id' => $transId,
                'tag_id'   => $tag_id
            ]);
        }
        
        public function getAll()
        {
            return $this->query("select * from $this->tableName");
        }
    }
?>