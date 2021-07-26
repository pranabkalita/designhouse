<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\IUser;
use App\Repositories\Eloquent\BaseRepository;

class UserRepository extends BaseRepository implements IUser
{
  public function __construct(User $user)
  {
    parent::__construct($user);
  }

  public function all()
  {
    return $this->model->get();
  }
}
