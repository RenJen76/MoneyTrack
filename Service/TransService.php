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
                $subcategory= $this->trans->subcategory($categoryId);
                if (count($subcategory) > 0) {
                    $categoryList[] = [
                        'categoryId'    => $categoryId,
                        'categoryName'  => $data['category_name'],
                        'subcategory'   => $subcategory
                    ];
                }
            }
            return $categoryList;
        }

        public function getTotalSpend()
        {
            $data   = $this->trans->connection->query("
                select list.subcategory_id, category_name, sum(amount) as subcategoryAmount, cate.category_id
                from trans_list list
                inner join subcategory_list subcate on list.subcategory_id = subcate.subcategory_id
                inner join category_list cate on subcate.category_id = cate.category_id
                group by category_id
            ");

            $TotalAmount = 0;

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
                    select list.subcategory_id, subcategory_name, sum(amount) as subcategoryAmount, cate.category_id 
                    from trans_list list
                    inner join subcategory_list subcate on list.subcategory_id = subcate.subcategory_id
                    inner join category_list cate on subcate.category_id = cate.category_id and cate.category_id = '$categoryId'
                    group by subcategory_id
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
    }
?>