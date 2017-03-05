<?php

return [
    'name'       => '首页',
    'index'      => 'welcome', // 导航页链接地址，routes 节点的键名
    'prefix'     => '', // 路由前缀
    'namespace' => 'App\Http\Controllers',
    'middleware' => [
        'web', 'guard.auth', 
        'guard.throttle', 'guard.log',
    ],
    'groups'     => [
        'Dashboard' => [
            'welcome',
            'home',
        ],
    ],
    'routes'     => [
        'welcome' => [
            'name'     => 'Welcome',
            'uri'      => '/',
            'method'   => 'get',
            'uses'     => 'HomeController@welcome',
            'limit-on' => true, // 权限开关，值为false 则登陆后不限制该功能,默认为 true
            'throttle' => 100, // 限制单用户最大访问次数，
            'log.file' => '【{{user.name}}】访问了操作 Welcome',
        ],
        'home'    => [
            'name'     => 'Home',
            'uri'      => '/home',
            'method'   => 'get',
            'uses'     => 'HomeController@home',
            'log.file' => '【{{user.name}}】访问了操作日志页',
        ],
    ],
];
