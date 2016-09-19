<?php namespace App\DCC\External\Store;


interface AddInterface
{
    public function add();

    public function setRequest($request);

    public function setSpec($spec);

    public function getSpec();

}