<?php
return [
    'use_alias'    => env('WECHAT_USE_ALIAS', false),
    'app_id'       => env('WECHAT_APPID', 'wx4e19e04fe3d75959'), // 必填
    'secret'       => env('WECHAT_SECRET', '13e1c42de4b27e00892faf1f226c3145'), // 必填
    'token'        => env('WECHAT_TOKEN', 'whphp'),  // 必填
    'encoding_key' => env('WECHAT_ENCODING_KEY', '9JetIIM4eoluQS1xEFQCn9sKqJIh3iuI4IT3lRZFM13') // 加密模式需要，其它模式不需要
];