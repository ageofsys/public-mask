<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>공공 마스크 현황</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fafafa">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/rikmms/progress-bar-4-axios/0a3acf92/dist/nprogress.css" />
    <style>

        .remain-stat-plenty { color: #28a745; } /*100개 이상(녹색): 'plenty'*/
        .remain-stat-some { color: #ffc107; } /*30개 이상 100개미만(노랑색): 'some' */
        .remain-stat-few { color: #dc3545; } /*2개 이상 30개 미만(빨강색): 'few' */
        .remain-stat-empty { color: #6c757d; } /*1개 이하(회색): 'empty'*/

        html, body {
            font-family: 'Noto Sans KR', sans-serif;
            font-size: 14px;
            color: #444;
        }

        @media (min-width: 992px) {
            body {
                padding-left: 360px;
                height: 100vh;
            }
        }

        body {
            height: 100vh;
        }

        .page-wrap {
            position: relative;
        }

        .left-menu-wrap {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 360px;
            height: 100%;
            background-color: #fff;
        }

        .search-address-frame {
            position: absolute;
            top: 10px;
            left: 10px;
            display: none;
            border: 1px solid #ccc;
            width: 500px;
            height: 300px;
            overflow-y: hidden;
            background-color: #fff;
            z-index: 1;
        }

        .search-address-frame-mobile {
            position: absolute;
            top: 10px;
            left: 10px;
            display: none;
            border: 1px solid #ccc;
            width: 100%;
            height: 300px;
            overflow-y: hidden;
            background-color: #fff;
            z-index: 1;
        }

        .store-sale-info-frame {
            position: absolute;
            top: 50px;
            right: 10px;
            overflow: hidden;
            margin: 0;
            padding: 0;
            z-index: 1;
            font-size: 12px;
            max-height: 300px;
            min-height: 100px;
            width: 350px;
            overflow-y: scroll;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 1rem;
        }

        .page-wrap {
            min-height: 100%;
        }

        .map_wrap {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 100vh;
        }

        /*.radius_border{border:1px solid #919191;border-radius:5px;}*/
        .custom_typecontrol {
            position: absolute;
            top: 10px;
            right: 10px;
            overflow: hidden;
            margin: 0;
            padding: 0;
            z-index: 1;
            font-size: 12px;
            font-family: 'Malgun Gothic', '맑은 고딕', sans-serif;
        }

    </style>

    <style type="text/css">
        #nprogress .bar {
            background: red !important;
        }

        #nprogress .peg {
            box-shadow: 0 0 10px red, 0 0 5px red !important;
        }

        #nprogress .spinner-icon {
            border-top-color: red !important;
            border-left-color: red !important;
        }
    </style>

    <style>
        #overlay{
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height:100%;
            display: none;
            background: rgba(0,0,0,0.6);
        }
        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px #ddd solid;
            border-top: 4px #2e93e6 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }
        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }
        .is-hide{
            display:none;
        }


        @media (min-width: 992px) {

        }

        .mobile-bottom-wrap {
            position: absolute;
            bottom: 50px;
            left: 10px;
            right: 10px;
            z-index: 1
        }
    </style>

    <script src="https://kit.fontawesome.com/7cec4e236d.js" crossorigin="anonymous"></script>
</head>
<body>

<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>

<div class="page-wrap">

    <div class="left-menu-wrap border-r shadow-lg d-none d-lg-block d-xl-block">

        <div class="row" style="height: 100%">
            <div class="col" style="height: 100%">

                <ul class="list-group list-group-flush shadow">
                    <li class="list-group-item bg-gray-100">
                        <div class="input-group">
                            <input id="search-address-keyword" type="text" class="form-control" placeholder="주소를 검색하세요">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="search-address-btn"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </li>
                    @php
                    $routeName = Route::currentRouteName();
                    @endphp
{{--                    <li class="list-group-item @if($routeName == "search.index" || $routeName == "welcome") active @endif">--}}
{{--                        <a class="nav-link pl-0" href="{{ route("search.index") }}">주소로 검색하기</a>--}}
{{--                    </li>--}}
                    <li class="list-group-item @if($routeName == "stores.index") active @endif">
                        <a class="nav-link pl-0" href="{{ route("stores.index") }}">표로 검색하기</a>
                    </li>
{{--                    <li class="list-group-item @if($routeName == "sales.index") active @endif">--}}
{{--                        <a class="nav-link pl-0" href="{{ route("sales.index") }}">판매 데이터베이스</a>--}}
{{--                    </li>--}}
                </ul>

                <div class="p-3 mt-5">
                    <h3 class="mb-3"><i class="fas fa-clipboard-check"></i> 마크 정보</h3>
                    <ul class="list-disc list-inside mb-5 text-gray-600">
                        <li class="mb-2"><img class="inline" src="/image/pharmacy_plenty.png"> 약국, <img class="inline" src="/image/post_plenty.png"> 우체국, <img class="inline" src="/image/agricultural_plenty.png"> 농협으로 표시됩니다.</li>
                        <li class="mb-2"><img class="inline" src="/image/pharmacy_plenty.png"> 녹색은 100개 이상</li>
                        <li class="mb-2"><img class="inline" src="/image/pharmacy_some.png"> 노란색은 30개 이상 100개미만</li>
                        <li class="mb-2"><img class="inline" src="/image/pharmacy_few.png"> 빨간색은 2개 이상 30개 미만</li>
                        <li class="mb-2"><img class="inline" src="/image/pharmacy_empty.png"> 회색은 1개 이하</li>
                    </ul>

                    <h3 class="mb-3"><i class="fas fa-clipboard-check"></i> 서비스 정보</h3>
                    <ul class="list-disc list-inside mb-5 text-gray-600">
                        <li class="mb-2">서비스되는 재고 현황 정보는 실제 현장 판매처의 현황과 5분~10분 정도의 차이가 있을 수 있습니다.</li>
                        <li class="mb-2">번호표 배부 후 판매하는 일부 약국의 마스크 현황 정보는 오차가 있을 수 있습니다.</li>
                        <li class="mb-2">마스크 현황 정보는 성인용 마스크를 대상으로 합니다.</li>
                        <li class="mb-2">데이터 출처는 심평원 정보화진흥원(공공데이터포털) 입니다.</li>
                    </ul>

{{--                    <h3 class="mb-3"><i class="fas fa-clipboard-check"></i> 유용한 링크</h3>--}}
{{--                    <ul class="list-disc list-inside mb-5 text-gray-600">--}}
{{--                        <li><a target="_blank" href="http://www.mohw.go.kr/react/index.jsp">보건복지부 <i class="fas fa-external-link-alt"></i></a></li>--}}
{{--                        <li><a target="_blank" href="https://www.data.go.kr/">공공데이터포털 <i class="fas fa-external-link-alt"></i></a></li>--}}
{{--                        <li><a target="_blank" href="http://blog.naver.com/kfdazzang/221839489769">식약처 공적마스크 구매 안내 <i class="fas fa-external-link-alt"></i></a></li>--}}
{{--                    </ul>--}}

                    <h3 class="mb-3"><i class="fas fa-clipboard-check"></i> 감사의 말</h3>
                    <ul class="list-disc list-inside mb-5 text-gray-600">
                        <li>어려운 환경에서도 일선에서 공헌해 주시고 계신 모든 분들에게 감사의 말씀을 전합니다. 감사합니다.</li>
                    </ul>

                    <h3 class="mb-3"><i class="fas fa-code"></i> 개발: ageofsys@gmail.com</h3>

                </div>

            </div>
        </div>

    </div>

    <div class="map-wrap">
        <div class="map_wrap">
            <div id="map" style="width:100%;height:100%;position:relative;overflow:hidden;"></div>

            <div id="search-address" class="search-address-frame">
                <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
            </div>

            <!-- 지도타입 컨트롤 div 입니다 -->
            <div class="custom_typecontrol radius_border d-none d-lg-block d-xl-block">
                <button type="button" class="btn btn-primary btn-sm shadow-lg" onclick="setMapType('roadmap')">지도</button>
                <button type="button" class="btn btn-secondary btn-sm shadow-lg" onclick="setMapType('skyview')">스카이뷰</button>
            </div>

            <div class="custom_typecontrol radius_border d-lg-none d-xl-none" style="left: 10px; background-color: #fff">
                <div class="input-group">
                    <input id="search-address-keyword-mobile" type="text" class="form-control" placeholder="주소를 검색하세요">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="search-address-btn-mobile"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>

            <div id="search-address-mobile" class="search-address-frame-mobile">
                <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
            </div>





            {{--        <div id="store-list" class="store-list-frame">--}}
            {{--            <p class="no-result" v-if="stores.length == 0">--}}
            {{--                검색된 판매처가 없습니다.--}}
            {{--            </p>--}}
            {{--            <ul class="list-group list-group-flush" v-else>--}}
            {{--                <li class="list-group-item" v-for="(store, index) in stores">--}}
            {{--                    <a class="" v-on:click="selectStore(store)">@{{ store.name }}</a>--}}
            {{--                    <br>--}}
            {{--                    @{{ store.remain_stat }} / @{{ store.stock_at }} / @{{ store.type }}--}}
            {{--                </li>--}}
            {{--            </ul>--}}
            {{--        </div>--}}

            <div id="store-sale-info" class="store-sale-info-frame shadow-lg d-none d-lg-block d-xl-block">
                <p class="no-result" v-if="storeSale.code == undefined">
                    <i class="fas fa-exclamation-triangle"></i> 판매처를 클릭하세요.
                </p>
                <div v-else>
                    <h3 class="h3 mb-3 text-gray-600"><i class="far fa-sticky-note"></i> 판매처 마스크 현황</h3>
                    <table class="table table-sm table-hover">
                        <tbody>
                        <tr>
                            <th style="width: 65px;" class="text-gray-600" scope="row">판매처명</th>
                            <td>@{{ storeSale.name }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-gray-600">재고수준</th>
                            <td>
                                <span class="text-gray-500" v-if="_.isEmpty(remainStatWord)">
                                    정보가 없습니다.
                                </span>
                                <span v-else>
                                    @{{ remainStatWord }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-gray-600">입고일</th>
                            <td>
                                <span class="text-gray-500" v-if="_.isEmpty(storeSale.stock_at)">
                                    정보가 없습니다.
                                </span>
                                <span v-else>
                                    @{{ storeSale.stock_at }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-gray-600">주소</th>
                            <td>
                                <span class="text-gray-500" v-if="_.isEmpty(storeSale.addr)">
                                    정보가 없습니다.
                                </span>
                                <span v-else>
                                    @{{ storeSale.addr }}
                                </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="d-lg-none d-xl-none mobile-bottom-wrap">
        <a class="btn btn-primary" href="{{ route("stores.index") }}" style="position: absolute; right: 0; bottom: 0">표로 검색하기</a>

        <ul class="list-disc list-inside text-gray-600" style="font-size: 9px; float: left">
            <li class="mb-2"><img class="inline" src="/image/pharmacy_plenty.png"> 100개 이상</li>
            <li class="mb-2"><img class="inline" src="/image/pharmacy_some.png"> 30개 이상 100개 미만</li>
            <li class="mb-2"><img class="inline" src="/image/pharmacy_few.png"> 2개 이상 30개 미만</li>
            <li class="mb-2"><img class="inline" src="/image/pharmacy_empty.png"> 1개 이하</li>
        </ul>
    </div>



</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.rawgit.com/rikmms/progress-bar-4-axios/0a3acf92/dist/index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey={{ config("public-mask.daum_rest_api_key") }}&libraries=services"></script>
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.15/lodash.min.js"></script>
<script>

    // loadProgressBar();

    $(document).ready(function () {

        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(300);
        });

        $("#search-address-btn").click(function () {
            var keyword = $("#search-address-keyword").val();
            searchAddress(keyword);
        })

        $("#search-address-btn-mobile").click(function () {
            var keyword = $("#search-address-keyword-mobile").val();
            searchAddressMobile(keyword);
        })

        $("#search-address-keyword").keypress(function (event) {
            if ( event.which == 13 ) {
                searchAddress($(this).val());
            }
        });


    })


    // 우편번호 찾기 찾기 화면을 넣을 element
    var element_wrap = document.getElementById('search-address');
    var element_wrap_mobile = document.getElementById('search-address-mobile');

    function foldDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
        element_wrap.style.display = 'none';
    }

    function foldDaumPostcodeMobile() {
        // iframe을 넣은 element를 안보이게 한다.
        element_wrap_mobile.style.display = 'none';
    }

    function searchAddressMobile(keyword) {
        new daum.Postcode({
            oncomplete: function(data) {

                resetCenterOfMapByAddress(map, data.roadAddress)

                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.



                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수

                //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }

                // iframe을 넣은 element를 안보이게 한다.
                // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                element_wrap_mobile.style.display = 'none';

                $("#search-address-keyword-mobile").val("")
            },
            // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
            onresize : function(size) {
                element_wrap_mobile.style.height = "500px";
            },
            width : '100%',
            height : '500px'
        }).embed(element_wrap_mobile, {
            q: keyword
        });

        // iframe을 넣은 element를 보이게 한다.
        element_wrap_mobile.style.display = 'block';
    }

    function searchAddress(keyword) {
        new daum.Postcode({
            oncomplete: function(data) {

                resetCenterOfMapByAddress(map, data.roadAddress)

                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.



                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수

                //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }

                // iframe을 넣은 element를 안보이게 한다.
                // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                element_wrap.style.display = 'none';

                $("#search-address-keyword").val("")
            },
            // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
            onresize : function(size) {
                element_wrap.style.height = "500px";
            },
            width : '100%',
            height : '500px'
        }).embed(element_wrap, {
            q: keyword
        });

        // iframe을 넣은 element를 보이게 한다.
        element_wrap.style.display = 'block';
    }





    var cmtinfoLatLng = new kakao.maps.LatLng(35.860924, 128.6865033);

    var mapContainer = document.getElementById('map'), // 지도를 표시할 div
        mapOption = {
            center: cmtinfoLatLng, // 지도의 중심좌표
            level: 4 // 지도의 확대 레벨
        };

    var map = new kakao.maps.Map(mapContainer, mapOption); // 지도를 생성합니다

    map.setMaxLevel(4);

    // 지도타입 컨트롤의 지도 또는 스카이뷰 버튼을 클릭하면 호출되어 지도타입을 바꾸는 함수입니다
    function setMapType(maptype) {
        var roadmapControl = document.getElementById('btnRoadmap');
        var skyviewControl = document.getElementById('btnSkyview');
        if (maptype === 'roadmap') {
            map.setMapTypeId(kakao.maps.MapTypeId.ROADMAP);
            roadmapControl.className = 'selected_btn';
            skyviewControl.className = 'btn';
        } else {
            map.setMapTypeId(kakao.maps.MapTypeId.HYBRID);
            skyviewControl.className = 'selected_btn';
            roadmapControl.className = 'btn';
        }
    }

    // 지도 확대, 축소 컨트롤에서 확대 버튼을 누르면 호출되어 지도를 확대하는 함수입니다
    function zoomIn() {
        map.setLevel(map.getLevel() - 1);
    }

    // 지도 확대, 축소 컨트롤에서 축소 버튼을 누르면 호출되어 지도를 확대하는 함수입니다
    function zoomOut() {
        map.setLevel(map.getLevel() + 1);
    }


    // 지도가 이동, 확대, 축소로 인해 중심좌표가 변경되면 마지막 파라미터로 넘어온 함수를 호출하도록 이벤트를 등록합니다
    kakao.maps.event.addListener(map, 'idle', function () {

        var bounds = map.getBounds();
        console.log("###################################");
        console.log(bounds.toString());
        console.log("###################################");

        // 지도의  레벨을 얻어옵니다
        var level = map.getLevel();

        // 지도의 중심좌표를 얻어옵니다
        var latlng = map.getCenter();

        var message = '<p>지도 레벨은 ' + level + ' 이고</p>';
        message += '<p>중심 좌표는 위도 ' + latlng.getLat() + ', 경도 ' + latlng.getLng() + '입니다</p>';

        // console.log(message);

        makeMarker2()

    });

    // 마커 이미지의 이미지 주소입니다
    var defaultImageSrc = "http://t1.daumcdn.net/localimg/localimages/07/mapapidoc/markerStar.png";

    var markers = [];
    var stores = [];

    // var vm = new Vue({
    //     el: "#store-list",
    //     data: {
    //         stores: stores
    //     },
    //     watch: {
    //         // whenever question changes, this function will run
    //         stores: function (newStores, oldStores) {
    //             // console.log(newStores)
    //         }
    //     },
    //     methods: {
    //         selectStore: function (store) {
    //             map.setCenter(new kakao.maps.LatLng(store.lat, store.lng))
    //         }
    //     }
    // })

    var maskRemainStatWord = {
        "plenty": "100개 이상",
        "some": "30개 이상 100개미만",
        "few": "2개 이상 30개 미만",
        "empty": "1개 이하"
    }

    var storeSaleInfoVm = new Vue({
        el: "#store-sale-info",
        data: {
            storeSale: {}
        },
        computed: {
            remainStatWord: function () {
                return maskRemainStatWord[this.storeSale.remain_stat]
            }
        }
    });

    function makeMarker2(lat, lng) {

        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }

        var bounds = map.getBounds();

        // 영역정보의 남서쪽 정보를 얻어옵니다
        var swLatlng = bounds.getSouthWest();

        // 영역정보의 북동쪽 정보를 얻어옵니다
        var neLatlng = bounds.getNorthEast();


        markers = [];

        $.get( '/search/stores',
            {
                sw_lat: swLatlng.getLat(),
                sw_lng: swLatlng.getLng(),
                ne_lat: neLatlng.getLat(),
                ne_lng: neLatlng.getLng(),
            })
            .done(function( data ) {
                var response = data;

                stores = response.stores;

                for (var i = 0; i < stores.length; i++) {
                    var store = stores[i];
                    // console.log(store);

                    imageSrc = "/image/";

                    // 약국
                    if (store.type == "01") {
                        imageSrc += "pharmacy_"
                    }
                    // 우체국
                    else if (store.type == "02") {
                        imageSrc += "post_"
                    }
                    // 농협협
                    else if (store.type == "03"){
                        imageSrc += "agricultural_"
                    }

                    if (store.remain_stat == "plenty" || store.remain_stat == "some"
                        || store.remain_stat == "few" || store.remain_stat == "empty") {
                        imageSrc += store.remain_stat + ".png";
                    } else {
                        imageSrc += "empty.png";
                    }

                    // 마커 이미지의 이미지 크기 입니다
                    var imageSize = new kakao.maps.Size(24, 35);

                    // 마커 이미지를 생성합니다
                    var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize);

                    // 마커를 생성합니다
                    var marker = new kakao.maps.Marker({
                        map: map, // 마커를 표시할 지도
                        position: new kakao.maps.LatLng(store.lat, store.lng), // 마커를 표시할 위치
                        title: store.name, // 마커의 타이틀, 마커에 마우스를 올리면 타이틀이 표시됩니다
                        image: markerImage, // 마커 이미지
                    });

                    marker.store = store;

                    var overlayContent = "<h1 id='overlay' style='width: 100px; height: 100px; outline: 1px solid red;'>" + store.name + "</h1>";

                    // 마커 위에 커스텀오버레이를 표시합니다
                    // 마커를 중심으로 커스텀 오버레이를 표시하기위해 CSS를 이용해 위치를 설정했습니다
                    // var overlay = new kakao.maps.CustomOverlay({
                    //     content: overlayContent,
                    //     map: map,
                    //     position: marker.getPosition()
                    // });

                    // 마커를 클릭했을 때 커스텀 오버레이를 표시합니다
                    kakao.maps.event.addListener(marker, 'click', function() {
                        storeSaleInfoVm.$data.storeSale = this.store;
                    });

                    markers.push(marker);

                }
            }).fail(function() {
                alert( "통신이 지연되고 있습니다. 잠시 후 다시 시도해주세요" );
            }).always(function () {
                setTimeout(function(){
                    $("#overlay").fadeOut(300);
                },500);
            });

        // axios.get('https://8oi9s0nnth.apigw.ntruss.com/corona19-masks/v1/storesByGeo/json', {
        //     params: {
        //         lat: lat,
        //         lng: lng,
        //         m: distance
        //     }
        // })
        //     .then(function (response) {
        //
        //         stores = response.data.stores;
        //
        //         for (var i = 0; i < stores.length; i++) {
        //             var store = stores[i];
        //             // console.log(store);
        //
        //             imageSrc = "/image/";
        //
        //             // 약국
        //             if (store.type == "01") {
        //                 imageSrc += "pharmacy_"
        //             }
        //             // 우체국
        //             else if (store.type == "02") {
        //                 imageSrc += "post_"
        //             }
        //             // 농협협
        //             else if (store.type == "03"){
        //                 imageSrc += "agricultural_"
        //             }
        //
        //             if (store.remain_stat == "plenty" || store.remain_stat == "some"
        //                 || store.remain_stat == "few" || store.remain_stat == "empty") {
        //                 imageSrc += store.remain_stat + ".png";
        //             } else {
        //                 imageSrc += "empty.png";
        //             }
        //
        //             // 마커 이미지의 이미지 크기 입니다
        //             var imageSize = new kakao.maps.Size(24, 35);
        //
        //             // 마커 이미지를 생성합니다
        //             var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize);
        //
        //             // 마커를 생성합니다
        //             var marker = new kakao.maps.Marker({
        //                 map: map, // 마커를 표시할 지도
        //                 position: new kakao.maps.LatLng(store.lat, store.lng), // 마커를 표시할 위치
        //                 title: store.name, // 마커의 타이틀, 마커에 마우스를 올리면 타이틀이 표시됩니다
        //                 image: markerImage, // 마커 이미지
        //             });
        //
        //             marker.store = store;
        //
        //             var overlayContent = "<h1 id='overlay' style='width: 100px; height: 100px; outline: 1px solid red;'>" + store.name + "</h1>";
        //
        //             // 마커 위에 커스텀오버레이를 표시합니다
        //             // 마커를 중심으로 커스텀 오버레이를 표시하기위해 CSS를 이용해 위치를 설정했습니다
        //             // var overlay = new kakao.maps.CustomOverlay({
        //             //     content: overlayContent,
        //             //     map: map,
        //             //     position: marker.getPosition()
        //             // });
        //
        //             // 마커를 클릭했을 때 커스텀 오버레이를 표시합니다
        //             kakao.maps.event.addListener(marker, 'click', function() {
        //                 storeSaleInfoVm.$data.storeSale = this.store;
        //             });
        //
        //             markers.push(marker);
        //
        //         }
        //
        //         // vm.$data.stores = stores;
        //     })
        //     .catch(function (error) {
        //         console.log(error);
        //     })
        //     .then(function () {
        //         // always executed
        //     });

    }

    function makeMarker(lat, lng) {

        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }

        var bounds = map.getBounds();

        // 영역정보의 남서쪽 정보를 얻어옵니다
        var swLatlng = bounds.getSouthWest();

        // 영역정보의 북동쪽 정보를 얻어옵니다
        var neLatlng = bounds.getNorthEast();

        var distance = getDistanceFromTwoPoint([swLatlng, neLatlng])

        markers = [];

        $.get( 'https://8oi9s0nnth.apigw.ntruss.com/corona19-masks/v1/storesByGeo/json',
            {
                lat: lat,
                lng: lng,
                m: distance
            })
            .done(function( data ) {
                var response = data;

                stores = response.stores;

                for (var i = 0; i < stores.length; i++) {
                    var store = stores[i];
                    // console.log(store);

                    imageSrc = "/image/";

                    // 약국
                    if (store.type == "01") {
                        imageSrc += "pharmacy_"
                    }
                    // 우체국
                    else if (store.type == "02") {
                        imageSrc += "post_"
                    }
                    // 농협협
                    else if (store.type == "03"){
                        imageSrc += "agricultural_"
                    }

                    if (store.remain_stat == "plenty" || store.remain_stat == "some"
                        || store.remain_stat == "few" || store.remain_stat == "empty") {
                        imageSrc += store.remain_stat + ".png";
                    } else {
                        imageSrc += "empty.png";
                    }

                    // 마커 이미지의 이미지 크기 입니다
                    var imageSize = new kakao.maps.Size(24, 35);

                    // 마커 이미지를 생성합니다
                    var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize);

                    // 마커를 생성합니다
                    var marker = new kakao.maps.Marker({
                        map: map, // 마커를 표시할 지도
                        position: new kakao.maps.LatLng(store.lat, store.lng), // 마커를 표시할 위치
                        title: store.name, // 마커의 타이틀, 마커에 마우스를 올리면 타이틀이 표시됩니다
                        image: markerImage, // 마커 이미지
                    });

                    marker.store = store;

                    var overlayContent = "<h1 id='overlay' style='width: 100px; height: 100px; outline: 1px solid red;'>" + store.name + "</h1>";

                    // 마커 위에 커스텀오버레이를 표시합니다
                    // 마커를 중심으로 커스텀 오버레이를 표시하기위해 CSS를 이용해 위치를 설정했습니다
                    // var overlay = new kakao.maps.CustomOverlay({
                    //     content: overlayContent,
                    //     map: map,
                    //     position: marker.getPosition()
                    // });

                    // 마커를 클릭했을 때 커스텀 오버레이를 표시합니다
                    kakao.maps.event.addListener(marker, 'click', function() {
                        storeSaleInfoVm.$data.storeSale = this.store;
                    });

                    markers.push(marker);

                }
            }).fail(function() {
                alert( "통신이 지연되고 있습니다. 잠시 후 다시 시도해주세요" );
            }).always(function () {
                setTimeout(function(){
                    $("#overlay").fadeOut(300);
                },500);
            });

        // axios.get('https://8oi9s0nnth.apigw.ntruss.com/corona19-masks/v1/storesByGeo/json', {
        //     params: {
        //         lat: lat,
        //         lng: lng,
        //         m: distance
        //     }
        // })
        //     .then(function (response) {
        //
        //         stores = response.data.stores;
        //
        //         for (var i = 0; i < stores.length; i++) {
        //             var store = stores[i];
        //             // console.log(store);
        //
        //             imageSrc = "/image/";
        //
        //             // 약국
        //             if (store.type == "01") {
        //                 imageSrc += "pharmacy_"
        //             }
        //             // 우체국
        //             else if (store.type == "02") {
        //                 imageSrc += "post_"
        //             }
        //             // 농협협
        //             else if (store.type == "03"){
        //                 imageSrc += "agricultural_"
        //             }
        //
        //             if (store.remain_stat == "plenty" || store.remain_stat == "some"
        //                 || store.remain_stat == "few" || store.remain_stat == "empty") {
        //                 imageSrc += store.remain_stat + ".png";
        //             } else {
        //                 imageSrc += "empty.png";
        //             }
        //
        //             // 마커 이미지의 이미지 크기 입니다
        //             var imageSize = new kakao.maps.Size(24, 35);
        //
        //             // 마커 이미지를 생성합니다
        //             var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize);
        //
        //             // 마커를 생성합니다
        //             var marker = new kakao.maps.Marker({
        //                 map: map, // 마커를 표시할 지도
        //                 position: new kakao.maps.LatLng(store.lat, store.lng), // 마커를 표시할 위치
        //                 title: store.name, // 마커의 타이틀, 마커에 마우스를 올리면 타이틀이 표시됩니다
        //                 image: markerImage, // 마커 이미지
        //             });
        //
        //             marker.store = store;
        //
        //             var overlayContent = "<h1 id='overlay' style='width: 100px; height: 100px; outline: 1px solid red;'>" + store.name + "</h1>";
        //
        //             // 마커 위에 커스텀오버레이를 표시합니다
        //             // 마커를 중심으로 커스텀 오버레이를 표시하기위해 CSS를 이용해 위치를 설정했습니다
        //             // var overlay = new kakao.maps.CustomOverlay({
        //             //     content: overlayContent,
        //             //     map: map,
        //             //     position: marker.getPosition()
        //             // });
        //
        //             // 마커를 클릭했을 때 커스텀 오버레이를 표시합니다
        //             kakao.maps.event.addListener(marker, 'click', function() {
        //                 storeSaleInfoVm.$data.storeSale = this.store;
        //             });
        //
        //             markers.push(marker);
        //
        //         }
        //
        //         // vm.$data.stores = stores;
        //     })
        //     .catch(function (error) {
        //         console.log(error);
        //     })
        //     .then(function () {
        //         // always executed
        //     });

    }

    function getDistanceFromTwoPoint(twoPoint) {
        var lat1 = twoPoint[0].getLat();
        var lng1 = twoPoint[0].getLng();
        var lat2 = twoPoint[1].getLat();
        var lng2 = twoPoint[1].getLng();

        function deg2rad(deg) {
            return deg * (Math.PI / 180)
        }

        var r = 6371; //지구의 반지름(km)
        var dLat = deg2rad(lat2 - lat1);
        var dLon = deg2rad(lng2 - lng1);
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var d = r * c; // Distance in km
        return Math.round(d * 1000);
    }

    function resetCenterOfMapByAddress(map, address) {
        // 주소-좌표 변환 객체를 생성합니다
        var geocoder = new kakao.maps.services.Geocoder();

        // 주소로 좌표를 검색합니다
        geocoder.addressSearch(address, function(result, status) {

            // 정상적으로 검색이 완료됐으면
            if (status === kakao.maps.services.Status.OK) {

                var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

                // 결과값으로 받은 위치를 마커로 표시합니다
                var marker = new kakao.maps.Marker({
                    map: map,
                    position: coords
                });

                // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
                map.setCenter(coords);
            }
        });
    }

    $(document).ready(function () {
        makeMarker2()
    });


</script>
</body>
</html>
