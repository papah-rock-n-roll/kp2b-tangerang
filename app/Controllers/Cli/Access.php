<?php namespace App\Controllers\Cli;
 
class Access extends \App\Controllers\BaseController
{

  public function writable_delete($name)
  {
    $this->M_log->delete_post($name);
  }

}