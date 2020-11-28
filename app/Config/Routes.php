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

/**
 * --------------------------------------------------------------------
 * API Base URL
 * Lihat Controller Api
 * --------------------------------------------------------------------
 */
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
	$routes->resource('geo');
	$routes->resource('respondens');
	$routes->resource('owners');
	$routes->resource('farmers');
	$routes->resource('subdist');
	$routes->resource('observation');
});

/**
 * --------------------------------------------------------------------
 * CLI Base Route
 * Lihat Controller Cli
 * --------------------------------------------------------------------
 */
$routes->group('cli', ['namespace' => 'App\Controllers\Cli'], function($routes) {

	// Access log
	$routes->cli('writable/delete/(:any)', 'Access::writable_delete/$1');
	$routes->cli('cache/delete/(:any)', 'Access::cache_delete/$1');

	// Geo Public
	$routes->cli('geo/cache/(:any)/(:any)', 'Geo::cache_geojson/$1/$2');
	$routes->cli('geo/cache/kecamatan', 'Geo::kecamatan_geojson');
	$routes->cli('geo/cache/kelurahan', 'Geo::kelurahan_geojson');
});


/**
 * --------------------------------------------------------------------
 * Public Home
 * --------------------------------------------------------------------
 */

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

/**
 * --------------------------------------------------------------------
 * Administrator Home
 * --------------------------------------------------------------------
 */

$routes->group('administrator', function($routes) {

	// REDIRECT MODULE PANEL
	$routes->addRedirect('', 'administrator/dashboard');

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
			$routes->add('read', function() {
				echo '<script>javascript:window.history.go(-2)</script>';
			});

			$routes->add('update', function() {
				$uri = new \CodeIgniter\HTTP\URI(session('_ci_previous_url'));
				$get = $uri->getQuery(['only' => ['post']]);
				$pos = substr($get, strpos($get, '=') + 1);
				$def = 2;
				echo '<script>javascript:window.history.go(-'.($def += $pos).')</script>';
			});
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

		// Access Log
		$routes->group('log', function($routes) {
			$routes->get('', 'Adminpanel\Access::log_index');
			$routes->get('read/(:any)', 'Adminpanel\Access::log_read/$1');
			$routes->get('delete/(:any)', 'Adminpanel\Access::log_delete/$1');
			// REDIRECT MODULE PANEL
			$routes->addRedirect('read', 'administrator/access/log');
		});

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

			// Main route
			$routes->get('', 'Adminpanel\Data::observation_index');
			$routes->get('read/(:any)', 'Adminpanel\Data::observation_read/$1');
			$routes->match(['get', 'post'], 'update/(:any)', 'Adminpanel\Data::observation_update/$1', ['as' => 'update']);

			# TIDAK TERPAKAI
			// $routes->match(['get', 'post'], 'create', 'Adminpanel\Data::observation_create');
			// $routes->get('delete/(:num)', 'Adminpanel\Data::observation_delete/$1');

				// Upload - Import
				$routes->match(['get', 'post'], 'upload', 'Adminpanel\Data::observation_upload');
				$routes->post('import', 'Adminpanel\Data::observation_import');
				// Export
				$routes->get('export', 'Adminpanel\Data::observation_export');

			// REDIRECT MODULE PANEL
			$routes->add('read', function() {
				echo '<script>javascript:window.history.go(-2)</script>';
			});

			$routes->add('update', function() {
				$uri = new \CodeIgniter\HTTP\URI(session('_ci_previous_url'));
				$get = $uri->getQuery(['only' => ['post']]);
				$pos = substr($get, strpos($get, '=') + 1);
				$def = 2;
				echo '<script>javascript:window.history.go(-'.($def += $pos).')</script>';
			});

			$routes->addRedirect('create', 'administrator/data/observation');
			$routes->addRedirect('delete', 'administrator/data/observation');			
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
				// Upload - Import
				$routes->match(['get', 'post'], 'upload', 'Adminpanel\Data::owner_upload');
				$routes->post('import', 'Adminpanel\Data::owner_import');
				// Export
				$routes->get('export', 'Adminpanel\Data::owner_export');
			// REDIRECT MODULE PANEL
			$routes->add('update', function() {
				$uri = new \CodeIgniter\HTTP\URI(session('_ci_previous_url'));
				$get = $uri->getQuery(['only' => ['post']]);
				$pos = substr($get, strpos($get, '=') + 1);
				$def = 2;
				echo '<script>javascript:window.history.go(-'.($def += $pos).')</script>';
			});
		});


		// Data Farmer - Poktan
		$routes->group('farmer', function($routes) {
			$routes->get('', 'Adminpanel\Data::farmer_index');
			$routes->match(['get', 'post'], 'create', 'Adminpanel\Data::farmer_create');
			$routes->match(['get', 'post'], 'update/(:num)', 'Adminpanel\Data::farmer_update/$1');
			$routes->get('delete/(:num)', 'Adminpanel\Data::farmer_delete/$1');
				// Upload - Import
				$routes->match(['get', 'post'], 'upload', 'Adminpanel\Data::farmer_upload');
				$routes->post('import', 'Adminpanel\Data::farmer_import');
				// Export
				$routes->get('export', 'Adminpanel\Data::farmer_export');
			// REDIRECT MODULE PANEL
			$routes->add('update', function() {
				$uri = new \CodeIgniter\HTTP\URI(session('_ci_previous_url'));
				$get = $uri->getQuery(['only' => ['post']]);
				$pos = substr($get, strpos($get, '=') + 1);
				$def = 2;
				echo '<script>javascript:window.history.go(-'.($def += $pos).')</script>';
			});
		});


		// Data Responden
		$routes->group('responden', function($routes) {
			$routes->get('', 'Adminpanel\Data::responden_index');
			$routes->match(['get', 'post'], 'create', 'Adminpanel\Data::responden_create');
			$routes->match(['get', 'post'], 'update/(:any)', 'Adminpanel\Data::responden_update/$1');
			$routes->get('delete/(:num)', 'Adminpanel\Data::responden_delete/$1');
			// REDIRECT MODULE PANEL
			$routes->add('update', function() {
				$uri = new \CodeIgniter\HTTP\URI(session('_ci_previous_url'));
				$get = $uri->getQuery(['only' => ['post']]);
				$pos = substr($get, strpos($get, '=') + 1);
				$def = 2;
				echo '<script>javascript:window.history.go(-'.($def += $pos).')</script>';
			});
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
			// Upload - Import
			$routes->match(['get', 'post'], 'upload', 'Adminpanel\Geo::observation_upload');
			$routes->post('import', 'Adminpanel\Geo::observation_import');
			// Export
			$routes->get('export/(:num)', 'Adminpanel\Geo::observation_export/$1');
		});

		// Geo Village
		$routes->get('village', 'Adminpanel\Geo::village_index');

		// Geo Subdistrict
		$routes->get('subdistrict', 'Adminpanel\Geo::subdistrict_index');

	});


/**
 * --------------------------------------------------------------------
 * Report Module
 * --------------------------------------------------------------------
 */

	$routes->group('report', function($routes) {
		// Report Graph
		$routes->get('graph', 'Adminpanel\Report::graph_index');

		// Report table
		$routes->get('table', 'Adminpanel\Report::table_index');
	});

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
