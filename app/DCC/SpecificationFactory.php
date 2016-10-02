<?php namespace App\DCC;

class SpecificationFactory {
    public function store(SpecificationGateway $spec)
    {
        return $spec->persist();
    }

    public function update(SpecificationGateway $spec)
    {
        $spec->update();
    }
}