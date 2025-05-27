<?php 

    // namespace Connection;

    // use Database;

    class Trans extends Database
    {

        public $tableName = 'trans_list';

        public function __construct()
        {
            parent::__construct();
        }

        public function mostCostDay()
        {
            return $this->query("
                select MIN(dayAmount) as dayAmount, spend_at
                from (
                    select SUBSTRING(spend_at, 1, 10) as spend_at, sum(amount) as dayAmount 
                    from trans_list 
                    group by SUBSTRING(spend_at, 1, 10) 
                ) as trans
                group by spend_at
            ")[0];
        }

        public function transOnDate($transDate)
        {
            if ($transDate) {

                $fromDate = date('Y-m-d', strtotime($transDate)) . " 00:00:00";
                $asOfDate = date('Y-m-d', strtotime($transDate)) . " 23:59:59";

                return $this->query("
                    select 
                        list.subcategory_id, category_name, amount, cate.category_id, spend_at, 
                        vendor.vendor_name, description, subcate.subcategory_name
                    from trans_list list
                    inner join subcategory_list subcate on list.subcategory_id = subcate.subcategory_id
                    inner join category_list cate on subcate.category_id = cate.category_id
                    inner join vendor_list vendor on list.vendor_id = vendor.vendor_id
                    where list.spend_at between '$fromDate' and '$asOfDate'
                ");
            }

            return null;
        }

        public function transOnMonth($transMonth)
        {
            if ($transMonth) {

                $fromMonth = date('Y-m-01', strtotime($transMonth));
                $asOfMonth = date('Y-m-t', strtotime($transMonth));

                return $this->query("
                    select 
                        list.subcategory_id, category_name, amount, cate.category_id, spend_at, 
                        vendor.vendor_name, description, subcate.subcategory_name
                    from trans_list list
                    inner join subcategory_list subcate on list.subcategory_id = subcate.subcategory_id
                    inner join category_list cate on subcate.category_id = cate.category_id
                    inner join vendor_list vendor on list.vendor_id = vendor.vendor_id
                    where list.spend_at between '$fromMonth' and '$asOfMonth'
                ");
            }

            return null;
        }

        public function costVendorRank()
        {
            return $this->query("
                select 
                    vendor_name, SUM(amount) as amount, count(*) as count_num
                from trans_list list
                inner join vendor_list vendor on list.vendor_id = vendor.vendor_id
                group by list.vendor_id
                order by amount DESC
                LIMIT 10
            ");
        }

        public function category()
        {
            return $this->query("select * from category_list");
        }

        public function vendor($vendorName)
        {
            if ($vendorName) {
                $vendorName = addslashes($vendorName);
                return $this->query("select * from vendor_list where vendor_name = '$vendorName'")[0];
            }
            return null;
        }

        public function subcategory($categoryId)
        {
            if ($categoryId) {
                return $this->query("select * from subcategory_list where category_id = '$categoryId'");
            }
            return null;
        }

        public function vendorTransList($vendorId)
        {
            if ($vendorId) {
                return $this->query("
                    select 
                        list.subcategory_id, category_name, amount, cate.category_id, spend_at, 
                        vendor.vendor_name, description, subcate.subcategory_name
                    from trans_list list
                    inner join subcategory_list subcate on list.subcategory_id = subcate.subcategory_id
                    inner join category_list cate on subcate.category_id = cate.category_id
                    inner join vendor_list vendor on list.vendor_id = vendor.vendor_id
                    where list.vendor_id = '$vendorId'
                ");
            } 
            return null;
        }

        public function createTrans($data)
        {
            return $this->execute("
                insert into trans_list (account_id, spend_at, vendor_id, subcategory_id, amount, description, create_at)
                select '".$data['accountId']."', '".$data['spendAt']."', '".$data['vendorId']."', '".$data['subcategoryId']."',
                '".$data['amount']."', '".$data['description']."', now()
                from DUAL
                where not exists
                (
                    select trans_no 
                    from trans_list
                    where 
                        account_id = '".$data['accountId']."' and vendor_id = '".$data['vendorId']."' 
                        and amount = '".$data['amount']."' and description = '".$data['description']."' 
                        and spend_at = '".$data['spendAt']."'
                )
                limit 1
            ");
        }

    }
?>