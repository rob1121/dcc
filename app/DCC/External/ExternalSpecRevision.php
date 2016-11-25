<?php namespace App\DCC\External;
use App\CustomerSpec;
use App\CustomerSpecRevision;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationFactory;
use App\DCC\SpecificationGateway;
use Illuminate\Http\Request;

class ExternalSpecRevision implements SpecificationGateway {

    private $spec;
    private $factory;
    /**
     * @var Request
     */
    private $request;

    function __construct(Request $request, CustomerSpec $spec=null) {
        $this->spec = $spec;
        $this->factory = new SpecificationFactory;
        $this->request = $request;
    }

    function persist() {
        $this->spec->customerSpecRevision()->firstOrCreate(CustomerSpecRevision::instance($this->request));
        $this->factory->store(new ExternalSpecFile($this->request, $this->spec));

        return $this->spec;
    }

    function update() {

        if ($this->spec === null) throw new SpecNotFoundException();
//        $ids = $this->getIdsOfAllLatestRevision();
//        $this->spec->customerSpecRevision()->whereIn("id",$ids)->delete();
//
//        $this->spec->customerSpecRevision()->whereRevision($this->request->revision)
//            ->update(["is_reviewed" => $request->is_reviewed]);

        $this->isRevisionExist()
            ? $this->spec->customerSpecRevision()->whereRevision($this->request->revision)->update(CustomerSpecRevision::instance($this->request))
            : $this->spec->customerSpecRevision()->create(CustomerSpecRevision::instance($this->request));

        $this->factory->update(new ExternalSpecFile($this->request, $this->spec));
    }

    /**
     * @return mixed
     */
    protected function isRevisionExist() {
        return $this->spec->customerSpecRevision()->whereRevision($this->request->revision)->count() > 0;
    }


//    protected function getIdsOfAllLatestRevision()
//    {
//        return collect($this->spec->customerSpecRevision)->filter(function ($item) {
//            return strcasecmp($item->revision, $this->request->revision);
//        })->map(function ($item) {
//            return $item->id;
//        })->flatten();
//    }
}