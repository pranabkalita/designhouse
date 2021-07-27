<?php

namespace App\Repositories\Contracts;

interface IDesign
{
  public function applyTags($id, $data);
  public function addComment($designId, array $data);
  public function like($id);
  public function hasLikedByUser($id);
}
