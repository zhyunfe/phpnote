<?php
/**
 * 正则表达式
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/1/20
 * Time: 下午3:45
 */
namespace app\index\controller;

use think\Controller;
use think\Paginator;

class Preg
{
    //匹配，只匹配一次
    public $preg_match;
    //匹配，匹配所有
    public $preg_match_all;
    //匹配后替换
    public $preg_replace;
    //匹配后替换，只保留替换过的目标值
    public $preg_filter;
    //输出符合pattern的目标值
    public $preg_grep;
    //高级版的explode
    public $preg_split;
    //自动转义
    public $preg_quote;

    public function index()
    {
        $pattern = '/((13[0-9])|147|(15[0-35-9])|180|182|(18[5-9]))[0-9]{8}/';
        dump(Preg::preg_tel($pattern, 'Demoer:15726668339'));

        $pattern = '/[0-9]{2}/';
        dump(Preg::preg_num($pattern, 'sdsd223232sd9sd23ms8d34m34x9'));

        $pattern = '/[0-9]{3}/';
        dump(Preg::preg($pattern, '232hs34hdk45ksh4kh3j3hx3'));

        $pattern = '/[0-9]/';
        $replace = '*';
        dump(Preg::preg_th_str($pattern, $replace,'232hs34hdk45ksh4kh3j3hx9'));

        $pattern = array('/[0-3]/', '/[4-7]/', '/[8-9]/');
        //对应替换
        $replace = array('*', '&', '#');
        dump(Preg::preg_th_array($pattern, $replace, array( 'sdsd', '234d3de3', '23dsdsdsd', '222')));

        $pattern = '/[0-9]/';
        dump(Preg::pr_grep($pattern, array('sdsd', '234d3de3', '23dsdsdsd', '222')));

        $pattern = '/[0-9]/';
        dump(Preg::pr_split($pattern, 'we34h34he3hd3'));

        $pattern = 'erre{sdse}sdsd';
        dump(Preg::pr_quote($pattern));

        dump(Preg::pr_yz());
        dump(Preg::pr_tanlan());
    }


    public static function preg_tel($pattern, $tel)
    {
        preg_match($pattern, $tel, $res);
        return $res;
    }
    public static function preg_num($pattern, $num)
    {
        preg_match_all($pattern, $num, $res);
        return $res;
    }

    /** preg_match 和 preg_match_all的区别
     * @param $subject
     * @return array
     */
    public static function preg($pattern, $subject)
    {
        $m1 = $m2 = array();
        preg_match($pattern, $subject, $m1);
        preg_match_all($pattern, $subject, $m2);
        return array('m1' => $m1, 'm2' => $m2);
    }

    /**
     * 使用preg_replace 和 preg_filter替换字符串
     * @param $subject
     * @return array
     */
    public static function preg_th_str($pattern, $replace, $subject)
    {
        //preg_replace 和 preg_fliter
        $m1 = preg_replace($pattern, $replace, $subject);
        $m2 = preg_filter($pattern, $replace, $subject);
        return array('m1' => $m1, 'm2' => $m2);
    }

    /**
     * 使用preg_replace 和 preg_filter替换数组
     * @param $array
     * @return array
     */
    public static function preg_th_array($pattern, $replace, $array)
    {
        //目标数组中不替换的也会保留
        $m1 = preg_replace($pattern, $replace, $array);
        //只会保留发生了替换的数组元素
        $m2 = preg_filter($pattern, $replace, $array);
        return array('m1' => $m1, 'm2' => $m2);
    }

    public static function pr_grep($pattern, $array)
    {
        //preg_grep
        //过滤掉不符合pattern的字符串
        $m1 = preg_grep($pattern, $array);
        return $m1;
    }

    /**
     * 相当于升级版的explode
     * @param $pattern
     * @param $subject
     * @return array
     */
    public static function pr_split($pattern, $subject)
    {
        $arr = preg_split($pattern, $subject);
        return $arr;
    }

    /** 正则运算符转义
     * @param $subject
     * @param $dilimter
     * @return string
     */
    public static function pr_quote($subject)
    {
        //正则运算符转义
        $str = preg_quote($subject);
        return $str;
    }

    //界定符，表示正则表达式的开始和结束位置，告诉PHP解析器从哪里开始到哪里结束
    // '//' => /[0-9]/  '##' => #[0-9]# '{}' => {[0-9]} 都可以当做界定符，一般在php中用/和#来当做界定符

    //原子  可见原子和不可见原子（\r\n tab）,涉及文字匹配建议使用unicode编码后匹配
    //[]  匹配这里面的任意原子    | 匹配两个或者多个
    //[^] 匹配不在这里面的任意原子
    // . 匹配除了换行符之外的任意字符 [^\n]
    // \d 匹配任意十进制数值   [0-9]
    // \D 匹配任意除了十进制数值 [^0-9]
    // \s 匹配一个不可见原子 [\f\r\n\t\v]
    // \S 匹配一个可见院子  [^\f\r\n\t\v]
    // \w 匹配任意数字、字母或下划线 [a-zA-Z0-9_]
    // \W 匹配任意非数字、字母或下划线 [^a-zA-Z0-9_]

    public static function pr_yz()
    {
        $str = '34j34jsk....---34kxksi3kKSDK3';
        $pattern = '/[a-zA-Z0-9]/';
        preg_match_all($pattern, $str, $res);
        return $res;
    }
    //量词
    //{n}    其前面的原子正好出现n次
    //{n,}   其前面的原子至少出现n次
    //{n,m}  其前面的原子出现n-m次
    //*      匹配0次，1次或者多次其之前的原子 相当于{0,}
    //+      匹配1次或者多次其之前的原子      相当于{1,}
    //?      匹配0次或者1次其之前的原子      相当于{0,1}

    //边界控制
    //^ 匹配开始
    //$ 匹配结束
    // () 匹配其中的整体为一个原子
    //模式修正符
    // i 不区分大小写
    // m 视为多行
    // s 将字符串视为单行，忽略\n
    // x忽略空白
    // A 必须以指定字符开始，相当于^
    // D 配合$使用，j结尾处不能有空行
    // 贪婪匹配 匹配比较多的那个
    // 懒惰匹配 匹配少的那个
    public static function pr_tanlan()
    {
        //默认贪婪模式zhyunfe_121212121212
        $pattern = '/zhyunfe.+1212/';
        //懒惰模式zhyunfe_1212
        $pattern = '/zhyunfe.+1212/U';
        //不区分大小写ZHYUNFE_121212zhyunfe_1212121212
        $pattern = '/ZHyUnfe.+1212/i';
        //懒惰并且忽略大小写
        $pattern = '/ZhyUnfe.+1212/Ui';
        //忽略空白符
        $pattern = '/zhyunf e.+1212/x';
        $str     = 'zhyunfe_121212121212';
        preg_match($pattern, $str, $res);

        return $res;
    }
    //匹配非空
    public static function pr_notnull()
    {
        //原子出现的次数为1次到无穷大次就是非空  即 .+

    }

    public  function getNumber()
    {
        $url = 'http://swylogin.gm99.com/home/product/productlist';
        $postData = json_decode('{"userID":"13503427","serverID":"2","roleID":"20000523","sign":"yiT7QMawqP7GdqDUtkodsP0gVzsQRYM3AzyfokPWr01l4K5PN++bNz79mcJRFYyhBdOS1pj\/BXGZrXMEMSYmJCQMetaeTwHx4GhcmY47n7OC34vJlGbA4Sn\/WKsHHe6e7LvBhqmLxs8f7u2v4GmKaWvLgfxqyKb9E\/ALQfYSrjAZo4wdW6agP\/FNiWzUWirQqpe649TG74hlxL7KY23pkJojZkQ6SqB7FWn8mqghXaJVcJy4fgZ0ioAPiqd0cmaQB3Eb2s3XxYidI7v5bZsYPlkIrMXPtOTI3Xb918rN\/ofh2wM+389cqC9VmmW7CzaC3dcKTbj0uFDiT5TfkgYwaQ=="}',true);
        $http = new Plus_HttpCurl($url);
        $response = $http->POST($postData, false, true);
        preg_match('/{\S+}/', $response, $res);
        $response = $res[0];
        $response = str_replace('\\','',$response);
        var_dump($response);
        $responseArr = $response ? json_decode($response, true) : false;
        // 记录请求地址
        $packData = $responseArr['canBuyProductID'];
        if (is_array($packData)) {
            foreach ($packData as $key=>$value) {
                $responseArr['canBuyProductID'][$key] = 'divine.app.pac'.$value;
            }
        }
        var_dump($responseArr);die();
        $response = "{\"canBuyProductID\":[30001,30002,30003,30004,30005,30011,30014,30028,30029,20000,20001,20002],\"code\":0,\"msg\":\"success\",\"result\":1}\n";
//        $pattern = '/{\S+}/';
//        preg_match($pattern, $response, $response);
        $responseArr = json_decode($response, true);
        var_dump($responseArr['canBuyProductID']);
        if (is_array($responseArr['canBuyProductID'])) {
            foreach ($responseArr['canBuyProductID'] as $key=>$value) {
                $responseArr['canBuyProductID'][$key] = 'divine.app.pac' . $value;
            }
        }
        var_dump($responseArr['canBuyProductID']);
        $pattern = '/\d+/';
        $str = 'divine.app.pac3001';
        preg_match($pattern, $str, $res);

    }
    public function getmycard()
    {
        $avalibalPack = '{"result":1,"msg":"success","code":1,"data":{"canBuyProductID":["divine.app.pac30001","divine.app.pac30002","divine.app.pac30003","divine.app.pac30004","divine.app.pac30005","divine.app.pac30014","divine.app.pac30028","divine.app.pac30029","divine.app.pac20000","divine.app.pac20001","divine.app.pac20002"]}}';
        $priceConfig = '{"100.00":{"TRANS_AMOUNT":"100.00","PRODUCT_DESC":"200\u947d\u77f3","PRODUCT_TYPE":"coin","BOSS_AMOUNT":"100.00","BOSS_USD_AMOUNT":0,"COIN":200,"EXTRA_COIN":0,"PAYTYPE_IN_GAME":"paypal","COMMON_EXTRA_COIN_IN_GAME":0,"ACTIVITY_EXTRA_COIN_IN_GAME":0,"FIRST_PAY_EXTRA_COIN_IN_GAME":0,"APPSTORE_ITEM_ID":"","EXTRA_RATIO":"0.00","ALL_RATIO":2},"300.00":{"TRANS_AMOUNT":"300.00","PRODUCT_DESC":"600\u947d\u77f3","PRODUCT_TYPE":"coin","BOSS_AMOUNT":"300.00","BOSS_USD_AMOUNT":0,"COIN":600,"EXTRA_COIN":0,"PAYTYPE_IN_GAME":"paypal","COMMON_EXTRA_COIN_IN_GAME":0,"ACTIVITY_EXTRA_COIN_IN_GAME":0,"FIRST_PAY_EXTRA_COIN_IN_GAME":0,"APPSTORE_ITEM_ID":"","EXTRA_RATIO":"0.00","ALL_RATIO":2},"500.00":{"TRANS_AMOUNT":"500.00","PRODUCT_DESC":"1000\u947d\u77f3","PRODUCT_TYPE":"coin","BOSS_AMOUNT":"500.00","BOSS_USD_AMOUNT":0,"COIN":1000,"EXTRA_COIN":0,"PAYTYPE_IN_GAME":"paypal","COMMON_EXTRA_COIN_IN_GAME":0,"ACTIVITY_EXTRA_COIN_IN_GAME":0,"FIRST_PAY_EXTRA_COIN_IN_GAME":0,"APPSTORE_ITEM_ID":"","EXTRA_RATIO":"0.00","ALL_RATIO":2},"1000.00":{"TRANS_AMOUNT":"1000.00","PRODUCT_DESC":"2000\u947d\u77f3","PRODUCT_TYPE":"coin","BOSS_AMOUNT":"1000.00","BOSS_USD_AMOUNT":0,"COIN":2000,"EXTRA_COIN":0,"PAYTYPE_IN_GAME":"paypal","COMMON_EXTRA_COIN_IN_GAME":0,"ACTIVITY_EXTRA_COIN_IN_GAME":0,"FIRST_PAY_EXTRA_COIN_IN_GAME":0,"APPSTORE_ITEM_ID":"","EXTRA_RATIO":"0.00","ALL_RATIO":2},"2000.00":{"TRANS_AMOUNT":"2000.00","PRODUCT_DESC":"4000\u947d\u77f3","PRODUCT_TYPE":"coin","BOSS_AMOUNT":"2000.00","BOSS_USD_AMOUNT":0,"COIN":4000,"EXTRA_COIN":0,"PAYTYPE_IN_GAME":"paypal","COMMON_EXTRA_COIN_IN_GAME":0,"ACTIVITY_EXTRA_COIN_IN_GAME":0,"FIRST_PAY_EXTRA_COIN_IN_GAME":0,"APPSTORE_ITEM_ID":"","EXTRA_RATIO":"0.00","ALL_RATIO":2},"divine.app.pac30029":{"TRANS_AMOUNT":"150.00","PRODUCT_DESC":"\u91d1\u5e01\u793c\u5305(\u5c0f)","PRODUCT_TYPE":"package","BOSS_AMOUNT":"150.00","BOSS_USD_AMOUNT":0,"COIN":0,"EXTRA_COIN":0,"PAYTYPE_IN_GAME":"paypal","COMMON_EXTRA_COIN_IN_GAME":0,"ACTIVITY_EXTRA_COIN_IN_GAME":0,"FIRST_PAY_EXTRA_COIN_IN_GAME":0,"APPSTORE_ITEM_ID":"","EXTRA_RATIO":"0.00","ALL_RATIO":2},"divine.app.pac20002":{"TRANS_AMOUNT":"150.00","PRODUCT_DESC":"\u91d1\u5e01\u793c\u5305(\u5927)","PRODUCT_TYPE":"package","BOSS_AMOUNT":"150.00","BOSS_USD_AMOUNT":0,"COIN":0,"EXTRA_COIN":0,"PAYTYPE_IN_GAME":"paypal","COMMON_EXTRA_COIN_IN_GAME":0,"ACTIVITY_EXTRA_COIN_IN_GAME":0,"FIRST_PAY_EXTRA_COIN_IN_GAME":0,"APPSTORE_ITEM_ID":"","EXTRA_RATIO":"0.00","ALL_RATIO":2}}';
        $availableProduct = json_decode($avalibalPack, true);
        $priceConfig = json_decode($priceConfig, true);
        $list = array(
        '遊戲幣' => array('coin'),
        'VIP卡' => array('month_card', 'card'),
        '禮包' => array('package'),
    );
        foreach($priceConfig as $productID => $productItem) {
            foreach($list as $key=>$val){
                if(in_array($productItem['PRODUCT_TYPE'], $val)){
                    $productType = $key;
                    break;
                }
            }
            $productDesc = $productItem['PRODUCT_DESC'];
            $transAmount = $productItem['TRANS_AMOUNT'];
            $coin = $productItem['COIN'];
            $extraCoin = $productItem['EXTRA_COIN'];
            $commonExtraCoinIngame = $productItem['COMMON_EXTRA_COIN_IN_GAME'];
            $activityExtraCoinIngame = $productItem['ACTIVITY_EXTRA_COIN_IN_GAME'];
            $fistPayExtraCoinIngame = $productItem['FIRST_PAY_EXTRA_COIN_IN_GAME'];
            $tmpArr = array();
            $tmpArr['PRODUCT_ID'] = $productID;
            $tmpArr['PRODUCT_NAME'] = $productDesc;

            //处理本地化形式的价格展示
            $tmpArr['TRANS_AMOUNT_READABLE'] = 'hahahah';

            //原始游戏币
            $tmpArr['COIN'] = $coin;

            //处理加码：平台加码和游戏内加码都合并在EXTRA_COIN字段
            $tmpArr['EXTRA_COIN'] = $extraCoin + $commonExtraCoinIngame + $activityExtraCoinIngame;

            //首储只传true/false
            $tmpArr['FIRST_PAY_EXTRA_COIN'] = $fistPayExtraCoinIngame > 0;

            //商品展示，目前有两种方式：
            //1.游戏币(COIN > 0) PC端：xxx元/xxx元宝，移动端：xxx元=xxx+xxx元宝
            //2.非游戏币(COIN = 0) xxx元 兑换 xxx
            if($productItem['PRODUCT_TYPE'] != 'coin'){
                //禮包
                //验证是否可购
                if($availableProduct
                    && is_array($availableProduct)
                    && ($availableProduct['result'] != 1 ||
                        (!in_array($productID, $availableProduct['data']['canBuyProductID'])
                            && !in_array($productID, $availableProduct['data']['activityProductID'])))){
                    //跳过该商品id
                    continue;
                }
                $coinName = preg_replace('/\d+(.+)/', '$1', $productDesc);
                $tmpArr['PRODUCT_DESC'] = $tmpArr['TRANS_AMOUNT_READABLE'] . '/' . $coinName;
                if($currency == 'POINTS'){
                    //商品提示语
                    $tmpArr['PRODUCT_NOTICE'] = '123';
                }
            }elseif($coin > 0) {
                $coinName = preg_replace('/\d+(.+)/', '$1', $productDesc);
                if(empty($coinName)){
                    $coinName = '234';
                }
                if(true) {
                    $tmpArr['PRODUCT_DESC'] = $tmpArr['TRANS_AMOUNT_READABLE'] . '=' . $tmpArr['COIN'] .
                        ($tmpArr['EXTRA_COIN'] > 0 ? '+' . $tmpArr['EXTRA_COIN'] : '') . $coinName;
                }else {
                    $tmpArr['PRODUCT_DESC'] = $tmpArr['TRANS_AMOUNT_READABLE'] . '/' . ($tmpArr['COIN'] + $tmpArr['EXTRA_COIN']) . $coinName;
                }
            }
            if(!isset($tmpArr['PRODUCT_NOTICE'])){
                //商品提示语
                $tmpArr['PRODUCT_NOTICE'] = '123';
            }

            $resultArr[$productType][] = $tmpArr;
            $data = array();
            foreach($resultArr as $catalog => $list) {
                $data[] = array(
                    'catalog' => $catalog,
                    'list' => $list,
                );
            }
            var_dump($data);
        }
    }


}