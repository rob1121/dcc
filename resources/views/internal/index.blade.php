@extends("layouts.app")

@push("script")
    <script src="{{URL::to("/js/internal-index.js")}}"></script>
@endpush

@section("content")
    <div class="hidden-xs col-md-3 side">
        <div class="row">
                <input type="text" class="form-control input-lg" v-model="searchKey" placeholder="Look for...">
        </div>

        <div class="row">
            <ul class="list-group">
                <li :class="['list-group-item', searchCategoryKey === category.category_no ? 'active' : '']"
                    v-for="category in {{$categories}}"
                    @click="setActiveCategory(category.category_no)"
                    v-text="category.name"
                ></li>
            </ul>
        </div>
    </div>

    <div class="col-xs-12 col-md-9 main-content">
        <ol class="breadcrumb">
            <li>
                <a href="{{route("home")}}">Home</a>
            </li>
            <li class="active">Internal Specification</li>
        </ol>

        @if(Auth::user() && isAdmin())
            <div class="clearfix">
                <a href="{{route("internal.create")}}" class="pull-right btn btn-primary" style="margin-bottom: 5px">
                    Add new internal specification <i class="fa fa-plus"></i>
                </a>
            </div>
        @endif

        @include('errors.flash')

        <div class="row-fluid hidden-md hidden-lg" style="margin-bottom: 5px">
            <input type="text" class="form-control input-lg" v-model="searchKey" placeholder="Look for...">
        </div>

        <div class="panel panel-default">
            <table class="table table-hover">
                <th>Specification</th>
                <th class="text-right">Revision</th>
                <th class="text-right">Revision date</th>
                @if( Auth::user() &&  isAdmin())
                    <th>Actions</th>
                @endif
                <tbody v-if="documents.length">
                <tr v-for="spec in documents">
                    <td>
                        <a :href="spec.internal_show" target="_black">
                            <span class="label label-success" v-if="spec.highlight">@{{ spec.highlight }}</span>
                            <strong>@{{spec.spec_name | toUpper}}</strong>
                        </a>
                        <br>
                        <small>@{{spec.revision_summary | capitalize}}</small>
                    </td>
                    <td class="text-right">
                        @{{spec.company_spec_revision.revision | toUpper}}
                    </td>
                    <td class="text-right">
                        @{{spec.company_spec_revision.revision_date | telfordStandardDate}}
                    </td>
                    @if( Auth::user() &&  isAdmin())
                        <td class="col-md-4">
                            <a id="update-btn" class="btn btn-xs btn-default" :href="spec.internal_edit">
                                Update<i class="fa fa-edit"></i>
                            </a>
                            <button id="delete-btn" class="btn btn-xs btn-danger" data-toggle="modal" href="#spec-delete" @click="
                            setModalSpec(spec)">Remove <i class="fa fa-remove"></i>
                            </button>
                        </td>
                    @endif
                </tr>
                </tbody>
                <tfoot v-else>
                <tr>
                    <td colspan="4" class="text-center text-danger">No document specification found.</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{--=======================================MODALS=================================--}}
    <dcc-modal title="Modal confirmation"
               id="spec-delete"
               class-type="danger"
    >
        <h3 class="text-center">
            Are you sure you want to permanently <strong class="text-danger">delete</strong>
            <br>
            "<strong class="text-danger">
                @{{modalConfirmation.category.spec_name | toUpper}}
            </strong>"?
        </h3>

        <div class="text-center">
            <button type="button" class="btn btn-danger" data-dismiss="modal" @click="removeSpec">Yes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
    </dcc-modal>
@endsection