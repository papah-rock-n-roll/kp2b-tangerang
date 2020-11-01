<?php namespace App\Libraries;
 
class Role
{
  public static function modules($roleid)
  {
    $db = \Config\Database::connect();

    $query = "SELECT rolemodules FROM mstr_role WHERE roleid = {$roleid}";
    $data = $db->query($query)->getRowArray();

    $module = explode(',', $data['rolemodules']);

    $menu = array(
      'access' => ['management','setting','log'],
      'user' => ['account','profile'],
      'data' => ['owner','farmer','responden'],
      'geo' => ['subdistrict','village'],
      'report' => ['graph','table'],
    );

    $menus = array();
    
    foreach ($menu as $k => $v) {
      foreach ($module as $mv) {
        if($k == $mv) {
          $menus[$mv] = $v;
        }
      }
    }

    //$offset = array_search($module[0], array_keys($menu));
    //$count = min(count($module), count($menu));
    //$menus = array_combine(array_slice($module, 0, $count), array_slice($menu, $offset, $count));

    return $menus;
  }

  public static function actions($roleid)
  {
    $db = \Config\Database::connect();

    $query = "SELECT `create`,`read`,`update`,`delete` FROM mstr_role WHERE roleid = {$roleid}";
    $data = $db->query($query)->getRowArray();

    $acts = array();

    foreach($data as $k => $v) {
      if($v == 1) { 
        next($data); 
      } else {
        $acts[] = $k;
      }
    }

    return $acts;
  }

}