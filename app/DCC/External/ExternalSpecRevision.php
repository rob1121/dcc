<?php namespace App\DCC\External;
use App\CustomerSpec;
use App\CustomerSpecRevision;
use App\DCC\SpecificationFactory;
use App\DCC\SpecificationGateway;
use Illuminate\Http\Request;

class ExternalSpecRevision implements SpecificationGateway {

    private $spec;
    private $factory;

    public function __construct(CustomerSpec $spec=null) {
        $this->spec = $spec;
        $this->factory = new SpecificationFactory;
    }

    function persist(Request $request) {
        $this->spec->customerSpecRevision()->firstOrCreate($request->all());
        $this->factory->store(new ExternalSpecFile($this->spec), $request);
        return $this->spec;
    }

    function update(Request $request) {
        $ids = $this->getIdsOfAllLastestRevision($request);
        $this->spec->customerSpecRevision()->whereIn("id",$ids)->delete();

        $this->isRevisionExist($request)
            ? $this->spec->customerSpecRevision()->whereRevision($request->revision)->update($this->modelInstance($request))
            : $this->spec->customerSpecRevision()->create($this->modelInstance($request));
        $this->factory->update(new ExternalSpecFile($this->spec), $request);
    }

    private function modelInstance($request) {
        $newCompanySpecInstance = new CustomerSpecRevision($request->all());
        return $newCompanySpecInstance->toArray();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function isRevisionExist(Request $request) {
        return $this->spec->customerSpecRevision()->whereRevision($request->revision)->count() > 0;
    }

    /**
     * @param Request $request
     * @return static
     */
    protected function getIdsOfAllLastestRevision(Request $request)
    {
        $ids = collect($this->spec->customerSpecRevision)->filter(function ($item) use ($request) {
            return strcasecmp($item->revision, $request->revision);
        })->map(function ($item) {
            return $item->id;
        })->flatten();
        return $ids;
    }
}