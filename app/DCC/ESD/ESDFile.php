<?php namespace app\DCC\ESD;

use App\DCC\SpecificationGateway;
use App\ESD;
use Illuminate\Http\Request;

class ESDFile implements SpecificationGateway {

    private $esd;
    private $path;
    private $documentName;
    private $request;

    public function __construct(Request $request, ESD $esd) {
        $this->esd = $esd;
        $this->request = $request;
    }

    function persist() {
        $this->makePath();
        $this->makeDocumentName();
        $path = $this->request->document->storeAs($this->path, $this->documentName);
        $this->esd->update(['document' => $path]);
    }

    function update()
    {
        $this->persist($this->request);
    }

    private function makePath()
    {
        $year = \Carbon::now()->year;
        $spec_name = $this->safeChar($this->esd->spec_no);

        $this->path =  "{$year}/{$spec_name}";
    }

    private function makeDocumentName()
    {
        $name =  [
            'spec_no' => $this->safeChar($this->esd->spec_no),
            'spec_revision' => $this->safeChar($this->request->revision)
        ];

        $implode_name = \Str::upper(implode("_", $name));
        $extension =$this->request->document->getClientOriginalExtension();

        $this->documentName =  "{$implode_name}.{$extension}";
    }

    private function safeChar($string)
    {
        return preg_replace("/[^a-z|^0-9|^A-Z]/", "-", $string);
    }
}