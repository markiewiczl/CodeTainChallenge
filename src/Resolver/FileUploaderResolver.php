<?php

namespace App\Resolver;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploaderResolver implements FileUploaderResolverInterface
{
    private $imageDirectory;

    private SluggerInterface $slugger;

    public function __construct($imageDirectory, SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
        $this->imageDirectory = $imageDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            return new \Exception('error accurate '. $e);
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->imageDirectory;
    }
}