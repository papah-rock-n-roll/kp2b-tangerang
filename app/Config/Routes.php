<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override('App\Errors::show404');
$routes->setAutoRoute(false);

// Will display a custom view
$routes->set404Override(function() {
  echo view('errors/html/error_404');
});

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// Public Home
$routes->get('/', 'Home::index');
$routes->get('/data', 'Home::data');
$routes->get('/chart', 'Home::chart');

// Auth login
$routes->get('/login', 'Auth::index');
$routes->match(['get', 'post'], '/login', 'Auth::login');
$routes->match(['get', 'post'], '/register', 'Auth::register');
$routes->get('/logout', 'Auth::logout');
$routes->get('/block', 'Auth::block');

// REDIRECT MODULE PANEL
$routes->addRedirect('administrator', 'administrator/dashboard');


$routes->group('administrator', function($routes) {
	
	// Main Module
	$routes->get('dashboard', 'Adminpanel\Dashboard::index');
	$routes->get('access', 'Adminpanel\Access::index');
	$routes->get('user', 'Adminpanel\User::index');
	$routes->get('data', 'Adminpanel\Data::index');
	$routes->get('geo', 'Adminpanel\Geo::index');
	$routes->get('report', 'Adminpanel\Report::index');


/**
 * --------------------------------------------------------------------
 * Access Module
 * --------------------------------------------------------------------
 */

	$routes->group('access', function($routes) {
	
		// Access Management
		$routes->group('management', function($routes) {
			$routes->get('', 'Adminpanel\Access::management_index');
			$routes->get('read/(:num)', 'Adminpanel\Access::management_read/$1');
			$routes->match(['get', 'post'], 'create', 'Adminpanel\Access::management_create');
			$routes->match(['get', 'post'], 'update/(:num)', 'Adminpanel\Access::management_update/$1');
			$routes->get('delete/(:num)', 'Adminpanel\Access::management_delete/$1');
			// REDIRECT MODULE PANEL
			$routes->addRedirect('update', 'administrator/access/management');
		});

		// Access Setting
		$routes->group('setting', function($routes) {
			$routes->get('', 'Adminpanel\Access::setting_index');
			$routes->match(['get', 'post'], 'create', 'Adminpanel\Access::setting_create');
			$routes->match(['get', 'post'], 'update/(:num)', 'Adminpanel\Access::setting_update/$1');
			$routes->get('delete/(:num)', 'Adminpanel\Access::setting_delete/$1');
			// REDIRECT MODULE PANEL
			$routes->addRedirect('update', 'administrator/access/management');
		});

		$routes->get('log', 'Adminpanel\Access::log');

	});


/**
 * --------------------------------------------------------------------
 * User Module
 * --------------------------------------------------------------------
 */

	$routes->group('user', function($routes) {

		// REDIRECT MODULE PANEL
		$routes->addRedirect('account', 'administrator/user/account/update');
		// User Account
		$routes->get('account/update', 'Adminpanel\User::user_get');
		$routes->post('account/update/(:num)', 'Adminpanel\User::user_update/$1');

	});


/**
 * --------------------------------------------------------------------
 * Data Module
 * --------------------------------------------------------------------
 */

	$routes->group('data', function($routes) {

		// Data Observation - Petak
		$routes->group('observation', function($routes) {
			$routes->get('', 'Adminpanel\Data::observation_index');
			$routes->get('read/(:num)', 'Adminpanel\Data::observation_read/$1');
			$routes->match(['get', 'post'], 'create', 'Adminpanel\Data::observation_create');
			$routes->match(['get', 'post'], 'update/(:num)', 'Adminpanel\Data::observation_update/$1');
			$routes->get('delete/(:num)', 'Adminpanel\Data::observation_delete/$1');
			// REDIRECT MODULE PANEL
			$routes->addRedirect('update', 'administrator/data/observation');
			$routes->addRedirect('plantdate', 'administrator/data/observation');

			// Data Observation Plantdates
			$routes->match(['get', 'post'], 'plantdate/(:num)', 'Adminpanel\Data::observation_plantdates/$1');
		});


		// Data Owner - Pemilik / Penggarap
		$routes->group('owner', function($routes) {
			$routes->get('', 'Adminpanel\Data::owner_index');
			$routes->match(['get', 'post'], 'create', 'Adminpanel\Data::owner_create');
			$routes->match(['get', 'post'], 'update/(:num)', 'Adminpanel\Data::owner_update/$1');
			$routes->get('delete/(:num)', 'Adminpanel\Data::owner_delete/$1');
			// REDIRECT MODULE PANEL
			$routes->addRedirect('update', 'administrator/data/owner');
		});


		// Data Farmer - Poktan
		$routes->group('farmer', function($routes) {
			$routes->get('', 'Adminpanel\Data::farmer_index');
			$routes->match(['get', 'post'], 'create', 'Adminpanel\Data::farmer_create');
			$routes->match(['get', 'post'], 'update/(:num)', 'Adminpanel\Data::farmer_update/$1');
			$routes->get('delete/(:num)', 'Adminpanel\Data::farmer_delete/$1');
			// REDIRECT MODULE PANEL
			$routes->addRedirect('update', 'administrator/data/farmer');
		});


		// Data Responden
		$routes->group('responden', function($routes) {
			$routes->get('', 'Adminpanel\Data::responden_index');
			$routes->match(['get', 'post'], 'create', 'Adminpanel\Data::responden_create');
			$routes->match(['get', 'post'], 'update/(:any)', 'Adminpanel\Data::responden_update/$1');
			$routes->get('delete/(:num)', 'Adminpanel\Data::responden_delete/$1');
			// REDIRECT MODULE PANEL
			$routes->addRedirect('update', 'administrator/data/responden');
		});

	});


/**
 * --------------------------------------------------------------------
 * Geo Module
 * --------------------------------------------------------------------
 */

	$routes->group('geo', function($routes) {

		// Geo Observation
		$routes->group('observation', function($routes) {
			$routes->get('', 'Adminpanel\Geo::observation_index');
			$routes->get('read/(:num)', 'Adminpanel\Geo::observation_read/$1');
			$routes->match(['get', 'post'], 'create', 'Adminpanel\Geo::observation_create');
			$routes->match(['get', 'post'], 'update/(:num)', 'Adminpanel\Geo::observation_update/$1');
			$routes->get('delete/(:num)', 'Adminpanel\Geo::observation_delete/$1');
		});

		// Geo Village
		$routes->group('village', function($routes) {
			$routes->get('', 'Adminpanel\Geo::village_index');
			$routes->get('read/(:num)', 'Adminpanel\Geo::village_read/$1');
			$routes->match(['get', 'post'], 'create', 'Adminpanel\Geo::village_create');
			$routes->match(['get', 'post'], 'update/(:num)', 'Adminpanel\Geo::village_update/$1');
			$routes->get('delete/(:num)', 'Adminpanel\Geo::village_delete/$1');
		});

		// Data Subdistrict
		$routes->group('subdistrict', function($routes) {
			$routes->get('', 'Adminpanel\Geo::subdistrict_index');
			$routes->get('read/(:num)', 'Adminpanel\Geo::subdistrict_read/$1');
			$routes->match(['get', 'post'], 'create', 'Adminpanel\Geo::subdistrict_create');
			$routes->match(['get', 'post'], 'update/(:num)', 'Adminpanel\Geo::subdistrict_update/$1');
			$routes->get('delete/(:num)', 'Adminpanel\Geo::subdistrict_delete/$1');
		});

	});


/**
 * --------------------------------------------------------------------
 * Report Module
 * --------------------------------------------------------------------
 */




});





$routes->group('restapi', function($routes) {
	$routes->resource('farmer');
		

});

/**
 * --------------------------------------------------------------------
 * API Base URL
 * 
 * Lihat Config App Baseurl
 * 
 * Lihat Controller Api
 * --------------------------------------------------------------------
 */
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {

	$routes->resource('geo');
	$routes->resource('owners');
	
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
