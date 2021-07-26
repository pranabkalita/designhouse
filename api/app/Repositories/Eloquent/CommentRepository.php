<?php

namespace App\Repositories\Eloquent;

use App\Models\Comment;
use App\Models\User;
use App\Repositories\Contracts\IComment;
use App\Repositories\Eloquent\BaseRepository;

class CommentRepository extends BaseRepository implements IComment
{
  public function __construct(Comment $comment)
  {
    parent::__construct($comment);
  }
}
