<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationGateway;
use App\Originator;
use Illuminate\Http\Request;

class InternalSpecOriginator implements SpecificationGateway {
    private $spec;
    private $request;

    public function __construct(Request $request, CompanySpec $spec=null) {
        $this->spec = $spec;
        $this->request = $request;
    }

    public function persist()
    {
        $departments = collect($this->request->department)->toArray();
        $users = \App\User::whereIn("department", $departments)->get(["id","department"])->toArray();
        return $this->spec->originator()->createMany($this->toOriginatorInstance($users));
    }

    public function update()
    {
        if ($this->spec === null) throw new SpecNotFoundException();

        $this->spec->originator()->delete();
        $this->persist();
    }

    protected function toRequestInstance($users)
    {
        $users = collect($users)->toArray();
        return new Request($users);
    }

    protected function toOriginatorInstance(array $users)
    {
        return collect($users)->map(function($user) {
            $user["user_id"] = $user['id'];
            return $user;
        })
        ->map(function($user) { return $this->toRequestInstance($user); })
        ->map(function($request) { return Originator::instance($request); })
        ->toArray();
    }
}