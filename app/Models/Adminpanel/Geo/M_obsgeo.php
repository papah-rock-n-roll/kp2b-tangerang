<?php namespace App\Models\Adminpanel\Geo;

/**
 * --------------------------------------------------------------------
 *
 * Geo Observation
 *
 * --------------------------------------------------------------------
 */

class M_obsgeo extends M_geo
{
  const VIEW = 'adminpanel/geo/observation/';

  const UPLOAD = 'geo/upload';
  const EXPORT = 'geo/export';

  public function list($village = null, $keyword = null, $data, $paginate)
  {
    $where = array();
    $like = array();
    $orLike = array();

    // Berdasarkan value $_['GET'] paginate, jika paginate null maka menjadi 8
    if(empty($paginate)) {
      $paginate = 8;
    }

    // Masukan Value berdarakan Array Assoc
    $data['keyword'] = $keyword;
    $data['page'] = $paginate;

    // Jika Tidak null maka like obscode = $_['GET'] keyword
    if(!empty($keyword)) {
      $like = ['v_observations.obscode' => $keyword];
    }

    $data += [
      'list' => $this->getObservations($where, $like, $orLike, $paginate),
      'pager' => $this->pager,
      'import' => self::UPLOAD,
      'export' => self::EXPORT,
    ];
    echo view(self::VIEW.'list', $data);
  }

/**
 * --------------------------------------------------------------------
 * Query
 * --------------------------------------------------------------------
 */
  public function getObservations($where = null, $like = null, $orLike = null, $paginate = 5)
  {
    $query = $this->select('obscode, sdname, vlname, farmname, ownername, cultivatorname')
    ->where($where)->like($like)->orLike($orLike)
    ->orderBy('obscode ASC');

    return $query->paginate($paginate, 'default');
  }

}