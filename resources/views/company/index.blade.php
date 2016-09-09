@extends("layouts.app")

@section("content")
    <div class="col-xs-12 col-md-2">
        <div class="list-group">
            @foreach($categories as $category)
            	<a href="#" class="list-group-item">{{$category->category_name}}</a>
            @endforeach
        </div>
    </div>

    <div class="col-xs-12 col-md-10" id="app" v-cloak>
        <div class="row form-group">
            <div class="col-xs-4">
                <input type="text" placeholder="filter database" class="form-control">
            </div>

            <button class="btn btn-default">Search</button>
            <button class="btn btn-primary">Clear Filter</button>
        </div>
        <div class="panel panel-default">
        	<div class="panel-heading">Internal specification</div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>spec no</th>
                        <th>title</th>
                        <th>revision</th>
                        <th>revision summary</th>
                        <th>revision date</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($specs as $spec)
                        <tr>
                            <td class="col-xs-1">{{Str::upper($spec->spec_no)}}</td>
                            <td class="col-xs-3">{{$spec->name}}</td>
                            <td>{{Str::upper($spec->companySpecRevision->revision)}}</td>
                            <td class="col-xs-4">{{$spec->companySpecRevision->revision_summary}}</td>
                            <td class="col-xs-2">{{$spec->companySpecRevision->revision_date}}</td>
                            <td class="col-xs-4">
                                <button class="btn btn-xs btn-primary"><i class="fa fa-file-pdf-o"></i></button>
                                <button class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>
                                <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center">
                <ul class="pagination" v-if="pagination.count > 1">
                    <!-- Previous Page Link -->
                    @if ($paginator->onFirstPage())
                        <li class="disabled"><span><i class="fa fa-arrow-left"></i></span></li>
                    @else
                        <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-arrow-left"></i></a></li>
                    @endif

                <!-- Next Page Link -->
                    @if ($paginator->hasMorePages())
                        <li><a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa fa-arrow-right"></i></a></li>
                    @else
                        <li class="disabled"><span><i class="fa fa-arrow-right"></i></span></li>
                    @endif
                </ul>
        </div>
    </div>
@endsection

@push("script")
<script src="/js/companyIndex.js"></script>
@endpush