<?php

use Carbon\Carbon;

function customerForSpecReviewCount() {
    return App\CustomerSpecRevision::whereIsReviewed(0)->count();
}

function newCompanySpecCount() {
    return App\CompanySpecRevision::where("revision_date",">", Carbon::now()->subDays(7))->count();
}

function newCustomerSpecCount() {
    return App\CustomerSpecRevision::where("revision_date",">", Carbon::now()->subDays(7))->count();
}

function newIsoDocumentCount() {
    return App\Iso::where("revision_date",">", Carbon::now()->subDays(7))->count();
}