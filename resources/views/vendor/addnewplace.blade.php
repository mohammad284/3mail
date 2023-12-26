<?php
  $lang = Session('locale');
  $title = __('اضافة مكان جديد');
  if ($lang != "en") {
      $lang = "ar";
  }
?>

@include('front_views.layouts.header')
@include('vendor.layouts.sidemenu')

<div id="tg-content" class="tg-content">
	<div class="tg-dashboard">
		
		
		<div class="tg-box tg-changepassword">
			<div class="tg-heading">
				<h3>{{__('اضافة مكان جديد')}}</h3>
			</div>
			<div class="tg-dashboardcontent">
				@if($user ->vendor_request == 1)
				<div class="alert alert-danger">
					<strong>{{__('ستتمكن من إضافة معلم بعد قبول الإدارة طلب عضويتك كمزود خدمة لدى عميل')}} </strong>
				</div> 
				@endif
				@if($user ->vendor_request == 0 && $user->cancel_account ==0)
				<form class="tg-formtheme tg-formdashboard" method="POST" enctype="multipart/form-data" action="/dashboard/addnewplace">
					@csrf
					<div class="tg-content">
						<fieldset>
							<div class="form-group">
								<label>{{__('اسم المكان(باللغة العربية)')}}<sup>*</sup></label>
								<input type="text" name="item_title_ar" class="form-control @if($errors->has('item_title_ar')) error-input @endif" required>
								@if($errors->has('item_title_ar')) 
								@if ($lang == 'en')
									<span class="invalid-feedback" role="alert">
										This field is required!
									</span>
								@else 
									<span class="invalid-feedback" role="alert">
										هذا الحقل مطلوب!
									</span>
								@endif
								@endif
							</div>
							<div class="form-group">
								<label> {{__('اسم المكان(باللغة الانكليزية اختياري)')}}</label>
								<input type="text" name="item_title_en" class="form-control">
							</div>
							<div class="clear"></div>
							<div class="form-group">
								<label>{{__('وصف المكان(باللغة العربية)')}}<sup>*</sup></label>
								<textarea name="item_desc_ar" class="form-control @if($errors->has('item_desc_ar')) error-input @endif" required></textarea>
								@if($errors->has('item_desc_ar')) 
								@if ($lang == 'en')
									<span class="invalid-feedback" role="alert">
										This field is required!
									</span>
								@else 
									<span class="invalid-feedback" role="alert">
										هذا الحقل مطلوب!
									</span>
								@endif
								@endif
							</div>
							<div class="form-group">
								<label> {{__('وصف المكان(باللغة الانكليزية اختياري)')}}</label>
								<textarea  name="item_desc_en" class="form-control"></textarea>
							</div>
							<div class="clear"></div>
							<div class="form-group">
								<label>{{__('عنوان المكان(باللغة العربية)')}}<sup>*</sup></label>
								<input type="text" name="item_address_ar" class="form-control @if($errors->has('item_address_ar')) error-input @endif" required>
								@if($errors->has('item_address_ar')) 
								@if ($lang == 'en')
									<span class="invalid-feedback" role="alert">
										This field is required!
									</span>
								@else 
									<span class="invalid-feedback" role="alert">
										هذا الحقل مطلوب!
									</span>
								@endif
								@endif
							</div>
							<div class="form-group">
								<label> {{__('عنوان المكان(باللغة الانكليزية اختياري)')}}</label>
								<input type="text" name="item_address_en" class="form-control">
							</div>
							<div class="clear"></div>
							<div class="form-group">
								<label>{{__('رقم الهاتف')}}<sup>*</sup></label>
								<input type="text" name="item_phone" class="form-control @if($errors->has('item_phone')) error-input @endif" required>
								@if($errors->has('item_phone')) 
								@if ($lang == 'en')
									<span class="invalid-feedback" role="alert">
										This field is required!
									</span>
								@else 
									<span class="invalid-feedback" role="alert">
										هذا الحقل مطلوب!
									</span>
								@endif
								@endif
							</div>
							<div class="form-group">
								<label>{{__('رقم واتس اب')}}</label>
								<input type="text" name="whatsapp_phone" class="form-control">
							</div>
							<div class="clear"></div>
							<div class="form-group one-group">
								<label>{{__('المدينة التابعة لها')}}<sup>*</sup></label>
								<select name="item_city" class="form-control @if($errors->has('item_city')) error-input @endif" required>
								<option selected disabled>-- {{__('اختر مدينة')}} --</option>
									@foreach ($cities as $city)
									<option value='{{ $city->id }}'>{{ $city->translate($lang)->name }}</option>
									@endforeach
								</select>
								@if($errors->has('item_city')) 
								@if ($lang == 'en')
									<span class="invalid-feedback" role="alert">
										This field is required!
									</span>
								@else 
									<span class="invalid-feedback" role="alert">
										هذا الحقل مطلوب!
									</span>
								@endif
								@endif
							</div>
							<div class="clear"></div>
							<div class="form-group one-group">
								<div class="map-box">
									<label>{{__('الموقع على الخريطة')}}<span class="require">*</span></label>
									<input id="pac-input" class="controls" type="text" placeholder="{{__('ابحث')}} ..."/>
									<div  id="map"></div>
								</div>
								@if($errors->has('longitude')) 
								@if ($lang == 'en')
									<span class="invalid-feedback" role="alert">
										You should locate your location!
									</span>
								@else 
									<span class="invalid-feedback" role="alert">
										يجب تحديد الموقع على الخريطة!
									</span>
								@endif
								@endif
							</div>
							<div class="clear"></div>
							<input type="hidden" name="longitude">
							<input type="hidden" name="latitude">
							<div class="form-group one-group">
								<label>{{__('صور المكان')}}<sup>*</sup></label>
								<input type="file" name="img[]" accept="image/*" class="form-control @if($errors->has('img')) error-input @endif" multiple required>	
								@if($errors->has('img')) 
								@if ($lang == 'en')
									<span class="invalid-feedback" role="alert">
										This field is required!
									</span>
								@else 
									<span class="invalid-feedback" role="alert">
										هذا الحقل مطلوب!
									</span>
								@endif
								@endif
							</div>
							<div class="clear"></div>
							<div class="form-group one-group">
								<label>{{__('تصنيف المكان')}}<sup>*</sup></label>
								<ul class="radio-choices place-section-btns">
									@foreach ($categories as $category)
									<li>
										<input type="checkbox" value="{{ $category->id }}" name="category[]">
										<span>
											{{ $category->translate($lang)->name }}
										</span>
									</li>
									@endforeach
									@if(count($categories) == 1)
									<li>
										<input type="checkbox" value="{{ $categories[0]->id }}" checked disabled name="category[]">
										<span>
											{{ $categories[0]->translate($lang)->name }}
										</span>
									</li>
									@endif
								</ul>
								@if($errors->has('category')) 
								@if ($lang == 'en')
									<span class="invalid-feedback" role="alert">
										This field is required!
									</span>
								@else 
									<span class="invalid-feedback" role="alert">
										هذا الحقل مطلوب!
									</span>
								@endif
								@endif
							</div>
							<div class="clear"></div>
							<div class="form-group one-group link-place-reserve">
								<label>{{__('رابط المكان')}}</label>
								<input type="text" name="link" class="form-control">
							</div>
							<div class="clear"></div>
							<div class="form-group food-menu">
								<label>  {{__('قائمة الطعام (اللغة العربية)')}}</label>
								<textarea name="food_menu_ar" class="form-control"></textarea>
							</div>
							<div class="form-group food-menu">
								<label> {{__('قائمة الطعام (اللغة الانكليزية)')}}</label>
								<textarea name="food_menu_en" class="form-control"></textarea>
							</div>
							<div class="clear"></div>
							<div class="form-group">
								<label>{{__('كود العميل')}}</label>
								<input type="text" name="user_code" class="form-control">
							</div>
							<button class="tg-btn"><span>{{__('اضافة')}}</span></button>
						</fieldset>
					</div>
				</form>
				@endif
			</div>
		</div>
	</div>
</div>

@include('vendor.layouts.endsidemenu')

<?php
	if ($lang == "en")
		$search_txt = "Search or click to locate";
	else 
		$search_txt = "ابحث أو انقر لتحديد مكان";
?>

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
        content: "<?php echo $search_txt; ?>",
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
        $('input[name="longitude"]').val(place_lng);
        $('input[name="latitude"]').val(place_lat);
        });

    }      
</script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>	
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAufMZJuYiLNoAm2-nO7wP_E-sfk5AlGPo&callback=initAutocomplete&libraries=places&v=weekly&channel=2" async></script>

@include('front_views.layouts.footer')
