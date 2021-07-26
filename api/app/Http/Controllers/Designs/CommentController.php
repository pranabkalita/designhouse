<?php

namespace App\Http\Controllers\Designs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Repositories\Contracts\IComment;
use App\Repositories\Contracts\IDesign;

class CommentController extends Controller
{
  protected $iComment;
  protected $iDesign;

  public function __construct(IComment $iComment, IDesign $iDesign)
  {
    $this->iComment = $iComment;
    $this->iDesign = $iDesign;
  }

  public function store(Request $request, $designId)
  {
    $this->validate($request, [
      'body' => 'required'
    ]);

    $comment = $this->iDesign->addComment($designId, [
      'body' => $request->body,
      'user_id' => auth()->id()
    ]);

    return new CommentResource($comment);
  }

  public function update(Request $request, $id)
  {
    $comment = $this->iComment->find($id);

    $this->authorize('update', $comment);

    $this->validate($request, [
      'body' => 'required'
    ]);

    $comment = $this->iComment->update($id, [
      'body' => $request->body
    ]);

    return new CommentResource($comment);
  }

  public function destroy($id)
  {
    $comment = $this->iComment->find($id);

    $this->authorize('delete', $comment);

    return $this->iComment->delete($id);
  }
}
