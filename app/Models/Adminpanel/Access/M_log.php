<?php namespace App\Models\Adminpanel\Access;

/**
 * --------------------------------------------------------------------
 *
 * Access Log
 *
 * --------------------------------------------------------------------
 */
  
class M_log extends M_access
{
  const VIEW = 'adminpanel/access/log/';

  const ACTS = 'administrator/access/log/';
  const BACK = '/administrator/access/log';

  const DELETE = 'log/delete/';

  public function list()
  {
    $data = [
      'list' => $this->getlist(),
      'delete' => self::DELETE,
    ];

    echo view(self::VIEW.'list', $data);
  }

  public function delete_post($data, $ext = null)
  {
    switch ($data) {

      case 'session':
        return delete_files(WRITEPATH.'session');
        break;

      case 'cache':
        if (!empty($ext))
        {
          return array_map('unlink', glob(WRITEPATH .'cache/*.'. $ext));
        }
        else
        {
          return delete_files(WRITEPATH.'cache');
        }
        break;

      case 'logs':
        return delete_files(WRITEPATH.'logs');
        break;

      case 'debugbar':
        return delete_files(WRITEPATH.'debugbar');
        break;

    }

  }

  public function getlist()
  {
    $list = [
      ['id' => 1,'name' => 'session'], 
      ['id' => 2,'name' => 'cache'], 
      ['id' => 3,'name' => 'logs'],
      ['id' => 4,'name' => 'debugbar']
    ];

    return $list;
  }

}