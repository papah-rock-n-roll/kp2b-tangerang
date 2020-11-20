<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['url','form','cookie','filesystem'];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		$this->session = \Config\Services::session();
		$this->validation = \Config\Services::validation();


		// Public
		$this->M_geophp = model('App\Models\M_geophp');
		$this->M_auth = model('App\Models\M_auth');

		// Admin Panel
		$this->M_dashboard = model('App\Models\Adminpanel\M_dashboard');

		// Access Panel
		$this->M_access = model('App\Models\Adminpanel\Access\M_access');
		$this->M_management = model('App\Models\Adminpanel\Access\M_management');
		$this->M_setting = model('App\Models\Adminpanel\Access\M_setting');
		$this->M_log = model('App\Models\Adminpanel\Access\M_log');

		// User Panel
		$this->M_user = model('App\Models\Adminpanel\User\M_user');

		// Data Panel
		$this->M_data = model('App\Models\Adminpanel\Data\M_data');
		//-- 1
		$this->M_observation = model('App\Models\Adminpanel\Data\M_observation');
		$this->M_plantdate = model('App\Models\Adminpanel\Data\M_plantdate');
		//-- 2
		$this->M_owner = model('App\Models\Adminpanel\Data\M_owner');
		$this->M_farmer = model('App\Models\Adminpanel\Data\M_farmer');
		$this->M_responden = model('App\Models\Adminpanel\Data\M_responden');
		
		// Geo Panel
		$this->M_geo = model('App\Models\Adminpanel\Geo\M_geo');

	}

}
