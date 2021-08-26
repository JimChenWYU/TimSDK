<?php

return [

	'defaults' => [
		/*
         * 使用 Laravel 的缓存系统
         */
		'use_laravel_cache' => true,

		/**
		 * http 客户端配置
		 */
		'http'       => [
			'timeout' => 30.0,
			'max_retries' => 2,
			'retry_delay' => 500,
		],

		/**
		 * 日志配置
		 */
		'log' => [
			'default' => 'single',
			'channels' => [
				'single' => [
					'driver' => 'single',
					'path'  => storage_path('logs/tim-sdk.log'),
					'level' => 'debug',
				],
			],
		],

		/**
		 * 事件监听
		 */
		'events' => [
			'listen' => [
				//
			],
		],
	],

    'options' => [
    	'default' => 'main',

	    'connections' => [
		    'main' => [
			    // 应用id
			    'app_id' => env('TIM_APP_ID'),
			    // 应用秘钥
			    'key' => env('TIM_KEY'),
			    // 默认管理员账号
			    'identifier' => 'administrator',
		    ],
	    ],
    ],
];
