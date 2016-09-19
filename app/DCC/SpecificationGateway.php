<?php namespace App\DCC;

Interface SpecificationGateway
{
    function persist($request);

    function update($request);
}