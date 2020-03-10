<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>공공 마스크정보 - @yield('title')</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .remain-stat-plenty { color: #28a745; } /*100개 이상(녹색): 'plenty'*/
        .remain-stat-some { color: #ffc107; } /*30개 이상 100개미만(노랑색): 'some' */
        .remain-stat-few { color: #dc3545; } /*2개 이상 30개 미만(빨강색): 'few' */
        .remain-stat-empty { color: #6c757d; } /*1개 이하(회색): 'empty'*/

        body {
            padding-left: 360px;
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

        .map-wrap {

        }

    </style>

    <style>

            .container-fluid {
                padding-left: 0;
                padding-right: 0;
            }

            .search-address-frame {
                position: absolute;
                top: 50px;
                left: 10px;
                display: none;
                border: 1px solid #ccc;
                width: 500px;
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
                width: 300px;
                overflow-y: scroll;
                background-color: #fff;
                border: 1px solid #ccc;
            }

            .store-sale-info-frame .no-result {
                padding: 1rem;
            }

            .map_wrap {
                position: relative;
                overflow: hidden;
                width: 100%;
                height: 100vh;
            }

            .custom_searchaddress {
                position: absolute;
                top: 10px;
                left: 10px;
                overflow: hidden;
                margin: 0;
                padding: 0;
                z-index: 1;
                font-size: 12px;
                font-family: 'Malgun Gothic', '맑은 고딕', sans-serif;
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

            /*.custom_typecontrol span {display:block;width:65px;height:30px;float:left;text-align:center;line-height:30px;cursor:pointer;}*/
            /*.custom_typecontrol .daum_btn {background:#fff;background:linear-gradient(#fff,  #e6e6e6);}*/
            /*.custom_typecontrol .daum_btn:hover {background:#f5f5f5;background:linear-gradient(#f5f5f5,#e3e3e3);}*/
            /*.custom_typecontrol .daum_btn:active {background:#e6e6e6;background:linear-gradient(#e6e6e6, #fff);}*/
            /*.custom_typecontrol .daum_selected_btn {color:#fff;background:#425470;background:linear-gradient(#425470, #5b6d8a);}*/
            /*.custom_typecontrol .daum_selected_btn:hover {color:#fff;}*/
            .custom_zoomcontrol {
                position: absolute;
                top: 50px;
                right: 10px;
                width: 36px;
                height: 80px;
                overflow: hidden;
                z-index: 1;
                background-color: #f5f5f5;
            }

            /*.custom_zoomcontrol span {display:block;width:36px;height:40px;text-align:center;cursor:pointer;}*/
            /*.custom_zoomcontrol span img {width:15px;height:15px;padding:12px 0;border:none;}*/
            /*.custom_zoomcontrol span:first-child{border-bottom:1px solid #bfbfbf;}*/

        </style>
</head>
<body>

<div class="page-wrap">

    <div class="left-menu-wrap border-r">

        <div class="row">
            <div class="col">

                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-gray-100">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="주소를 검색하세요" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon2">검색</button>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <a class="nav-link pl-0" href="{{ route("search.index") }}">주소로 검색하기</a>
                    </li>
                    <li class="list-group-item">
                        <a class="nav-link pl-0" href="{{ route("stores.index") }}">판매처 원본 데이터</a>
                    </li>
                    <li class="list-group-item">
                        <a class="nav-link pl-0" href="{{ route("sales.index") }}">판매 원본 데이터</a>
                    </li>
                    <li class="list-group-item"></li>
                </ul>



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
            <div class="custom_searchaddress radius_border">
                <button type="button" class="btn btn-primary btn-sm" onclick="searchAddress()">주소검색</button>
            </div>

            <!-- 지도타입 컨트롤 div 입니다 -->
            <div class="custom_typecontrol radius_border">
                <button type="button" class="btn btn-primary btn-sm" onclick="setMapType('roadmap')">지도</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="setMapType('skyview')">스카이뷰</button>
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

            <div id="store-sale-info" class="store-sale-info-frame">
                <p class="no-result" v-if="storeSale.code == undefined">
                    판매처를 클릭하세요.
                </p>
                <div v-else>
                    <table class="table table-sm">
                        <tbody>
                        <tr>
                            <th style="width: 65px" scope="row">판매처명</th>
                            <td>@{{ storeSale.name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">재고수준</th>
                            <td>@{{ storeSale.remain_stat }}</td>
                        </tr>
                        <tr>
                            <th scope="row">입고일</th>
                            <td>@{{ storeSale.stock_at }}</td>
                        </tr>
                        <tr>
                            <th scope="row">주소</th>
                            <td>@{{ storeSale.addr }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>



<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey={{ config("public-mask.daum_rest_api_key") }}&libraries=services"></script>
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>


    // 우편번호 찾기 찾기 화면을 넣을 element
    var element_wrap = document.getElementById('search-address');

    function foldDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
        element_wrap.style.display = 'none';
    }

    function searchAddress() {
        // 현재 scroll 위치를 저장해놓는다.
        var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
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

                // 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
                document.body.scrollTop = currentScroll;
            },
            // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
            onresize : function(size) {
                element_wrap.style.height = "500px";
            },
            width : '100%',
            height : '500px'
        }).embed(element_wrap);

        // iframe을 넣은 element를 보이게 한다.
        element_wrap.style.display = 'block';
    }





    var cmtinfoLatLng = new kakao.maps.LatLng(35.860924, 128.6865033);

    var mapContainer = document.getElementById('map'), // 지도를 표시할 div
        mapOption = {
            center: cmtinfoLatLng, // 지도의 중심좌표
            level: 3 // 지도의 확대 레벨
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
    kakao.maps.event.addListener(map, 'center_changed', function () {

        // 지도의  레벨을 얻어옵니다
        var level = map.getLevel();

        // 지도의 중심좌표를 얻어옵니다
        var latlng = map.getCenter();

        var message = '<p>지도 레벨은 ' + level + ' 이고</p>';
        message += '<p>중심 좌표는 위도 ' + latlng.getLat() + ', 경도 ' + latlng.getLng() + '입니다</p>';

        // console.log(message);

        makeMarker(latlng.getLat(), latlng.getLng())

    });

    // 지도가 이동, 확대, 축소로 인해 지도영역이 변경되면 마지막 파라미터로 넘어온 함수를 호출하도록 이벤트를 등록합니다
    kakao.maps.event.addListener(map, 'bounds_changed', function () {

        // // 지도의 중심좌표를 얻어옵니다
        // var latlng = map.getCenter();
        //
        // // 지도 영역정보를 얻어옵니다
        // var bounds = map.getBounds();
        //
        // // 영역정보의 남서쪽 정보를 얻어옵니다
        // var swLatlng = bounds.getSouthWest();
        //
        // // 영역정보의 북동쪽 정보를 얻어옵니다
        // var neLatlng = bounds.getNorthEast();
        //
        // var message = '<p>영역좌표는 남서쪽 위도, 경도는  ' + swLatlng.toString() + '이고 <br>';
        // message += '북동쪽 위도, 경도는  ' + neLatlng.toString() + '입니다 </p>';
        //
        // console.log(message);
        //
        // makeMarker(latlng.getLat(), latlng.getLng())

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

    var storeSaleInfoVm = new Vue({
        el: "#store-sale-info",
        data: {
            storeSale: {}
        }
    });

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

        axios.get('https://8oi9s0nnth.apigw.ntruss.com/corona19-masks/v1/storesByGeo/json', {
            params: {
                lat: lat,
                lng: lng,
                m: distance
            }
        })
            .then(function (response) {

                stores = response.data.stores;

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

                // vm.$data.stores = stores;
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(function () {
                // always executed
            });

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



</script>
</body>
</html>
