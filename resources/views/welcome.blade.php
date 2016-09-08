@extends('layouts.app')

@push("style")

<style>
    /* Move down content because we have a fixed navbar that is 50px tall */
    body {
      padding-top: 50px;
      padding-bottom: 20px;
      overflow-y: scroll;
    }
    ul.dropdown-menu li {
        margin-left: 20px;
    }
    .vuetable th.sortable:hover {
        color: #2185d0;
        cursor: pointer;
    }
    .vuetable-actions {
        width: 11%;
        padding: 12px 0px;
        text-align: center;
    }
    .vuetable-actions > button {
      padding: 3px 6px;
      margin-right: 4px;
    }
    .vuetable-pagination {
        margin: 0;
    }
    .vuetable-pagination .btn {
        margin: 2px;
    }
    .vuetable-pagination-info {
        float: left;
        margin-top: auto;
        margin-bottom: auto;
    }
    ul.pagination {
      margin: 0px;
    }
    .vuetable-pagination-component {
      float: right;
    }
    .vuetable-pagination-component li a {
        cursor: pointer;
    }
    [v-cloak] {
        display: none;
    }
    .highlight {
        background-color: yellow;
    }
    .vuetable-detail-row {
        height: 200px;
    }
    .detail-row {
        margin-left: 40px;
    }
    .expand-transition {
        transition: all .5s ease;
    }
    .expand-enter, .expand-leave {
        height: 0;
        opacity: 0;
    }

    /* Loading Animation: */
    .vuetable-wrapper {
        opacity: 1;
        position: relative;
        filter: alpha(opacity=100); /* IE8 and earlier */
    }
    .vuetable-wrapper.loading {
      opacity:0.4;
       transition: opacity .3s ease-in-out;
       -moz-transition: opacity .3s ease-in-out;
       -webkit-transition: opacity .3s ease-in-out;
    }
    .vuetable-wrapper.loading:after {
      position: absolute;
      content: '';
      top: 40%;
      left: 50%;
      margin: -30px 0 0 -30px;
      border-radius: 100%;
      -webkit-animation-fill-mode: both;
              animation-fill-mode: both;
      border: 4px solid #000;
      height: 60px;
      width: 60px;
      background: transparent !important;
      display: inline-block;
      -webkit-animation: pulse 1s 0s ease-in-out infinite;
              animation: pulse 1s 0s ease-in-out infinite;
    }
    @keyframes pulse {
      0% {
        -webkit-transform: scale(0.6);
                transform: scale(0.6); }
      50% {
        -webkit-transform: scale(1);
                transform: scale(1);
             border-width: 12px; }
      100% {
        -webkit-transform: scale(0.6);
                transform: scale(0.6); }
    }
</style>
@endpush

@section("content")
<div id="app">
<h2 class="sub-header">List of Users</h2>
<hr>
<div class="form-inline form-group">
    <label>Search:</label>
    <input v-model="searchFor" class="form-control" @keyup.enter="setFilter">
    <button class="btn btn-primary" @click="setFilter">Go</button>
    <button class="btn btn-default" @click="resetFilter">Reset</button>
</div>

<div class="table-responsive">
    <vuetable v-ref:vuetable
        api-url="/api/users"
        pagination-path=""
        :fields="fields"
        :sort-order="sortOrder"
        :multi-sort="multiSort"
        table-class="table table-bordered table-striped table-hover"
        ascending-icon="fa fa-chevron-up"
        descending-icon="fa fa-chevron-down"
        pagination-class=""
        pagination-info-class=""
        pagination-component-class="text-right"
        :pagination-component="paginationComponent"
        :item-actions="itemActions"
        :append-params="moreParams"
        :per-page="perPage"
        wrapper-class="vuetable-wrapper"
        table-wrapper=".vuetable-wrapper"
        loading-class="loading"
        detail-row-callback="makeDetailRow"
        detail-row-id="id"
        detail-row-transition="expand"
        row-class-callback="rowClassCB"
    ></vuetable>
</div>
@endsection

@push("script")
<script src="/js/welcome.js"></script>
</script>
@endpush