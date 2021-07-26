<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\ModelNotDefined;
use App\Repositories\Contracts\IBase;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements IBase
{
  protected $model;

  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function all()
  {
    return $this->model->all();
  }

  public function find($id)
  {
    $result = $this->model->findOrFail($id);

    return $result;
  }

  public function findWhere($column, $value) {
    return $this->model->where($column, $value)->get();
  }

  public function findWhereFist($column, $value) {
    return $this->model->where($column, $value)->firstOrFail();
  }

  public function paginate($perPage = 10) {
    return $this->model->paginate($perPage);
  }

  public function create(array $data) {
    return $this->model->create($data);
  }

  public function update($id, array $data) {
    $record = $this->find($id);
    $record->update($data);

    return $record;
  }

  public function delete($id) {
    $record = $this->find($id);

    return $record->delete();
  }
}
