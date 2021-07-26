<?php

namespace App\Http\Controllers\Designs;

use App\Models\Design;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DesignResource;
use Illuminate\Support\Facades\Storage;

class DesignController extends Controller
{
  public function update(Request $request, Design $design)
  {
    $this->authorize('update', $design);

    $this->validate($request, [
      'title' => 'required|unique:designs,title,' . $design->id,
      'description' => 'required|string|min:20|max:140',
      'is_live' => 'nullable|boolean'
    ]);

    $design->update([
      'title' => $request->title,
      'description' => $request->description,
      'is_live' => !$design->upload_successful ? false : $request->is_live
    ]);

    return new DesignResource($design);
  }

  public function destroy(Design $design)
  {
    $this->authorize('delete', $design);

    // delete the files associated to the record
    collect(['ORIGINAL_FILE', 'THUMBNAIL_FILE', 'LARGE_FILE'])->each(function($size) use ($design) {
      // check if the file exists in the storage
      $path = ltrim(Design::$PUBLIC_LOCATION[$size], '/') . $design->image;
      if (Storage::disk($design->disk)->exists($path)) {
        Storage::disk($design->disk)->delete($path);
      };
    });

    $design->delete();

    return response()->json(['message' => 'Record Deleted.'], 204);
  }
}
