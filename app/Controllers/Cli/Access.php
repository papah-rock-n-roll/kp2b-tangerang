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
 *  :\> php public\index.php cli cache delete *.cache
 *
 * --------------------------------------------------------------------
 */
 
class Access extends \App\Controllers\BaseController
{

  public function writable_delete($name)
  {
    $this->M_log->delete_post($name);
  }

  public function cache_delete(string $ext = null)
  {
    $this->M_log->delete_post('cache', $ext);
  }

}