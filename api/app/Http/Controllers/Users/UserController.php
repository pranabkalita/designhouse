<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Contracts\IUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
  protected $iUser;

  public function __construct(IUser $iUser)
  {
    $this->iUser = $iUser;
  }

  public function index()
  {
    $users = $this->iUser->all();

    return UserResource::collection($users);
  }
}
