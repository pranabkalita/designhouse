<?php

namespace App\Repositories\Eloquent;

use App\Models\Design;
use App\Repositories\Contracts\IDesign;
use App\Repositories\Eloquent\BaseRepository;

class DesignRepository extends BaseRepository implements IDesign
{
  public function __construct(Design $design)
  {
    parent::__construct($design);
  }

  public function applyTags($id, $data)
  {
    $design = $this->find($id);
    $design->retag($data);
  }
}
