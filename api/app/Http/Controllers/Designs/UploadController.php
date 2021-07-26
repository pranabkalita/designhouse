<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use App\Http\Resources\DesignResource;
use App\Jobs\UploadImage;
use App\Models\Design;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
  public function __invoke(Request $request)
  {
    // Validation
    $this->validate($request, [
      'image' => 'required|mimes:jpeg,gif,bmp,png|max:5120'
    ]);

    // get the image from the request
    $image = $request->file('image');
    $image_path = $image->getPathname();

    // get the original filename and replace spaces with underscore
    $filename = time() . '_' . Str::replace(' ', '_', Str::lower($image->getClientOriginalName()));

    // move the image to the temporary location (tmp)
    $tmp = $image->storeAs(Design::$TMP_LOCATION['ORIGINAL_FILE'], $filename, 'tmp');

    // create the database record for the design
    $design = $request->user()->designs()->create([
      'image' => $filename,
      'disk' => config('site.upload_disk')
    ]);

    // dispatch a job to handle the image manipulation
    $this->dispatch(new UploadImage($design));

    return new DesignResource($design);
  }
}
