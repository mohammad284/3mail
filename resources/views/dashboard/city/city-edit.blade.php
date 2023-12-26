@include('dashboard.layouts.header')

<div class="page-wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <h2 class="main-title">
                    تعديل بيانات المدينة:
                </h2>
            </div>
       
            <form class="form-group col-12" method="POST" enctype="multipart/form-data" action="{{ url('admin/city/update/'.$city->id) }}">
                @csrf
                <div class="group two">
                    <label>اسم المدينة (اللغة العربية) <span class="require">*</span></label>
                    <input type="text" name="city_name_ar" value="{{ $city->translate('ar')->name }}" required>
                    @if ($errors->has('city_name_ar'))
                    <span class="text-danger">{{ $errors->first('city_name_ar') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label>اسم المدينة (اللغة الانكليزية) <span class="require">*</span></label>
                    <input type="text" name="city_name_en" value="{{ $city->translate('en')->name }}" required>
                    @if ($errors->has('city_name_en'))
                    <span class="text-danger">{{ $errors->first('city_name_en') }}</span>
                    @endif
                </div>
                <div class="clear"></div>
                <div class="group">
                    <label>صورة المدينة:</label>
                    <input type="file" name="img" accept="image/*" id="image">
                    @if ($errors->has('img'))
                    <span class="text-danger">{{ $errors->first('img') }}</span>
                    @endif
                   
                </div>
				<div class="group ">
					<label>عرض الصورة</label>
					<div class="row">
						
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="guide-block">
                                <img src="{{ asset ($city->image) }}" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="map-box ">
                    <label> موقع المدينة على الخريطة: <span class="require">*</span></label>
                    <input id="pac-input" class="controls" type="text" placeholder="اكتب اسم المدينة للبحث"/>
				    <div  id="map"></div>
                    @if ($errors->has('longitude'))
                    <span class="text-danger">{{ $errors->first('longitude') }}</span>
                    @endif
                </div>

                <hr>
                <h5>بيانات الـ SEO: </h5>
                <div class="group two">
                    <label>Meta Title (اللغة العربية) <span class="require">*</span></label>
                    <input type="text" name="meta_title_ar" value="{{ $city->translate('ar')->meta_title }}" required>
                </div>
                <div class="group two">
                    <label>Meta Title (اللغة الانكليزية) <span class="require">*</span></label>
                    <input type="text" name="meta_title_en" value="{{ $city->translate('en')->meta_title }}" required>
                </div>
                
                <div class="group two">
                    <label>Meta keywards (اللغة العربية) <span class="require">*</span></label>
                    <input type="text" name="meta_keywards_ar" value="{{ $city->translate('ar')->meta_keywards }}" required>
                </div>
                <div class="group two">
                    <label>Meta keywards (اللغة الانكليزية) <span class="require">*</span></label>
                    <input type="text" name="meta_keywards_en" value="{{ $city->translate('en')->meta_keywards}}" required>
                </div>

                <div class="group two">
                    <label>Meta Discription (اللغة العربية) <span class="require">*</span></label>
                    <input type="text" name="meta_Discription_ar" value="{{$city->translate('ar')->meta_Discription}}" required>
                </div>
                <div class="group two">
                    <label>Meta Discription (اللغة الانكليزية) <span class="require">*</span></label>
                    <input type="text" name="meta_Discription_en" value="{{ $city->translate('en')->meta_Discription}}" required>
                </div>
                <div class="group two" style="display: none;">
                    <label>longitude <span class="require">*</span></label>
                    <input type="text" name="longitude" value="{{ $city->longitude}}" required>
                </div>
				<div class="group two" style="display: none;">
                    <label>latitude <span class="require">*</span></label>
                    <input type="text" name="latitude" value="{{ $city->latitude}}" required>
                </div>
                <div class="clear"></div>
                <div class="group">
                    <button type="submit">حفظ</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Message -->
@if(session()->has('message'))
<p class="message-box done">
    {{ session()->get('message') }}
</p>
@endif
<!-- ./Message -->

<script>
    var place_temp, place_lat, place_lng, markers = [];

    function initAutocomplete() {
        const myLatlng = { lat: {{ $city->latitude}}, lng:{{ $city->longitude}}};
        const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 9,
        center: myLatlng,
        mapTypeId: "roadmap",
        });
        var marker = new google.maps.Marker({
			position: myLatlng, 
			map: map,
		});
        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
        searchBox.setBounds(map.getBounds());
        });
        
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }
        // Clear out the old markers.
        markers.forEach((marker) => {
            marker.setMap(null);
        });
        markers = [];
        // For each place, get the icon, name and location.
        const bounds = new google.maps.LatLngBounds();
        places.forEach((place) => {
            if (!place.geometry || !place.geometry.location) {
            console.log("Returned place contains no geometry");
            return;
            }
            const icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25),
            };
            // Create a marker for each place.
            markers.push(
            new google.maps.Marker({
                map,
                title: place.name,
                position: place.geometry.location,
                
            })
            );
            
            if (place.geometry.viewport) {
            // Only geocodes have viewport.
            bounds.union(place.geometry.viewport);
            } else {
            bounds.extend(place.geometry.location);
            }
            place_lat = place.geometry.location.lat();
            place_lng = place.geometry.location.lng();
            console.log(place_lat,place_lng);
        });
        map.fitBounds(bounds);
        });

        // Create the initial InfoWindow.
        let infoWindow = new google.maps.InfoWindow({
        content: "ابحث أو انقر لتغيير المكان",
        position: myLatlng,
        });
        infoWindow.open(map);
        // Configure the click listener.
        map.addListener("click", (mapsMouseEvent) => {
        for(i=0; i<markers.length; i++){
            markers[i].setMap(null);
        }
        markers = [];
        // Close the current InfoWindow.
        infoWindow.close();
        // Create a new InfoWindow.
        infoWindow = new google.maps.InfoWindow({
            position : mapsMouseEvent.latLng,
        });
        marker.setMap(null);
        marker = new google.maps.Marker({
            position: mapsMouseEvent.latLng,
            map: map,
        });
        markers.push(marker);
        infoWindow.setContent(JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2));
        place_temp = infoWindow.content;
        place_temp = JSON.parse(place_temp)
        place_lat = place_temp.lat;
        place_lng = place_temp.lng;
        $('input[name="longitude"]').val(place_lng);
            $('input[name="latitude"]').val(place_lat);
        });

    }      
</script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>	
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0yShT09CRrUR1MeSKYdsmvtXgBbIqV80&callback=initAutocomplete&libraries=places&v=weekly&channel=2" async></script>

@include('dashboard.layouts.footer')