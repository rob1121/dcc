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
        $year = Carbon::now()->year;
        $spec_name = $this->spec->spec_no;

        $this->path =  "{$year}/{$spec_name}";
    }

    private function makeDocumentName() {
        $name =  [
            'spec_no' => $this->spec->spec_no,
            'spec_revision' => preg_replace("/[^a-z|^0-9|^A-Z]/", "-", $this->getRevision())
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