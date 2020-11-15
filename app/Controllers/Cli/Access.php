<?php namespace App\Controllers\Cli;

/**
 * --------------------------------------------------------------------
 * Command Line Access
 *
 *
 * - Custom delete writable folder = "session, cache, logs, debugbar"
 *
 *  :\> php public\index.php cli writable delete session
 *
 * --------------------------------------------------------------------
 */
 
class Access extends \App\Controllers\BaseController
{

  public function writable_delete($name)
  {
    $this->M_log->delete_post($name);
  }

}