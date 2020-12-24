<?php namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', function () {
	if (ENVIRONMENT !== 'development')
	{
		if (ini_get('zlib.output_compression'))
		{
			throw FrameworkException::forEnabledZlibOutputCompression();
		}

		while (ob_get_level() > 0)
		{
			ob_end_flush();
		}

		# ob_start(function ($buffer) {
		#		return $buffer;
		# });

	 /*
		* --------------------------------------------------------------------
		* Minify html css js - output
		* --------------------------------------------------------------------
		*/
		ob_start(function ($buffer) {
			$search = array(
				'/\n/',      // replace end of line by a <del>space</del> nothing , if you want space make it down ' ' instead of ''
				'/\>[^\S ]+/s',    // strip whitespaces after tags, except space
				'/[^\S ]+\</s',    // strip whitespaces before tags, except space
				'/(\s)+/s',    // shorten multiple whitespace sequences
				'/<!--(.|\s)*?-->/', //remove HTML comments
			);

			$replace = array(
				'',
				'>',
				'<',
				'\\1',
				''
			);

			$buffer = preg_replace($search, $replace, $buffer);
			return $buffer;
		});
	}

	/*
	 * --------------------------------------------------------------------
	 * Debug Toolbar Listeners.
	 * --------------------------------------------------------------------
	 * If you delete, they will no longer be collected.
	 */
	if (ENVIRONMENT !== 'production')
	{
		Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
		Services::toolbar()->respond();
	}
});

/**
	* --------------------------------------------------------------------
	* Events Login - Logout | Model M_log
	* --------------------------------------------------------------------
 	* 
	*/
Events::on('post_system', function()
{
	$request = service('request');
	$control = $request->uri->getSegment(1);

	$data = $request->getPost();
	$logs = new \App\Models\Adminpanel\Access\M_log;

	if($request->getMethod() === 'post')
	{
		switch ($control) {

			case 'login':

				$watch = 'login';
				$table = 'mstr_users';
				$logs->login_post($watch, $table, $data);

			break;

			#	case 'register':

			#		$watch = 'register';
			#		$table = 'mstr_users';
			#		$logs->register_post($watch, $table, $data);

			#	break;

		}
	}
	else
	{
		switch ($control) {

			case 'logout':

				$watch = 'logout';
				$table = 'mstr_users';
				$logs->logout_post($watch, $table, $data);

			break;

		}
	}
});

/**
	* --------------------------------------------------------------------
	* Events Adminpanel - Method Post, Get | Model M_log
	* --------------------------------------------------------------------
 	* 
	*/
Events::on('post_controller_constructor', function()
{
	$request = service('request');
	$control = $request->uri->getSegment(1);
	$uri = $request->uri->getSegments();
	
	switch ($control) {

		case 'administrator':

			$logs = new \App\Models\Adminpanel\Access\M_log;

			if($request->getMethod() === 'post')
			{
				$data = $request->getPost();

				if(count($uri) < 5)
					$id = null;
				else $id = array_pop($uri);

				$logs->log_informations_post($uri, $id, $data);

			}
			else
			{
				if(in_array('export', $uri)) 
				{
					$data = $request->getGet();
					$logs->log_informations_post($uri, null, $data);
				}
			}

		break;	
			
	}

});

/**
	* --------------------------------------------------------------------
	* Events Ajax - Method Post, Put, Delete | Model M_log
	* --------------------------------------------------------------------
 	* 
	*/
Events::on('ajax_event', function($action, $table, $id = null, $data = null) {
	$logs = new \App\Models\Adminpanel\Access\M_log;
	$logs->create_post($action, $table, $id, $data);
});


/**
	* --------------------------------------------------------------------
	* Events Submodule - Watch | Model M_log
	* --------------------------------------------------------------------
 	* 
	*/
Events::on('watch_event', function($watch, $table, $idData = null, $postData = null) {
	$logs = new \App\Models\Adminpanel\Access\M_log;
	$logs->event_post($watch, $table, $idData, $postData);
});