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
 *  :\> php public\index.php cli uploads delete folder
 * 
 * 
 *  :\> php public\index.php cli database dump path_file_name
 * 
 *  :\> php public\index.php cli database restore path_file_name
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

  public function uploads_delete(string $folder = null)
  {
    $this->M_log->delete_post('uploads', $folder);
  }

  public function database_dump(string $path = null)
  {
    $db = \Config\Database::connect();
    $folder = WRITEPATH .'uploads\databases';

    if (! file_exists($folder)) {
      mkdir($folder, 0777, true);
    }

    $file = $folder .'\\'. $path;
    exec("mysqldump -h {$db->hostname} --port={$db->port} -u {$db->username} --password={$db->password} {$db->database} > {$file}");
  }

  public function database_restore(string $path = null)
  {
    $db = \Config\Database::connect();
    $folder = WRITEPATH .'uploads\databases';

    if (! file_exists($folder)) {
      mkdir($folder, 0777, true);
    }

    $file = $folder .'\\'. $path;
    exec("mysq -h {$db->hostname} --port={$db->port} -u {$db->username} --password={$db->password} {$db->database} < {$file}");
  }

}