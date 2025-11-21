<?php
class Utils
{
    /**
     * 將金額字串解析為數字（支援 USD / TWD 常見格式）
     *
     * 範例輸入：
     *  "$5,000.00", "5,000", "NT$ 1,234", "(1,234.56)" 等
     *
     * @param mixed  $value    金額字串或數值
     * @param string $currency 可選 'USD' 或 'TWD'（用來移除特定貨幣符號），不指定則移除常見貨幣符號
     * @return float|int 解析後的數值（若無小數回傳 int，否則回傳 float）
     */
    public static function parseAmount($value, $currency = null)
    {
        if ($value === null || $value === '') {
            return 0;
        }

        $s = trim((string)$value);

        // 處理括號表示負數： (1,234.56)
        $negative = false;
        if (preg_match('/^\(.+\)$/', $s)) {
            $negative = true;
            $s = trim($s, '()');
        }

        // 依 currency 移除常見貨幣符號
        $symbolMap = [
            'USD' => ['$', 'US$', 'USD'],
            'TWD' => ['NT$', 'NT', 'TWD', '＄']
        ];

        if ($currency && isset($symbolMap[strtoupper($currency)])) {
            foreach ($symbolMap[strtoupper($currency)] as $sym) {
                $s = str_ireplace($sym, '', $s);
            }
        } else {
            // 移除常見貨幣符號，寬字元也處理
            $s = preg_replace('/(US\$|USD|NT\$|TWD|¥|￥|\$|€|£)/i', '', $s);
        }

        // 移除空白與千分位逗號（常見於 USD/TWD），保留小數點與負號
        // 若未來要處理歐洲格式（1.234,56）需額外判斷，這裡以 "." 為小數點
        $s = str_replace(["\xc2\xa0", ' ', ','], ['', '', ''], $s); // 包含不換行空白
        // 只保留數字、小數點、負號
        $s = preg_replace('/[^\d\.\-]/', '', $s);

        if ($s === '' || !is_numeric($s)) {
            return 0;
        }

        // 回傳整數或浮點數
        $num = (strpos($s, '.') === false) ? (int)$s : (float)$s;
        if ($negative) $num = -$num;
        return $num;
    }

    public static function parseTags($tagString = "") 
    {
        if ($tagString) {
            $tags = explode(';', $tagString) ?? [];
            return array_filter($tags, function($tag) {
                return trim($tag);
            });
        }

        return [];
    }
}
?>