@extends('layouts.app')

@section('title', '공공 마스크 현황')

@section('content')
    <h1 class="h1 pb-3 mb-3 border-b"><i class="fas fa-database text-gray-700"></i> 마스크 재고현황</h1>

{{--    "plenty" => "100개 이상",--}}
{{--    "some" => "30개 이상 100개미만",--}}
{{--    "few" => "2개 이상 30개 미만",--}}
{{--    "empty" => "1개 이하",--}}

    <form action="/stores" method="get">
        @foreach($parameters as $key => $value)
        <input name="{{ $key }}" value="{{ $value }}" type="hidden">
        @endforeach
        <div class="row mb-3">
            <div class="col-12 col-lg-8 mb-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="remain_stat" id="remain_stat_no"
                           value="" @if( ! isset($parameters["remain_stat"])) checked @endif>
                    <label class="form-check-label cursor-pointer" for="remain_stat_no">모두</label>
                </div>
                <div class="form-check form-check-inline remain-stat-plenty">
                    <input class="form-check-input" type="radio" name="remain_stat" id="remain_stat_plenty"
                           value="plenty" @if(isset($parameters["remain_stat"]) && $parameters["remain_stat"] == "plenty") checked @endif>
                    <label class="form-check-label cursor-pointer" for="remain_stat_plenty">100개 이상</label>
                </div>
                <div class="form-check form-check-inline remain-stat-some">
                    <input class="form-check-input" type="radio" name="remain_stat" id="remain_stat_some"
                           value="some" @if(isset($parameters["remain_stat"]) && $parameters["remain_stat"] == "some") checked @endif>
                    <label class="form-check-label cursor-pointer" for="remain_stat_some">30개 이상 100개미만</label>
                </div>
                <div class="form-check form-check-inline remain-stat-few">
                    <input class="form-check-input" type="radio" name="remain_stat" id="remain_stat_few"
                           value="few" @if(isset($parameters["remain_stat"]) && $parameters["remain_stat"] == "few") checked @endif>
                    <label class="form-check-label cursor-pointer" for="remain_stat_few">2개 이상 30개 미만</label>
                </div>
                <div class="form-check form-check-inline remain-stat-empty">
                    <input class="form-check-input" type="radio" name="remain_stat" id="remain_stat_empty"
                           value="empty" @if(isset($parameters["remain_stat"]) && $parameters["remain_stat"] == "empty") checked @endif>
                    <label class="form-check-label cursor-pointer" for="remain_stat_empty">1개 이하</label>
                </div>
            </div>
            <div class="col-12 col-lg-4 mb-3">
                <div class="input-group">
                    <input name="keyword" type="text" class="form-control" placeholder="대구 율하동"
                           value="{{ isset($parameters["keyword"]) ? $parameters["keyword"] : "" }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">검색</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <table class="table border-b table-hover">
        <thead>
        <tr>
            <th class="d-none d-lg-block d-xl-block">유형</th>
            <th>이름</th>
            <th>주소</th>
            <th>재고</th>
            <th class="d-none d-lg-block d-xl-block">입고일</th>
            <th class="">지도</th>
        </tr>
        </thead>
        <tbody>
        @foreach($stores as $store)

        @php
        $latestSale = $store->sales->first();
        $remainStat = $latestSale ? $latestSale->remain_stat : "";
        $remainStatWord = $latestSale ? $latestSale->remain_stat_word : "";
        $stockAt = $latestSale ? $latestSale->stock_at : "";
        $stockAtWord = $latestSale ? $latestSale->stock_at_word : "";

        $remainStat = $remainStat ?: "empty";
        $remainStatWord = $remainStatWord ?: "정보가 없습니다";
        $stockAtWord = $stockAtWord ?: "정보가 없습니다";
        @endphp
        <tr class="cursor-pointer remain-stat-{{ $remainStat }}" id="store-{{ $store->id }}">
            <td class="d-none d-lg-block d-xl-block" data-toggle="collapse" data-target="#store-sale-{{ $store->id }}">{{ $store->type_word }}</td>
            <td data-toggle="collapse" data-target="#store-sale-{{ $store->id }}">{{ $store->name }}</td>
            <td data-toggle="collapse" data-target="#store-sale-{{ $store->id }}">{{ $store->addr }}</td>
            <td data-toggle="collapse" data-target="#store-sale-{{ $store->id }}">{{ $remainStatWord }}</td>
            <td class="d-none d-lg-block d-xl-block" data-toggle="collapse" data-target="#store-sale-{{ $store->id }}">{{ $stockAtWord }}</td>
            <td class="">
                <a target="_blank"
                   href="https://map.kakao.com/link/map/{{ $store->name }} ({{ $remainStatWord }}),{{ $store->lat }},{{ $store->lng }}">
                    지도</a>
            </td>
        </tr>
        <tr id="store-sale-{{ $store->id }}" class="collapse bg-light shadow-inner">
            <td colspan="6">

                <table class="table ">
                    <tr>
                        <th style="width: 200px">입고시간</th>
                        <th style="width: 200px">재고상태</th>
                        <th class="d-none d-lg-block d-xl-block">생성일</th>
                    </tr>
                    @foreach($store->sales as $sale)
                    <tr>
                        <td>{{ $sale->stockAtWord }}</td>
                        <td>{{ $sale->remainStatWord }}</td>
                        <td class="d-none d-lg-block d-xl-block">{{ $sale->createdAtWord }}</td>
                    </tr>
                    @endforeach
                </table>

            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <div class="row">
        <div class="col mb-2 text-center">
            <div class="mb-3 pb-3 border-b d-none d-lg-block d-xl-block">
                {{ $stores->withQueryString()->links() }}
            </div>
            <div class="mb-3 pb-3 border-b d-lg-none d-xl-none">
                {{ $stores->withQueryString()->links("shared.my-small-pagination") }}
            </div>
        </div>
    </div>




@endsection
