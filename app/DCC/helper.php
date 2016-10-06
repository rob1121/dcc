<?php

use Carbon\Carbon;

function customerForSpecReviewCount() {
    $count =  App\CustomerSpecRevision::whereIsReviewed(0)->count();
    return $count;
}

function newCompanySpecCount() {
    $count =  App\CompanySpecRevision::where("revision_date",">", Carbon::now()->subDays(7))->count();
    return $count;
}

function newCustomerSpecCount() {
    $count =  App\CustomerSpecRevision::where("revision_date",">", Carbon::now()->subDays(7))->count();
    return $count;
}

function newIsoDocumentCount() {
    $count =  App\Iso::where("revision_date",">", Carbon::now()->subDays(7))->count();
    return $count;
}

