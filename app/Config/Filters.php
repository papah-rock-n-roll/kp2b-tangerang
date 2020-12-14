<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
	// Makes reading things below nicer,
	// and simpler to change out script that's used.
	public $aliases = [
		'csrf'     => \CodeIgniter\Filters\CSRF::class,
		'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
		'honeypot' => \CodeIgniter\Filters\Honeypot::class,
		'auth' => \App\Filters\Auth::class,
		'acts' => \App\Filters\Acts::class,
		'cors' => \App\Filters\Cors::class,
	];

	// Always applied before every request
	public $globals = [
		'before' => [
			'cors' => [
				'except' => ['cli*','api/geo/info*','api/geo/obsdetail*','api/geo/kecamatan*','api/geo/desa*','api/report*']
			],
			//'honeypot'
		],
		'after'  => [
			'toolbar',
			'cors' => [
				'except' => ['cli*','api/geo/info*','api/geo/obsdetail*','api/geo/kecamatan*','api/geo/desa*','api/report*']
			],
			//'honeypot'
		],
	];

	// Works on all of a particular HTTP method
	// (GET, POST, etc) as BEFORE filters only
	//     like: 'post' => ['CSRF', 'throttle'],
	public $methods = [];

	// List filter aliases and any before/after uri patterns
	// that they should run on, like:
	//    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
	public $filters = [
		'csrf' => ['before' => [
			'login','register','administrator/*'
			]
		],
		'auth' => [
			'before' => [
				'api/subdist*','api/farmers*','api/owners*','api/respondens*','api/observation*','api/plantdates*',
				'administrator/*'
			],
			'after'=> [
				'api/subdist*','api/farmers*','api/owners*','api/respondens*','api/observation*','api/plantdates*',
				'administrator/*'
			],
		],
		'acts' => ['before' => [
			'api/subdist*','api/farmers*','api/owners*','api/respondens*','api/observation*','api/plantdates*',
			'administrator/*'
			]
		],
	];
}
