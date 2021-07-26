<?php

namespace App\Jobs;

use Exception;
use App\Models\Design;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $design;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Design $design)
    {
      $this->design = $design;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $disk = $this->design->disk;
      $original_file = storage_path() . Design::$TMP_LOCATION['ORIGINAL_FILE'] . $this->design->image;

      try {
        // create the large image and store to tmp disk
        $large_file = $this->resizeAndSaveImage($original_file, 800, 600, Design::$TMP_LOCATION['LARGE_FILE']);

        // create the thumbnail image and store to tmp disk
        $thumbnail_file = $this->resizeAndSaveImage($original_file, 250, 200, Design::$TMP_LOCATION['THUMBNAIL_FILE']);

        // store images to permanent disk
        // original image
        $this->moveImage($original_file, $disk, Design::$PUBLIC_LOCATION['ORIGINAL_FILE']);

        // large image
        $this->moveImage($large_file, $disk, Design::$PUBLIC_LOCATION['LARGE_FILE']);

        // thumbnail image
        $this->moveImage($thumbnail_file, $disk, Design::$PUBLIC_LOCATION['THUMBNAIL_FILE']);

        // Update the database record with success flag
        $this->design->update(['upload_successful' => true]);
      } catch (Exception $e) {
        Log::error($e->getMessage());
      }
    }

    protected function resizeAndSaveImage($file, $width, $height, $location) {
      Image::make($file)
        ->fit($width, $height, function($constraint) {
          $constraint->aspectRatio();
        })
        ->save($file = storage_path($location . $this->design->image));

      return $file;
    }

    protected function moveImage($originalFilePath, $fileDisk, $targetFilePath)
    {
      if (Storage::disk($fileDisk)->put($targetFilePath . $this->design->image, fopen($originalFilePath, 'r+'))) {
        File::delete($originalFilePath);
      };

      Storage::disk($fileDisk)->setVisibility($targetFilePath . $this->design->image, 'public');
    }
}
