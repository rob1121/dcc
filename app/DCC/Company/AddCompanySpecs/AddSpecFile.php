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
        $this->getSpecInstance()->update(['document' => $path]);
        return $path;
    }

    /**
     * generate path name
     */
    private function makePath()
    {
        $year = Carbon::now()->year;
        $spec_name = $this->spec->spec_no;

        $this->path =  "{$year}/{$spec_name}";
    }

    /**
     * generate document name
     */
    private function makeDocumentName()
    {
        $name =  [
            'spec_no' => $this->spec->spec_no,
            'spec_revision' => preg_replace("/[^a-z|^0-9|^A-Z]/", "-", $this->getRevision())
        ];

        $implode_name = Str::upper(implode("_", $name));
        $extension =$this->request->document->getClientOriginalExtension();

        $this->documentName =  "{$implode_name}.{$extension}";
    }

    private function getSpecInstance()
    {
        return $this->spec->companySpecRevision()
            ->whereCompanySpecId($this->spec->id)
            ->whereRevision($this->request->revision);
    }

    /**
     * get specification revision
     */
    private function getRevision()
    {
        return $this->getSpecInstance()->first()->revision;
    }
}