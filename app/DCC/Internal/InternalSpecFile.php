<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\DCC\SpecificationGateway;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InternalSpecFile implements SpecificationGateway {

    private $spec;
    private $path;
    private $documentName;
    private $request;

    public function __construct(Request $request, CompanySpec $spec=null)
    {
        $this->spec = $spec;
        $this->request = $request;
    }

    function persist()
    {
        $this->makePath();
        $this->makeDocumentName();
        $path = $this->request->document->storeAs($this->path, $this->documentName);
        $this->getSpecInstance()->update(['document' => $path]);
    }

    function update()
    {
        $this->persist();
    }

    private function makePath()
    {
        $name = $this->spec->companySpecCategory->category_no ."-".$this->spec->spec_no;
        $year = Carbon::now()->year;
        $this->path =  "{$year}/" . preg_replace("/[^a-z|^0-9|^A-Z]/", " ", "{$name}");
    }

    private function makeDocumentName() {
        $name = $this->spec->companySpecCategory->category_no ."-".$this->spec->spec_no;
        $name =  [
            'spec_no' => preg_replace("/[^a-z|^0-9|^A-Z]/", " ", $name),
            'spec_revision' => preg_replace("/[^a-z|^0-9|^A-Z]/", " ", $this->getRevision())
        ];

        $implode_name = Str::upper(implode("_", $name));
        $extension =$this->request->document->getClientOriginalExtension();

        $this->documentName =  "{$implode_name}.{$extension}";
    }

    private function getSpecInstance() {
        return $this->spec->companySpecRevision()
            ->whereCompanySpecId($this->spec->id)
            ->whereRevision($this->request->revision);
    }

    private function getRevision() {
        return $this->getSpecInstance()->first()->revision;
    }
}