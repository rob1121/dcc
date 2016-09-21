<?php namespace App\DCC\File;

use App\DCC\Exceptions\SpecNotFoundException;
use Illuminate\Support\Facades\Response;

class Document
{
    protected $filename;
    protected $path;

    public function __construct($document)
    {
        $this->path = storage_path("app/{$document}");
    }

    public function showPDF()
    {
        try {
            if( ! file_exists($this->path)) throw new SpecNotFoundException;
            return $this->displayPageInPdfType();
        } catch(SpecNotFoundException $e) {
            return $this->redirectToError404();
        }
    }

    protected function displayPageInPdfType() {
        return Response::make(file_get_contents($this->path), 200, [
            "Content-Type" => "application/pdf; name=filename.pdf",
            "Content-Disposition" => "inline; filename=filename.pdf"
        ]);
    }

    protected function redirectToError404() {
        return response()->view('errors.404', [], 404);
    }
}