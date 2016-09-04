<?php namespace App\Http\Controllers;

use App\DCC\AddCompanySpecs\AddCompanySpecs;

class CompanyController extends Controller
{
    public function form()
    {
        return view('company.create');
    }
    public function add(AddCompanySpecs $specs)
    {
        $specs->validateSpec();
        $specs->add();
        return $specs->getResult();
    }
}
