<?php

namespace App\Resolver;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploaderResolverInterface
{
    public function upload(UploadedFile $file);

    public function getTargetDirectory();
}
