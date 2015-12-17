<?php
function p($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

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
        $space .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
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





//商品属性部分,生成表单
//唯一input,没有删除按钮,没有价格
function build_input_only($a)
{


    $html = '<div class="am-g am-margin-top">
                    <div class="am-u-sm-4 am-u-md-2 am-text-right">' . $a->name . '</div>
                    <input type="hidden" name="attr_id_list[]" value="' . $a->id . '">
                    <input type="hidden" name="attr_price_list[]" value="">
                    <div class="am-u-sm-2 am-u-md-2 am-u-end">
                        <input type="text" class="am-input-sm" name="attr_value_list[]">
                    </div>
                </div>';

    return $html;
}

//单选input,有价格,可以增加
function build_input_check($a)
{

    $html = '<div class="am-g am-margin-top">
                    <div class="am-u-md-2 am-text-right">' . $a->name . '</div>
                    <div class="am-u-md-10">
                        <button type="button" class="am-btn am-btn-warning am-round add_attribute" data-id="'.$a->id.'"
                            <span class="am-icon-plus"> 新增</span>
                        </button>
                    </div>
                </div>

                <div class="am-g am-margin-top">
                    <div class="am-u-md-2 am-u-md-offset-2">
                        <input type="hidden" name="attr_id_list[]" value="' . $a->id . '">
                        <input type="text" class="am-input-sm" name="attr_value_list[]">
                    </div>


                    <div class="am-u-md-2">
                        <input type="text" class="am-input-sm money" name="attr_price_list[]" placeholder="属性价格">
                    </div>
                    <div class="am-u-md-2 am-u-end col-end">
                        <button type="button" class="am-btn am-btn-danger am-round trash0">
                            <span class="am-icon-trash"> 删除</span>
                        </button>
                    </div>
                </div>';
    return $html;
}

//动态增加表单
function add_input_check($a)
{

    $html = '
                <div class="am-g am-margin-top">
                    <div class="am-u-md-2 am-u-md-offset-2">
                        <input type="hidden" name="attr_id_list[]" value="' . $a->id . '">
                        <input type="text" class="am-input-sm" name="attr_value_list[]">
                    </div>


                    <div class="am-u-md-2">
                        <input type="text" class="am-input-sm money" name="attr_price_list[]" placeholder="属性价格">
                    </div>
                    <div class="am-u-md-2 am-u-end col-end">
                        <button type="button" class="am-btn am-btn-danger am-round trash1">
                            <span class="am-icon-trash"> 删除</span>
                        </button>
                    </div>
                </div>';
    return $html;
}



function build_select_only($a)
{
    $values = explode("\r\n", $a->value);

    $options = "<option value=''>请选择...</option>";
    foreach ($values as $v) {
        $options .= '<option value="' . $v . '">' . $v . '</option>';
    }
    $html = '<div class="am-g am-margin-top">
                    <div class="am-u-sm-4 am-u-md-2 am-text-right">' . $a->name . '</div>
                    <input type="hidden" name="attr_id_list[]" value="' . $a->id . '">
                    <input type="hidden" name="attr_price_list[]" value="">

                    <div class="am-u-sm-8 am-u-md-10">
                        <select class="att_select" name="attr_value_list[]">
                            ' . $options . '
                        </select>
                    </div>
                </div>';
    return $html;
}

function build_select_check($a)
{

    $values = explode("\r\n", $a->value);

    $options = "<option value=''>请选择...</option>";
    foreach ($values as $v) {
        $options .= '<option value="' . $v . '">' . $v . '</option>';
    }

    $html = '<div class="am-g am-margin-top">
                    <div class="am-u-md-2 am-text-right">' . $a->name . '</div>
                    <div class="am-u-md-10">
                        <button type="button" class="am-btn am-btn-warning am-round add_attribute" data-id="'.$a->id.'"
                            <span class="am-icon-plus"> 新增</span>
                        </button>
                    </div>
                </div>
                <div class="am-g am-margin-top">
                    <div class="am-u-md-2 am-u-md-offset-2">
                        <input type="hidden" name="attr_id_list[]" value="'. $a->id . '">
                        <select class="att_select" name="attr_value_list[]">
                            ' . $options . '
                        </select>
                    </div>

                    <div class="am-u-md-2">
                        <input type="text" class="am-input-sm money" name="attr_price_list[]" placeholder="属性价格">
                    </div>
                    <div class="am-u-md-2 am-u-end col-end">
                        <button type="button" class="am-btn am-btn-danger am-round trash0">
                            <span class="am-icon-trash"> 删除</span>
                        </button>
                    </div>
                </div>';
    return $html;

}


function add_select_check($a, $value="")
{

    $values = explode("\r\n", $a->value);

    $options = "<option value=''>请选择...</option>";
    foreach ($values as $v) {
        $options .= '<option value="' . $v . '">' . $v . '</option>';
    }

    $html = '
                <div class="am-g am-margin-top">
                    <div class="am-u-md-2 am-u-md-offset-2">
                        <input type="hidden" name="attr_id_list[]" value="'. $a->id . '">
                        <select class="att_select" name="attr_value_list[]">
                            ' . $options . '
                        </select>
                    </div>

                    <div class="am-u-md-2">
                        <input type="text" class="am-input-sm money" name="attr_price_list[]" placeholder="属性价格">
                    </div>
                    <div class="am-u-md-2 am-u-end col-end">
                        <button type="button" class="am-btn am-btn-danger am-round trash1">
                            <span class="am-icon-trash"> 删除</span>
                        </button>
                    </div>
                </div>';
    return $html;

}