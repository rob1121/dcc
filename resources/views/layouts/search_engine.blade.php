@if($show)
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1" role="tab" data-toggle="tab">Internal Specification Result</a></li>
        @if(Auth::user() && Auth::user()->is_admin)
            <li><a href="#tab2" role="tab" data-toggle="tab">External Specification Result</a></li>
        @endif
    </ul>
    <!-- TAB CONTENT -->
    <div class="tab-content">
        <div class="active tab-pane fade in" id="tab1">
            <div class="search--deck-collection search-result--list" v-if="searchResults.internal">
                <h1>Search result Found for <strong>"@{{ searchKeyword }}"</strong>
                </h1>
                <a class="search--deck" v-for="result in searchResults.internal" target="_blank"
                   :href="internalRouteFor(result.id)"
                   placholder="view file">
                    <div class="search--spec-no col-xs-offset-1 col-xs-10">
                        <h4>@{{uppercase(result.spec_no)}} - @{{uppercase(result.name)}}</h4>
                        <h5>@{{capitalize(result.company_spec_revision.revision_summary)}}</h5>
                        <h6 class="help-block">
                            <strong>Date: </strong>@{{telfordStandardDate(result.company_spec_revision)}}
                            <strong>Revision: </strong>@{{uppercase(result.company_spec_revision.revision)}}
                        </h6>
                    </div>
                </a>
            </div>

            <div v-else>
                <h1 class="text-left search-result--list">No Result Found for <strong>"@{{ searchKeyword }}
                        "</strong></h1>
            </div>
        </div>
        <div class="tab-pane fade" id="tab2">

            <div class="search--deck-collection search-result--list" v-if="searchResults.external">
                <h1>Search result found for <strong>"@{{ searchKeyword }}"</strong>
                </h1>
                <a class="search--deck" v-for="result in searchResults.external" target="_blank"
                   :href="externalRouteFor(result.id)"
                   placeholder="view file">
                    <div class="search--spec-no cpl-xs-offset-1 col-xs-10">
                        <h4>@{{uppercase(result.spec_no)}} - @{{uppercase(result.name)}}</h4>
                        <h6 class="help-block justify">
                            <strong>Date: </strong>@{{telfordStandardDate( getLatestRevision(result.customer_spec_revision, "revision_date"))}}
                            <strong>Revision: </strong>@{{getLatestRevision(uppercase(result.customer_spec_revision, "revision"))}}
                        </h6>
                    </div>
                </a>
            </div>

            <div v-else>
                <h1 class="text-left search-result--list">No Result Found for <strong>"@{{ searchKeyword }}
                        "</strong></h1>
            </div>
        </div>
    </div>
@endif