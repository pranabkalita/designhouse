<?php

namespace App\Repositories\Contracts;

interface IDesign
{
  public function applyTags($id, $data);
  public function addComment($designId, array $data);
}
