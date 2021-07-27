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

  public function addComment($designId, array $data)
  {
    // get the design for which we want to create a comment
    $design = $this->find($designId);

    // create the comment fro the design
    $comment = $design->comments()->create($data);

    return $comment;
  }

  public function like($id)
  {
    $design = $this->model->findOrFail($id);

    if($design->isLikedByUser(auth()->id())) {
      $design->unlike();
    } else {
      $design->like();
    }
  }

  public function hasLikedByUser($id)
  {
    $design = $this->model->findOrFail($id);

    return $design->isLikedByUser(auth()->id());
  }
}
