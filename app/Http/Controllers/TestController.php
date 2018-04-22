<?php
/**
 * 业务测试
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TestController extends Controller
{
    //
    public function index()
    {
        echo 123;
    }
    public function test()
    {
        $message = '[2]:[[]]';
    }
    /**
     * 大天使可购礼包转换测试
     */
    public function dts_canbuy()
    {
        $data = json_decode('{"result":1,"msg":"success","data":{"canBuyProductID":["110","111","108","109","118"]}}', true);
//        $canBuyProductID = array('result' => 1, 'msg' => 'success', 'data' => array('canBuyProductID'=> array(110,111,118,109,108)));
//        var_dump(json_encode($canBuyProductID));
        $dataF['canBuyProductID'] = $this->transCanBuyList($data);
        dd($dataF);
    }
    private $mappingArr = array(
        'dtsweb.app.item_90'   => '108',//至尊宝箱
        'dtsweb.app.item2_150' => '109',//VIP卡
        'dtsweb.app.item2_590' => '110',//尊贵VIP卡
        'dtsweb.app.item1_90'  => '111',//周卡
        'dtsweb.app.item_30'   => '113',//奇迹宝箱
        'dtsweb.app.item_150'  => '114',//高级奇迹宝箱
        'dtsweb.app.item_270'  => '115',//特级奇迹宝箱
        'dtsweb.app.item_1490' => '116',//超级奇迹宝箱
        'dtsweb.app.item1_210' => '118',//至尊月卡
    );
    private function transCanBuyList($data)
    {

        $mappingArr = array_flip($this->mappingArr);
        $canBuyProductID = array(110,108,109,114,115);

        $arr = array();
        foreach ($canBuyProductID as $value) {
          $arr[] = $mappingArr[$value];
        }
        return $arr;
    }

    public function object()
    {
        $arr = array();
        for($i = 0; $i < 3; $i++) {
            $obj = new BootController();
            $arr[] = $obj;
        }
        foreach ($arr as $item) {
            var_dump( $item instanceof BootController);
        }
    }
}
