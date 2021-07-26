<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\IUser;
use App\Repositories\Eloquent\Criteria\EagerLoad;

class UserController extends Controller
{
  protected $iUser;

  public function __construct(IUser $iUser)
  {
    $this->iUser = $iUser;
  }

  public function index()
  {
    $users = $this->iUser->withCriteria([
      new EagerLoad('designs')
    ])->all();

    return UserResource::collection($users);
  }
}
