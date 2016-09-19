<?php namespace App\DCC;

class SpecificationFactory {
    public function store(SpecificationGateway $spec, $request)
    {
        return $spec->persist($request);
    }

    public function update(SpecificationGateway $spec, $request)
    {
        $spec->update($request);
    }
}