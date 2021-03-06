<?php defined('SYSPATH') or die('No direct script access.');
return array
(
	'memcache' => array
	(
		'driver'             => 'memcache',
		'default_expire'     => 3600,
		'compression'        => FALSE,              // Use Zlib compression (can cause issues with integers)
		'servers'            => array
		(
			array
			(
				'host'             => 'localhost',  // Memcache Server
				'port'             => 11211,        // Memcache port number
				'persistent'       => FALSE,        // Persistent connection
			),
		),
		'default_expire'     => 3600,
	),
	'memcachetag' => array
	(
		'driver'             => 'memcachetag',
		'default_expire'     => 3600,
		'compression'        => FALSE,              // Use Zlib compression (can cause issues with integers)
		'servers'            => array
		(
			array
			(
				'host'             => 'localhost',  // Memcache Server
				'port'             => 11211,        // Memcache port number
				'persistent'       => FALSE,        // Persistent connection
			),
		),
		'default_expire'     => 3600,
	),
	'apc'      => array
	(
		'driver'             => 'apc',
		'default_expire'     => 3600,
	),
	'sqlite'   => array
	(
		'driver'             => 'sqlite',
		'default_expire'     => 3600,
		'database'           => APPPATH.'cache/kohana-cache.sql3',
		'schema'             => 'CREATE TABLE caches(id VARCHAR(127) PRIMARY KEY, tags VARCHAR(255), expiration INTEGER, cache TEXT)',
		'default_expire'     => 3600,
	),
	'eaccelerator'           => array
	(
		'driver'             => 'eaccelerator',
	),
	'xcache'   => array
	(
		'driver'             => 'xcache',
		'default_expire'     => 3600,
	),
	'file'    => array
	(
		'driver'             => 'file',
		'cache_dir'          => APPPATH.'cache/.kohana_cache',
		'default_expire'     => 3600,
	),
	'multi_apc'      => array
	(
		'driver'             => 'apc',
		'default_expire'     => 3600,
	),
	'multi_sqlite'   => array
	(
		'driver'             => 'sqlite',
		'default_expire'     => 86400,
		'database'           => APPPATH.'cache/kohana-cache.sql3',
		'schema'             => 'CREATE TABLE caches(id VARCHAR(127) PRIMARY KEY, tags VARCHAR(255), expiration INTEGER, cache TEXT)',
		'default_expire'     => 3600,
	),
	'multi' => array
	(
		'driver'             => 'multi',
		'instances'          => array('multi_apc', 'multi_sqlite'),
	),
);