<?php namespace App\DCC\Company\AddCompanySpecs;

use Carbon\Carbon;
use Illuminate\Support\Str;

class AddSpecFile extends SpecAbstract
{
    private $path;
    private $documentName;

    /**
     * upload file to given storage
     */
    public function add()
    {
        $this->makePath();
        $this->makeDocumentName();

        $path = $this->request->document->storeAs($this->path, $this->documentName);
        $this->spec->companySpecRevision()->update(['document' => $path]);
    }

    /**
     * generate path name
     */
    public function makePath()
    {
        $year = Carbon::now()->year;
        $spec_name = $this->spec->spec_no;

        $this->path =  "{$year}/{$spec_name}";
    }

    /**
     * generate document name
     */
    public function makeDocumentName()
    {
        $name =  [
            'spec_no' => $this->spec->spec_no,
            'spec_revision' => preg_replace("/[^a-z|^0-9|^A-Z]/", "-", $this->getRevision())
        ];

        $implode_name = Str::upper(implode("_", $name));
        $extension =$this->request->document->getClientOriginalExtension();

        $this->documentName =  "{$implode_name}.{$extension}";
    }

    /**
     * get specification revision
     */
    protected function getRevision()
    {
        return $this->spec->load('companySpecRevision')->companySpecRevision()
            ->orderBy("id", "desc")
            ->first()
            ->revision;
    }
}