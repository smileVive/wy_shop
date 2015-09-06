<?php
function tree(&$data, $parent_id = 0, $count = 1) {
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


function category_indent($count) {
    $space = "";
    for($i=1;$i<$count;$i++) {
        $space .= "&nbsp;&nbsp;&nbsp;&nbsp;";
    }
    return $space;
}