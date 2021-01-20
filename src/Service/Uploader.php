<?php

namespace App\Service;

use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class Uploader
{
  public function upload($file, $dir)
  {
    $filename = bin2hex(random_bytes(6)) . '.' . $file->guessExtension();
    try {
      $file->move($dir, $filename);
    } catch (FileException $e) {
      return new Response($e->getMessage());
    }

    return $filename;
  }
}
