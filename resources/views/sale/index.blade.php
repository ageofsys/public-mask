@extends('layouts.app')

@section('title', '공적 마스크 현황')

@section('content')
    <h1 class="h1 pb-3 mb-3 border-b"><i class="fas fa-database text-gray-700"></i> 판매 데이터베이스</h1>

    <div class="row justify-content-between">
        <div class="col-4 text-left text-gray-600">
            총 갯수 {{ number_format($saleResult->totalCount) }}
        </div>
        <div class="col-4 text-right mb-2">
            @if($page < 2)
                <a type="button" class="btn btn btn-outline-secondary btn-sm" href="#" disabled><i class="fas fa-chevron-circle-left"></i> 이전 페이지</a>
            @else
                <a type="button" class="btn btn btn-outline-secondary btn-sm" href="{{ route("sales.index", ["page" => $page - 1]) }}"><i class="fas fa-chevron-circle-left"></i> 이전 페이지</a>
            @endif
            <a type="button" class="btn btn btn-outline-secondary btn-sm" href="#" disabled>{{ $page }} 페이지</a>
            @if($page + 1 > $saleResult->totalPages)
                    <a type="button" class="btn btn btn-outline-secondary btn-sm" href="#" disabled>다음 페이지 <i class="fas fa-chevron-circle-right"></i></a>
            @else
                <a type="button" class="btn btn btn-outline-secondary btn-sm" href="{{ route("sales.index", ["page" => $page + 1]) }}">다음 페이지 <i class="fas fa-chevron-circle-right"></i></a>
            @endif
        </div>
    </div>

    <table class="table table-striped border-b table-hover">
        <thead>
        <tr>
            <th scope="col">코드</th>
            <th scope="col">입고시간</th>
            <th scope="col">재고 상태</th>
            <th scope="col">생성일</th>
        </tr>
        </thead>
        <tbody>
{{--        @dd($saleResult)--}}
        @foreach($saleResult->sales as $sale)
        <tr class="remain-stat-{{ $sale->remainStat }}">
            <td scope="row">{{ $sale->code }}</td>
            <td scope="row">{{ $sale->stockAt }}</td>
            <td scope="row">{{ $sale->remainStatWord }}</td>
            <td scope="row">{{ $sale->createdAt }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <div class="row justify-content-between">
        <div class="col-4 text-left text-gray-600">
            총 갯수 {{ number_format($saleResult->totalCount) }}
        </div>
        <div class="col-4 text-right mb-2">
            @if($page < 2)
                <a type="button" class="btn btn btn-outline-secondary btn-sm" href="#" disabled><i class="fas fa-chevron-circle-left"></i> 이전 페이지</a>
            @else
                <a type="button" class="btn btn btn-outline-secondary btn-sm" href="{{ route("sales.index", ["page" => $page - 1]) }}"><i class="fas fa-chevron-circle-left"></i> 이전 페이지</a>
            @endif
            <a type="button" class="btn btn btn-outline-secondary btn-sm" href="#" disabled>{{ $page }} 페이지</a>
            @if($page + 1 > $saleResult->totalPages)
                <a type="button" class="btn btn btn-outline-secondary btn-sm" href="#" disabled>다음 페이지 <i class="fas fa-chevron-circle-right"></i></a>
            @else
                <a type="button" class="btn btn btn-outline-secondary btn-sm" href="{{ route("sales.index", ["page" => $page + 1]) }}">다음 페이지 <i class="fas fa-chevron-circle-right"></i></a>
            @endif
        </div>
    </div>


@endsection
