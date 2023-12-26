


@include('dashboard.layouts.header')

<div class="page-wrapper">
	<div class="container">
		<div class="row">

			<div class="col-12">
				<h2 class="main-title">
					إضافة مكان جديد:
				</h2>
			</div>
           
		 <form class="form-group col-12" method="POST" enctype="multipart/form-data" action="{{ url('admin/item/store') }}"> 
				@csrf
				<div class="group two">
					<label>اسم المكان (باللغة العربية): <span class="require">*</span></label>
					<input type="text" name="item_title_ar" required>
					@if ($errors->has('item_title_ar'))
						<span class="text-danger">{{ $errors->first('item_title_ar') }}</span>
					@endif
				</div>
				<div class="group two">
					<label>اسم المكان (باللغة الانكليزية): <span class="require">*</span></label>
					<input type="text" name="item_title_en" required>
					@if ($errors->has('item_title_en'))
						<span class="text-danger">{{ $errors->first('item_title_en') }}</span>
					@endif
				</div>
				<div class="clear"></div>
				<div class="group two">
					<label>وصف المكان (باللغة العربية): <span class="require" required>*</span></label>
					<textarea name="item_desc_ar" required></textarea>
					@if ($errors->has('item_desc_ar'))
						<span class="text-danger">{{ $errors->first('item_desc_ar') }}</span>
					@endif
				</div>
				<div class="group two">
					<label>وصف المكان (باللغة الانكليزية): <span class="require">*</span></label>
					<textarea name="item_desc_en" required></textarea>
					@if ($errors->has('item_desc_en'))
						<span class="text-danger">{{ $errors->first('item_desc_en') }}</span>
					@endif
				</div>
				<div class="clear"></div>
				<div class="group">
					<label>تصنيف المكان: <span class="require">*</span></label>
					<ul class="radio-choices">
						@foreach ($categories as $category)
						<li class="radio-box">
							<input type="checkbox" value="{{ $category->id }}" name="category[]">
							<span>
								{{ $category->translate('ar')->name }}
							</span>
						</li>
						@endforeach
						@if(count($categories) == 1)
						<li class="radio-box">
							<input type="checkbox" value="{{ $categories[0]->id }}" checked disabled name="category[]">
							<span>
								{{ $categories[0]->translate('ar')->name }}
							</span>
						</li>
						@endif
					</ul>
				</div>
				<div class="group two">
					<label>عنوان المكان (باللغة العربية): <span class="require">*</span></label>
					<input type="text" name="item_address_ar" required>
					@if ($errors->has('item_address_ar'))
						<span class="text-danger">{{ $errors->first('item_address_ar') }}</span>
					@endif
				</div>
				<div class="group two">
					<label>عنوان المكان (باللغة الانكليزية): <span class="require">*</span></label>
					<input type="text" name="item_address_en" required>
					@if ($errors->has('item_address_en'))
						<span class="text-danger">{{ $errors->first('item_address_en') }}</span>
					@endif
				</div>
				<div class="clear"></div>

				<div class="group two">
					<label>المدينة التابع لها: <span class="require">*</span></label>
					<select name="item_city" required>
						<option selected disabled>-- اختر مدينةً --</option>
						@foreach ($cities as $city)
						<option value='{{ $city->id }}'>{{ $city->translate('ar')->name }}</option>
						@endforeach
					</select>
					@if ($errors->has('item_city'))
						<span class="text-danger">{{ $errors->first('item_city') }}</span>
					@endif
				</div>
				<div class="group two">
					<label>رابط المكان:</label>
					<input type="tel" name="res_link">
					@if ($errors->has('res_link'))
						<span class="text-danger">{{ $errors->first('res_link') }}</span>
					@endif
				</div>
				<div class="clear"></div>
				<div class="group two">
					<label>رقم الهاتف: <span class="require">*</span></label>
					<input type="tel" name="item_phone" required>
					@if ($errors->has('item_phone'))
						<span class="text-danger">{{ $errors->first('item_phone') }}</span>
					@endif
				</div>
				<div class="group two">
					<label>رقم واتس اب:</label>
					<input type="tel" name="whatsapp_phone" >
					@if ($errors->has('whatsapp_phone'))
						<span class="text-danger">{{ $errors->first('whatsapp_phone') }}</span>
					@endif
				</div>
				<div class="clear"></div>
				<div class="group">
					<label>صور المكان: <span class="require">*</span></label>
					<input type="file" name="img[]" accept="image/*" multiple required id="item_image">
					@if ($errors->has('img'))
						<span class="text-danger">{{ $errors->first('img') }}</span>
					@endif
					@if ($errors->has('img.*'))
						<span class="text-danger">{{ $errors->first('img.*') }}</span>
					@endif
				</div>
				<div class="map-box">
					<label>الموقع على الخريطه<span class="require">*</span></label>
					<input	id="pac-input"	class="controls" type="text" placeholder="Search Box">
					<div id="map"></div>
					@if ($errors->has('longitude'))
						<span class="text-danger">{{ $errors->first('longitude') }}</span>
					@endif
				</div>
				
				<div class="group">
					<label>نوع تصوير الكود <span class="require">*</span></label>
					<select name="imaging_type" required>
						<option selected disabled>-- اختر نوع التصوير --</option>
						<option value='user'>تصوير كود الزبون</option>
						<option value='Casher'>التصوير عند الكاشير</option>
					</select>
					@if ($errors->has('imaging_type'))
						<span class="text-danger">{{ $errors->first('imaging_type') }}</span>
					@endif
				</div>
                <div class="group two">
                    <label>قائمة الطعام (اللغة العربية)</label>
                    <textarea name="food_menu_ar"></textarea>
                </div>
				<div class="group two">
                    <label>قائمة الطعام (اللغة الانكليزية)</label>
                    <textarea name="food_menu_en"></textarea>
                </div>
				<div class="clear"></div>

				<hr>
                <h5>بيانات الـ SEO: </h5>
				<div class="group two">
                    <label>Meta Title (اللغة العربية)</label>
                    <input type="text" name="meta_title_ar">
                </div>            
                <div class="group two">
                    <label>Meta Title (اللغة الانكليزية)</label>
                    <input type="text" name="meta_title_en">
                </div>
                
                <div class="group two">
                    <label>Meta keywards (اللغة العربية)</label>
                    <input type="text" name="meta_keywards_ar">
                </div>                <div class="group two">
                    <label>Meta keywards (اللغة الانكليزية)</label>
                    <input type="text" name="meta_keywards_en">
                </div>

                <div class="group two">
                    <label>Meta Discription (اللغة العربية)</label>
                    <input type="text" name="meta_Discription_ar">
                </div>            
                <div class="group two">
                    <label>Meta Discription (اللغة الانكليزية)</label>
                    <input type="text" name="meta_Discription_en">
                </div>
				<div class="clear"></div>

				<input type="hidden" name="item_states" value="1">
				<input type="hidden" name="longitude">
				<input type="hidden" name="latitude">

				<div class="group">
					<button type="submit">إضافة</button>
				</div>
			</form>

		</div>
	</div>
</div>
    <script>
      var place_temp, place_lat, place_lng, markers = [];

        function initAutocomplete() {
          const myLatlng = { lat: 24.493718, lng:45.95239 };
          const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 10,
            center: myLatlng,
            mapTypeId: "roadmap",
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
             
				$('input[name="longitude"]').val(place_lng);
				$('input[name="latitude"]').val(place_lat);
			});
            map.fitBounds(bounds);
          });

          // Create the initial InfoWindow.
          let infoWindow = new google.maps.InfoWindow({
            content: "ابحث أو انقر لتحديد مكان",
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

            var marker = new google.maps.Marker({
              position: mapsMouseEvent.latLng,
              map: map,
            });
            markers.push(marker);
            infoWindow.setContent(JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2));
            place_temp = infoWindow.content;
            place_temp = JSON.parse(place_temp)
            place_lat = place_temp.lat;
            place_lng = place_temp.lng;
            console.log(place_lat,place_lng);
            $('input[name="longitude"]').val(place_lng);
		    $('input[name="latitude"]').val(place_lat);
          });

        }      
    </script>
<!-- Message -->
@if(session()->has('message'))
<p class="message-box done">
	{{ session()->get('message') }}
</p>
@endif
<!-- ./Message -->
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>	
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAufMZJuYiLNoAm2-nO7wP_E-sfk5AlGPo&callback=initAutocomplete&libraries=places&v=weekly&channel=2" async></script>
@include('dashboard.layouts.footer')		