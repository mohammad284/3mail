


@include('dashboard.layouts.header')

<div class="page-wrapper">
	<div class="container">
		<div class="row">

			<div class="col-12">
				<h2 class="main-title">
					تعديل بيانات المكان
				</h2>
			</div>
		
			 <form class="form-group col-12" method="POST" enctype="multipart/form-data" action="{{ url('admin/item/update/'.$item->id) }}"> 
				@csrf

				<div class="group two">
                    <label> اسم المكان (اللغة العربية)<span class="require">*</span></label>
                    <input type="text" name="item_title_ar" value="{{ $item->translate('ar')->name }}" required>
                    @if ($errors->has('item_title_ar'))
                    <span class="text-danger">{{ $errors->first('item_title_ar') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label>اسم المكان (اللغة الانكليزية) <span class="require">*</span></label>
                    <input type="text" name="item_title_en" value="{{ $item->translate('en')->name }}" required>
                    @if ($errors->has('item_title_en'))
                    <span class="text-danger">{{ $errors->first('item_title_en') }}</span>
                    @endif
                </div>
                <div class="clear"></div>
				<div class="group two">
					<label>وصف المكان (باللغة العربية): <span class="require">*</span></label>
					<textarea name="item_desc_ar" required>{{ $item->translate('ar')->description }}</textarea>
					@if ($errors->has('item_desc_ar'))
						<span class="text-danger">{{ $errors->first('item_desc_ar') }}</span>
					@endif
				</div>
				<div class="group two">
					<label>وصف المكان (باللغة الانكليزية): <span class="require">*</span></label>
					<textarea name="item_desc_en" required>{{ $item->translate('en')->description }}</textarea>
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
							@foreach ($item_categories as $item_cat)
							@if ($category->id == $item_cat->category_id)
							<input type="checkbox" value="{{ $category->id }}" checked name="category[]">
							@endif
							@endforeach 
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
						@if ($errors->has('category'))
							<span class="text-danger">{{ $errors->first('category') }}</span>
						@endif
						@if ($errors->has('category.*'))
							<span class="text-danger">{{ $errors->first('category.*') }}</span>
						@endif
					</ul>
				</div>
				<div class="group two">
					<label>عنوان المكان (باللغة العربية): <span class="require">*</span></label>
					<input type="text" name="item_address_ar" value="{{ $item->translate('ar')->address }}" required>
					@if ($errors->has('item_address_ar'))
						<span class="text-danger">{{ $errors->first('item_address_ar') }}</span>
					@endif
				</div>
				<div class="group two">
					<label>عنوان المكان (باللغة الانكليزية): <span class="require">*</span></label>
					<input type="text" name="item_address_en" value="{{ $item->translate('en')->address }}" required>
					@if ($errors->has('item_address_en'))
						<span class="text-danger">{{ $errors->first('item_address_en') }}</span>
					@endif
                </div>
				<div class="group two">
					<label>المدينة التابع لها: <span class="require">*</span></label>
					<select name="item_city" required>
						@foreach ($cities as $city)
						<option value='{{ $city->id }}'@if($city->id == $item->city_id) selected @endif> {{ $city->translate('ar')->name }}</option>
						@endforeach
					</select>
					@if ($errors->has('item_city'))
						<span class="text-danger">{{ $errors->first('item_city') }}</span>
					@endif
				</div>
				<div class="group two">
					<label>رابط المكان:</label>
					<input type="tel" name="link" value="{{ $item->link }}">
					@if ($errors->has('link'))
						<span class="text-danger">{{ $errors->first('link') }}</span>
					@endif
				</div>
				<div class="clear"></div>
				<div class="group two">
					<label>رقم الهاتف: <span class="require">*</span></label>
					<input type="tel" name="item_phone" value="{{ $item->phone_number }}" required>
					@if ($errors->has('item_phone'))
						<span class="text-danger">{{ $errors->first('item_phone') }}</span>
					@endif
				</div>

				<div class="group two">
					<label>رقم واتس اب: <span class="require"></span></label>
					<input type="tel" name="whatsapp_phone" value="{{ $item->whatsapp_phone }}">
					@if ($errors->has('whatsapp_phone'))
						<span class="text-danger">{{ $errors->first('whatsapp_phone') }}</span>
					@endif
				</div>
				<div class="clear"></div>
		     	<div class="group">
					<label>صور المكان: </label>
					<div class="row">
						@foreach ($item->images as $img)
							<div class="col-md-4 col-sm-6 col-12">
								<div class="guide-block">
									<img src="{{ asset ($img->img) }}" class="img-fluid">
									<ul>
										<li>
											<button type="button" class="delete-btn" data-toggle="modal" data-target="{{'#exampleModal'.$img->id }}">
												<i class="fas fa-trash-alt"></i>
											</button>
										</li>
									</ul>
								</div>
							</div>
						@endforeach
					</div>
					<label>إضافة صور جديدة: </label>
					<input type="file" name="img[]" accept="image/*" multiple id="item_image">
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
					<label>نوع تصوير الكود </label>
					<select name="imaging_type" required>
						<option selected disabled>-- اختر نوع التصوير --</option>
						<option value='user' @if($item->imaging_type == 'user') selected @endif>تصوير كود الزبون</option>
						<option value='Casher' @if($item->imaging_type == 'Casher') selected @endif>التصوير عند الكاشير</option>
					</select>
					@if ($errors->has('imaging_type'))
						<span class="text-danger">{{ $errors->first('imaging_type') }}</span>
					@endif
				</div>
				<div class="group two">
                    <label> قائمة الطعام (اللغة العربية) </label>
                    <textarea name="food_menu_ar">{{ $item->translate('ar')->food_menu}}</textarea>
                </div>
				<div class="group two">
                    <label> قائمة الطعام (اللغة الانكليزية)  </label>
                    <textarea name="food_menu_en">{{ $item->translate('en')->food_menu}}</textarea>
                </div>
				<div class="clear"></div>

				<hr>
                <h5>بيانات الـ SEO: </h5>
                <div class="group two">
                    <label>Meta Title (اللغة العربية)</label>
                    <input type="text" name="meta_title_ar" value="{{ $item->translate('ar')->meta_title }}">
                </div>
                <div class="group two">
                    <label>Meta Title (اللغة الانكليزية)</label>
                    <input type="text" name="meta_title_en" value="{{ $item->translate('en')->meta_title }}">
                </div>
                
                <div class="group two">
                    <label>Meta keywards (اللغة العربية)</label>
                    <input type="text" name="meta_keywards_ar" value="{{ $item->translate('ar')->meta_keywards }}">
                </div>
                <div class="group two">
                    <label>Meta keywards (اللغة الانكليزية)</label>
                    <input type="text" name="meta_keywards_en" value="{{ $item->translate('en')->meta_keywards}}">
                </div>

                <div class="group two">
                    <label>Meta Discription  (اللغة العربية)</label>
                    <input type="text" name="meta_Discription_ar" value="{{$item->translate('ar')->meta_Discription}}">
                </div>
                <div class="group two">
                    <label>Meta Discription (اللغة الانكليزية)</label>
                    <input type="text" name="meta_Discription_en" value="{{ $item->translate('en')->meta_Discription}}">
                </div>
				<div class="clear"></div>

				<input type="hidden" name="longitude" value="{{ $item->longitude}}" required>
				<input type="hidden" name="latitude" value="{{ $item->latitude}}" required>

				<div class="group">
					<button type="submit">حفظ</button>
				</div>
			</form>


		</div>
	</div>
</div>
<script>
	var place_temp, place_lat, place_lng, markers = [];

	function initAutocomplete() {
		const myLatlng = { lat: {{ $item->latitude}}, lng:{{ $item->longitude}}};
		const map = new google.maps.Map(document.getElementById("map"), {
		zoom: 16,
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
		});
		map.fitBounds(bounds);
		});

		// Create the initial InfoWindow.
		let infoWindow = new google.maps.InfoWindow({
		content: "ابحث أو انقر لتغير مكان",
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
		console.log(place_lat,place_lng);
		$('input[name="longitude"]').val(place_lng);
			$('input[name="latitude"]').val(place_lat);
		});

	}      
</script>
@foreach ($item->images as $img)
<!-- Delete Modal -->
<div class="modal fade" id="{{'exampleModal'.$img->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">حذف صورة مكان</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{url('admin/item/img/delete/'.$img->id)}}">
				@csrf
					@method('DELETE')
					<p>هل أنت متأكد من الحذف</p>
					<button type="submit">نعم</button>
					<button type="button" data-dismiss="modal" aria-label="Close">
						لا
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- ./Delete Modal -->
@endforeach

<!-- Message -->
@if(session()->has('message'))
<p class="message-box done">
	{{ session()->get('message') }}
</p>
@endif
<!-- ./Message -->
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
		
		<script
		  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAufMZJuYiLNoAm2-nO7wP_E-sfk5AlGPo&callback=initAutocomplete&libraries=places&v=weekly&channel=2"
		  async
		></script>
@include('dashboard.layouts.footer')		