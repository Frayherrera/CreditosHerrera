<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageProcessor
{
    private ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver);
    }

    public function process(UploadedFile $file): string
    {
        $img = $this->manager->read($file);

        $img->resizeDown(800, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        return $img->toWebp(80)->toString();
    }
}
