<?php

//无限极分类
function tree(&$data, $parent_id = 0, $count = 1)
{
    static $result = array();
    foreach ($data as $key => $value) {
        if ($value['parent_id'] == $parent_id) {
            $value['count'] = $count;
            $result[] = $value;
            unset($data[$key]);
            tree($data, $value['id'], $count + 1);
        }
    }
    return $result;
}

//无限分类缩进
function category_indent($count)
{
    $space = "";
    for ($i = 1; $i < $count; $i++) {
        $space .= "&nbsp;&nbsp;&nbsp;&nbsp;";
    }
    return $space;
}

//订单状态信息
function order_status($status)
{
    $info = config('wyshop.order_status');
    return $info["$status"];
}

//快递信息

function express_info()
{
    $typeCom = "shentong";//快递公司
    $typeNu = "968395143054";  //快递单号

    $AppKey = 'e162f48003397f70';//请将XXXXXX替换成您在http://kuaidi100.com/app/reg.html申请到的KEY
    $url = 'http://api.kuaidi100.com/api?id=' . $AppKey . '&com=' . $typeCom . '&nu=' . $typeNu . '&show=2&muti=1&order=desc';

//请勿删除变量$powered 的信息，否者本站将不再为你提供快递接口服务。
    $powered = '查询数据由：<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a> 网站提供 ';

//优先使用curl模式发送数据
    if (function_exists('curl_init') == 1) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        $get_content = curl_exec($curl);
        curl_close($curl);
    }

    print_r($get_content . '<br/>' . $powered);
}
