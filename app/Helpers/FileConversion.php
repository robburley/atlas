<?php


namespace App\Helpers;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Imagick;
use Intervention\Image\Facades\Image;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use Spatie\PdfToImage\Pdf;

class FileConversion
{
    public $original;
    public $originalExtension;
    public $fileName;
    public $customer;
    public $doNotConvert;

    public function __construct($location, $extension, $fileName, $customer, $doNotConvert = false)
    {
        $this->original = $location;
        $this->originalExtension = $extension;
        $this->fileName = $fileName;
        $this->customer = $customer;
        $this->doNotConvert = $doNotConvert;
    }

    public function convert()
    {
        if ($this->originalExtension == 'jpeg' ||
            $this->originalExtension == 'jpg' ||
            $this->originalExtension == 'png' ||
            $this->originalExtension == 'bmp' ||
            $this->doNotConvert
        ) {
            return $this->fileName . '.' . $this->originalExtension;
        }

        if ($this->originalExtension == 'pdf') {
            $pdf = new Pdf(storage_path('app/' . $this->original));

            $pdf->saveImage(storage_path('app/' . $this->customer->id . '/' . $this->fileName . '.jpg'));
        }

//        if ($this->originalExtension == 'doc' || $this->originalExtension == 'docx') {
//            dd("Didn't happen");
//        }

        return $this->fileName . '.jpg';
    }
}