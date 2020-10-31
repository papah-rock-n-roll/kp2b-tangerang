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
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// Public Home
$routes->get('/', 'Home::index');

// Auth login
$routes->get('/login', 'Auth::index');
$routes->match(['get', 'post'], '/login', 'Auth::login');
$routes->match(['get', 'post'], '/register', 'Auth::register');
$routes->get('/logout', 'Auth::logout');

// Admin Panel
$routes->addRedirect('administrator', 'administrator/dashboard');
$routes->group('administrator', function($routes) {
	
	$routes->get('dashboard', 'Adminpanel\Dashboard::index');
	$routes->get('access', 'Adminpanel\Access::index');
	$routes->get('user', 'Adminpanel\User::index');
	$routes->get('data', 'Adminpanel\Data::index');
	$routes->get('geo', 'Adminpanel\Geo::index');
	$routes->get('report', 'Adminpanel\Report::index');

	// Access Module
	$routes->group('access', function($routes) {
	
		// Access Management
		$routes->group('management', function($routes) {



			$routes->get('', 'Adminpanel\Access::management_index');
			$routes->get('read/(:num)', 'Adminpanel\Access::management_read/$1');
			$routes->match(['get', 'post'], 'create', 'Adminpanel\Access::management_create');
			$routes->match(['get', 'post'], 'update/(:num)', 'Adminpanel\Access::management_update/$1');
			$routes->get('delete/(:num)', 'Adminpanel\Access::management_delete/$1');
		});

		$routes->get('setting', 'Adminpanel\Access::setting');
		$routes->get('log', 'Adminpanel\Access::log');

	});

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
