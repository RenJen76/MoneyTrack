<?php 
    class TransService
    {
        protected $trans;

        function __construct(Trans $trans)
        {
            $this->trans = $trans;
        }

        public function getCateList()
        {
            $categoryList   = array();
            $category       = $this->trans->category();
            foreach ($category as $data) {
                $categoryId = $data['category_id'];
                $subcategory= $this->trans->subcategory($categoryId) ?: [];
                $categoryList[] = [
                    'categoryId'    => $categoryId,
                    'categoryName'  => $data['category_name'],
                    'subcategory'   => $subcategory
                ];                
            }
            return $categoryList;
        }

        public function getTotalSpend()
        {
            $data   = $this->trans->connection->query("
                select category_name, sum(amount) as subcategoryAmount, cate.category_id
                from trans_list list
                inner join subcategory_list subcate on list.subcategory_id = subcate.subcategory_id
                inner join category_list cate on subcate.category_id = cate.category_id
                group by category_id, category_name
            ");

            $TotalAmount = 0;
            $dataJson    = [];
            $cateDetail  = [];

            foreach ($data as $row) {

                $categoryData   = array();
                $categoryId     = $row['category_id'];

                $dataJson[$row['category_id']] = [
                    'name'      => $row['category_name'],
                    'sum'       => (int)$row['subcategoryAmount'],
                    'y'         => 0,
                    'drilldown' => $row['category_name']
                ];

                // --- 取得分類明細

                $categoryDetail = $this->trans->connection->query("
                    select list.subcategory_id, subcategory_name, sum(amount) as subcategoryAmount 
                    from trans_list list
                    inner join subcategory_list subcate on list.subcategory_id = subcate.subcategory_id
                    inner join category_list cate on subcate.category_id = cate.category_id and cate.category_id = '$categoryId'
                    group by subcategory_id, subcategory_name
                ");

                foreach ($categoryDetail as $categoryRows) {
                    $categoryData[] = [
                        '0' => $categoryRows['subcategory_name'],
                        '1' => (int)$categoryRows['subcategoryAmount'] * 100 / $row['subcategoryAmount']
                    ];
                }

                $cateDetail[]= [
                    'name'  => $row['category_name'],
                    'id'    => $row['category_name'],
                    'data'  => $categoryData
                ];
                $TotalAmount = $TotalAmount + $row['subcategoryAmount'];
            }

            foreach ($dataJson as $key => $row) {
                $dataJson[$key]['y'] = $row['sum'] * 100 / $TotalAmount;
            }
            return [
                'dataJson'      => $dataJson,
                'cateDetail'    => $cateDetail,
                'TotalAmount'   => $TotalAmount,
            ];
        }

        public function transByVendor($vendorName)
        {
            if ($vendorName) {
                $vendor     = $this->trans->vendor($vendorName);
                $vendorId   = $vendor['vendor_id'];
                return $this->trans->vendorTransList($vendorId);
            }
            return null;
        }

        public function import()
        {
            $Vendor         = new Vendor();
            $Account        = new Account();
            $Category       = new Category();
            $SubCategory    = new SubCategory();
            $insertRows     = [];

            if (($handle = fopen($_FILES['uploadFile']['tmp_name'], "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($data[3]) {
                        // 轉帳交易
                        continue;
                    }
                    // 有金額及店家名稱
                    if ((int)$data[10]!='0' && $data[5]!='') {
                        $hashkey             = hash('sha256', $data[0].$data[2].$data[4].$data[5].$data[7].$data[8].$data[10]);
                        $TransByHashKey      = $this->trans->getTransByHashKey($hashkey);
                        if ($TransByHashKey) {
                            continue;
                        }

                        $categoryCombin      = $this->parseCategory($data[6]);
                        $category            = $Category->findOrCreate($categoryCombin[0]);
                        $rows                = [
                            'accountId'      => $Account->findOrCreate($data[2])['account_id'],
                            'description'    => addslashes($data[4]),
                            'vendorId'       => $Vendor->findOrCreate(addslashes($data[5]))['vendor_id'],
                            'subcategoryId'  => $SubCategory->findOrCreate($categoryCombin[1], $category['category_id'])['subcategory_id'],
                            'spendAt'        => date("Y-m-d H:i:s", strtotime($data[7] . " " . $data[8])),
                            'amount'         => intval($data[10]),
                            'hashkey'        => $hashkey
                        ];
                        $transId             = $this->trans->createTrans($rows);
                        
                        if ($transId!=0) {
                            $insertRows[]    = $this->trans->getTrans($transId)[0];
                        }
                    }
                }
            }

            return $insertRows;
        }

        public function parseCategory($category)
        {
            $categoryArray = explode("▶︎", $category);
            $categoryArray = array_map(function($categoryName){
                return trim($categoryName);
            }, $categoryArray);

            if (count($categoryArray) === 1) {
                $categoryArray[] = $categoryArray[0];
            }

            return $categoryArray;
        }

        public function getThisMonthSpend()
        {
            $amounts   = 0;
            $today     = date('Y-m-d');
            $today     = '2025-06-01';
            $fromMonth = date('Y-m-01', strtotime($today));
            $asOfMonth = date('Y-m-t', strtotime($today));
            $trans  = $this->trans->transBetweenDays($fromMonth, $asOfMonth);
            foreach ($trans as $record) {
                $amounts += $record['amount'];
            }
            return $amounts;
        }

        public function getDailyCostsInRange($fromDate, $toDate)
        {
            $fromDate   = date('Y-m-d', strtotime($fromDate));
            $toDate     = date('Y-m-d', strtotime($toDate));
            $trans      = $this->trans->transBetweenDays($fromDate, $toDate);
            $records    = [];
            $category   = [];
            $category   = array_unique(array_column($trans, 'category_name'));
            foreach ($trans as $row) {
                $spendAt        = date('Y-m-d', strtotime($row['spend_at']));
                $category_name  = $row['category_name'];
                if (!isset($records[$spendAt])) {
                    foreach ($category as $cate) {
                        $records[$spendAt][$cate] = 0;
                    }
                }
                $records[$spendAt][$category_name] += $row['amount'];
            }
            return [
                'record' => $records,
                'category' => $category
            ];
        }
    }
?>