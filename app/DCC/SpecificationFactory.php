<?php namespace App\DCC;

class SpecificationFactory {
    /**
     * @param SpecificationGateway $spec
     * @return mixed
     */
    public function store(SpecificationGateway $spec)
    {
        return $spec->persist();
    }

    /**
     * @param SpecificationGateway $spec
     */
    public function update(SpecificationGateway $spec)
    {
        $spec->update();
    }
}