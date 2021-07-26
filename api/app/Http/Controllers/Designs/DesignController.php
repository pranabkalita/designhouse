<?php

namespace App\Http\Controllers\Designs;

use App\Models\Design;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DesignResource;
use App\Repositories\Contracts\IDesign;
use App\Repositories\Eloquent\Criteria\IsLive;
use App\Repositories\Eloquent\Criteria\LatestFirst;
use Illuminate\Support\Facades\Storage;

class DesignController extends Controller
{
  protected $iDesign;

  public function __construct(IDesign $iDesign)
  {
    $this->iDesign = $iDesign;
  }

  public function index()
  {
    $designs = $this->iDesign->withCriteria([
      new LatestFirst, new IsLive
    ])->all();

    return DesignResource::collection($designs);
  }

  public function findDesign($id)
  {
    $design = $this->iDesign->find($id);

    return new DesignResource($design);
  }

  public function update(Request $request, $id)
  {
    $design = $this->iDesign->find($id);

    $this->authorize('update', $design);

    $this->validate($request, [
      'title' => 'required|unique:designs,title,' . $design->id,
      'description' => 'required|string|min:20|max:140',
      'is_live' => 'nullable|boolean',
      'tags' => 'required'
    ]);

    $design = $this->iDesign->update($id, [
      'title' => $request->title,
      'description' => $request->description,
      'is_live' => !$design->upload_successful ? false : $request->is_live
    ]);

    // apply the tags
    $this->iDesign->applyTags($id, $request->tags);

    return new DesignResource($design);
  }

  public function destroy($id)
  {
    $design = $this->iDesign->find($id);

    $this->authorize('delete', $design);

    // delete the files associated to the record
    collect(['ORIGINAL_FILE', 'THUMBNAIL_FILE', 'LARGE_FILE'])->each(function($size) use ($design) {
      // check if the file exists in the storage
      $path = ltrim(Design::$PUBLIC_LOCATION[$size], '/') . $design->image;
      if (Storage::disk($design->disk)->exists($path)) {
        Storage::disk($design->disk)->delete($path);
      };
    });

    $this->iDesign->delete($id);

    return response()->json(['message' => 'Record Deleted.'], 204);
  }
}
