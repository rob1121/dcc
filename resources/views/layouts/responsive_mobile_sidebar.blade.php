<div class="hidden-lg faded" hidden>
    <div class="list-group link">
        <a class="{{route("internal.index") === Request::url() ? "active" : ""}} h1" href="{{ route("internal.index") }}">Internal Specification
            @if($internal)
                <span class="label label-danger">{{$internal}}</span>
            @endif
        </a>
        @if(Auth::user())
            <a class="{{route("external.index") === Request::url() ? "active" : ""}} h1" href="{{ route("external.index") }}">External Specification
                @if($external)
                    <span class="label label-danger">{{$external}}</span>
                @endif
            </a>
        @endif
        <a class="{{route("iso.index") === Request::url() ? "active" : ""}} h1" href="{{ route("iso.index") }}">ISO
            @if($iso)
                <span class="label label-danger">{{$iso}}</span>
            @endif
        </a>
        @if(Auth::user() && isAdmin())
            <a class="{{route("user.index") === Request::url() ? "active" : ""}} h1" href="{{ route("user.index") }}">Users List</a>
        @endif
    </div>
    @if(isset($categories))
        <div class="row">
            <ul class="list-group">
                <li :class="['faded-link','list-group-item', searchCategoryKey === category.category_no ? 'active' : '']"
                    v-for="category in {{$categories}}"
                @click="setActiveCategory(category.category_no)"
                >
                @{{ category.name }}
                </li>
            </ul>
        </div>
    @endif
</div>