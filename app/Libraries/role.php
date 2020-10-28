<?php namespace App\Libraries;
 
class Role
{
  public static function modules($roleid)
  {
    $db = \Config\Database::connect();

    $query = "SELECT rolemodules FROM mstr_role WHERE roleid = {$roleid};";
    $data = $db->query($query)->getRowArray();

    $module = explode(',', $data['rolemodules']);
    $modules = array_values($module);

    $menus = array(
      'access' => ['management','setting','log'],
      'user' => ['account','profile'],
      'data' => ['owner','farmer','responden'],
      'geo' => ['subdistrict','village'],
      'report' => ['graph','table'],
    );

    $count = min(count($modules), count($menus));
    $menus = array_combine(array_slice($modules, 0, $count), array_slice($menus, 0, $count));

    return $menus;
  }

}