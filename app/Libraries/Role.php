<?php namespace App\Libraries;

class Role
{
  public static function modules($roleid)
  {
    $db = \Config\Database::connect();

    $query = "SELECT rolemodules FROM mstr_role WHERE roleid = {$roleid}";
    $data = $db->query($query)->getRowArray();

    $module = explode(',', $data['rolemodules']);

    // Base menu aplikasi KP2B untuk Nav dan Sidebar
    $menu = array(
      'access' => [
        'management' => 'management',
        'setting' => 'setting',
        'log' => 'log'
      ],
      'user' => [
        'account' => 'akun'
      ],
      'data' => [
        'observation' => 'petak',
        'owner' => 'pemilik',
        'farmer' => 'poktan',
        'responden'=> 'responden'
      ],
      'geo' => [
        'observation' => 'petak',
        'village' => 'desa',
        'subdistrict' => 'kecamatan',
      ],
      'report' => [],
    );

    // Trim menus sesuai rolemodules
    $menus = array();
    foreach ($menu as $k => $v) {
      foreach ($module as $mv) {
        if($k == $mv) {
          $menus[$mv] = $v;
        }
      }
    }

    return $menus;
  }

  public static function actions($roleid)
  {
    $db = \Config\Database::connect();

    $query = "SELECT `create`,`read`,`update`,`delete`,`import`,`export` FROM mstr_role WHERE roleid = {$roleid}";
    $data = $db->query($query)->getRowArray();

    // fetch acts sesuai role action
    $acts = array();
    foreach($data as $k => $v) {
      if($v == 1) {
        next($data);
      } else {
        $acts[] = $k;
      }
    }

    // disable action dengan memasukan template jquery .remove
    $disable = array();
    foreach ($acts as $v) {
      $disable[] = '$(".tmb-'.$v.'").remove();';
    }
    $actions = implode(PHP_EOL, $disable);

    $result = [
      'acts' => $acts,
      'actions' => $actions,
    ];

    return $result;
  }

}
