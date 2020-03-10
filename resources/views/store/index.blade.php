@extends('layouts.app')

@section('title', '공공 마스크 현황')

@section('content')
    <h1 class="h1 pb-3 mb-3 border-b"><i class="fas fa-database text-gray-700"></i> 판매처 데이터베이스</h1>

    <div class="row justify-content-between">
        <div class="col-4 text-left text-gray-600">
            총 갯수 {{ number_format($storeResult->totalCount) }}
        </div>
        <div class="col-4 text-right mb-2">
            @if($page < 2)
            <a type="button" class="btn btn btn-outline-secondary btn-sm" href="#" disabled><i class="fas fa-chevron-circle-left"></i> 이전 페이지</a>
            @else
            <a type="button" class="btn btn btn-outline-secondary btn-sm" href="{{ route("stores.index", ["page" => $page - 1]) }}"><i class="fas fa-chevron-circle-left"></i> 이전 페이지</a>
            @endif
            <a type="button" class="btn btn btn-outline-secondary btn-sm" href="#" disabled>{{ $page }} 페이지</a>
            @if($page + 1 > $storeResult->totalPages)
                <a type="button" class="btn btn btn-outline-secondary btn-sm" href="#" disabled>다음 페이지 <i class="fas fa-chevron-circle-right"></i></a>
            @else
                <a type="button" class="btn btn btn-outline-secondary btn-sm" href="{{ route("stores.index", ["page" => $page + 1]) }}">다음 페이지 <i class="fas fa-chevron-circle-right"></i></a>
            @endif
        </div>
    </div>
    <table class="table table-striped border-b table-hover">
        <thead>
        <tr>
            <th scope="col">코드</th>
            <th scope="col">이름</th>
            <th scope="col">주소</th>
            <th scope="col">유형</th>
            <th scope="col">위도</th>
            <th scope="col">경도</th>
        </tr>
        </thead>
        <tbody>
        @foreach($storeResult->storeInfos as $store)
        <tr>
            <td scope="row">{{ $store->code }}</td>
            <td scope="row">{{ $store->name }}</td>
            <td scope="row">{{ $store->addr }}</td>
            <td scope="row">{{ $store->type_word }}</td>
            <td scope="row">{{ $store->lat }}</td>
            <td scope="row">{{ $store->lng }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="row justify-content-between">
        <div class="col-4 text-left text-gray-600">
            총 갯수 {{ number_format($storeResult->totalCount) }}
        </div>
        <div class="col-4 text-right mb-2">
            @if($page < 2)
                <a type="button" class="btn btn btn-outline-secondary btn-sm" href="#" disabled><i class="fas fa-chevron-circle-left"></i> 이전 페이지</a>
            @else
                <a type="button" class="btn btn btn-outline-secondary btn-sm" href="{{ route("stores.index", ["page" => $page - 1]) }}"><i class="fas fa-chevron-circle-left"></i> 이전 페이지</a>
            @endif
            <a type="button" class="btn btn btn-outline-secondary btn-sm" href="#" disabled>{{ $page }} 페이지</a>
            @if($page + 1 > $storeResult->totalPages)
                <a type="button" class="btn btn btn-outline-secondary btn-sm" href="#" disabled>다음 페이지 <i class="fas fa-chevron-circle-right"></i></a>
            @else
                <a type="button" class="btn btn btn-outline-secondary btn-sm" href="{{ route("stores.index", ["page" => $page + 1]) }}">다음 페이지 <i class="fas fa-chevron-circle-right"></i></a>
            @endif
        </div>
    </div>


@endsection
