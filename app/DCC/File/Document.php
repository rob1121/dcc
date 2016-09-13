<?php namespace App\DCC\File;

class Document
{

    protected $table;
    protected $filename;
    protected $path;

    public function __construct($table)
    {
        $this->table = $table;
        $this->path = storage_path("app/{$table->companySpecRevision->document}");
    }

    public function showPDF()
    {
        return file_exists($this->path)
            ? $this->displayPageInPdfType()
            : $this->redirectToError404();
    }

    protected function displayPageInPdfType() {
        return \Response::make(file_get_contents($this->path), 200, [
            "Content-Type" => "application/pdf; name=\"filename.pdf\"",
            "Content-Disposition" => "inline; filename=\"filename.pdf\""
        ]);
    }

    protected function redirectToError404() {
        return response()->view('errors.404', [], 404);
    }
}