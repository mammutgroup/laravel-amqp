<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Define which configuration should be used
    |--------------------------------------------------------------------------
    */

    'use' => 'production',

    /*
    |--------------------------------------------------------------------------
    | AMQP properties separated by key
    |--------------------------------------------------------------------------
    */
    'properties' => [
        'production' => [
            'host'					=> env('RABBITMQ_HOST', 'localhost'),
            'port'          		=> env('RABBITMQ_PORT', 5672),
            'username'        		=> env('RABBITMQ_LOGIN', 'guest'),
            'password'        		=> env('RABBITMQ_PASSWORD', 'guest'),
            'vhost'           		=> env('RABBITMQ_VHOST', '/'),
            'connect_options' 		=> [],
            'ssl_options'     		=> [],

            'exchange'             	=> 'amq.'.env('RABBITMQ_EXCHANGE_TYPE', 'direct'),
            'exchange_type'        	=> env('RABBITMQ_EXCHANGE_TYPE', 'direct'),
            'exchange_passive'     	=> env('RABBITMQ_EXCHANGE_PASSIVE', false),
            'exchange_durable'     	=> env('RABBITMQ_EXCHANGE_DURABLE', true),
            'exchange_auto_delete' 	=> env('RABBITMQ_EXCHANGE_AUTODELETE', false),
            'exchange_internal'    	=> false,
            'exchange_nowait'      	=> false,
            'exchange_properties'  	=> [],


            'queue_force_declare' 	=> env('RABBITMQ_QUEUE_DECLARE_BIND', false),
            'queue_passive'       	=> env('RABBITMQ_QUEUE_PASSIVE', false),
            'queue_durable'       	=> env('RABBITMQ_QUEUE_DURABLE', true),
            'queue_exclusive'     	=> env('RABBITMQ_QUEUE_EXCLUSIVE', false),
            'queue_auto_delete'   	=> env('RABBITMQ_QUEUE_AUTODELETE', false),
            'queue_nowait'        	=> false,
            'queue_properties'    	=> ['x-ha-policy' => ['S', 'all']],

            'consumer_tag' 			=> '',
            'consumer_no_local'  	=> false,
            'consumer_no_ack'    	=> false,
            'consumer_exclusive' 	=> false,
            'consumer_nowait'    	=> false,
            'timeout'         		=> 0,
            'persistent'      		=> false,
        ],
    ],
];
