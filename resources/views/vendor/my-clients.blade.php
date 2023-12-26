<?php
	$lang = Session('locale');
	$title = __('إرسال عرض');
  if ($lang != "en") {
      $lang = "ar";
  }
?>
@include('front_views.layouts.header')
@include('vendor.layouts.sidemenu')

<div id="tg-content" class="tg-content">
	<div class="tg-dashboard">
		<div class="tg-box tg-profile">
			<div class="tg-heading">
				<h3>{{__('إرسال عرض')}}</h3>
			</div>
			<div class="tg-dashboardcontent">
				
				<div class="tab-custom offers-tabs">
				    
				    <ul class="uk-tab" data-uk-tab="{connect:'#my-id'}">
                        <li><a href="">{{__('جديد')}}</a></li>
                        <li><a href="">{{__('فضي')}}</a></li>
                        <li><a href="">{{__('ذهبي')}}</a></li>
                        <li><a href="">{{__('ألماسي')}}</a></li>
                     </ul>
                     <ul id="my-id" class="uk-switcher uk-margin">
                        <li>
							<table class="table table-bordered">
									<thead>
									<tr>
										<th><input type="checkbox"> {{__('تحديد الكل')}}</th>
										<th>{{__('اسم العميل')}}</th>
										<th>{{__('عدد مرات الزيارة')}}</th>
										<th>{{__('إرسال عرض')}}</th>
									</tr>
									</thead>
									<tbody>
									@foreach($users as $user)
										@if($user['user_review']->client_status == 'new')
										<tr>
											<td><input type="checkbox" data-client="{{ $user['user_review']->user_id }}"></td>
											<td>{{$user['user_name'] ->name }}</td>
											<td>{{$user['user_review'] -> count}}</td>
											<td><button class="send-offer-btn" type="button" data-type="popup" data-popup="{{$user['user_review']->id}}">{{__('إرسال')}}</button></td>
										</tr>
										@endif
									@endforeach
									</tbody>
								</table>
                        </li>
                        <li>
							<table class="table table-bordered">
								<thead>
								<tr>
									<th><input type="checkbox"> {{__('تحديد الكل')}}</th>
									<th>{{__('اسم العميل')}}</th>
									<th>{{__('عدد مرات الزيارة')}}</th>
									<th>{{__('إرسال عرض')}}</th>
								</tr>
								</thead>
								<tbody>
								@foreach($users as $user)
									@if($user['user_review']->client_status == 'silver')
										<tr>
											<td><input type="checkbox"  data-client="{{ $user['user_review']->user_id }}"></td>
											<td>{{$user['user_name'] ->name }}</td>
											<td>{{$user['user_review'] -> count}}</td>
											<td><button class="send-offer-btn" type="button" data-type="popup" data-popup="{{$user->id}}">{{__('إرسال')}}</button></td>
										</tr>
										@endif
									@endforeach
								</tbody>
							</table>
                        </li>
                        <li>
							<table class="table table-bordered">
								<thead>
								<tr>
									<th><input type="checkbox"> {{__('تحديد الكل')}}</th>
									<th>{{__('اسم العميل')}}</th>
									<th>{{__('عدد مرات الزيارة')}}</th>
									<th>{{__('إرسال عرض')}}</th>
								</tr>
								</thead>
								<tbody>
								@foreach($users as $user)
									@if($user['user_review']->client_status == 'gold')
									<tr>
											<td><input type="checkbox"  data-client="{{ $user['user_review']->user_id }}"></td>
											<td>{{$user['user_name'] ->name }}</td>
											<td>{{$user['user_review'] -> count}}</td>
											<td><button class="send-offer-btn" type="button" data-type="popup" data-popup="{{$user->id}}">{{__('إرسال')}}</button></td>
									</tr>
									@endif
								@endforeach
								</tbody>
							</table>
                        </li>
                        <li>
							<table class="table table-bordered">
								<thead>
								<tr>
									<th><input type="checkbox"> {{__('تحديد الكل')}}</th>
									<th>{{__('اسم العميل')}}</th>
									<th>{{__('عدد مرات الزيارة')}}</th>
									<th>{{__('إرسال عرض')}}</th>
								</tr>
								</thead>
								<tbody>
								@foreach($users as $user)
								@if($user['user_review']->client_status == 'diamond')
										<tr>
												<td><input type="checkbox" data-client="{{ $user['user_review']->user_id }}"></td>
												<td>{{$user['user_name'] ->name }}</td>
												<td>{{$user['user_review'] -> count}}</td>
												<td><button class="send-offer-btn" type="button" data-type="popup" data-popup="{{$user->id}}">{{__('إرسال')}}</button></td>
										</tr>
										@endif
									@endforeach
								</tbody>
							</table>
                        </li>
                    </ul>

				</div>

				
				<button type="button" class="send-form send-group-invites" data-type="popup" data-popup="all_places" disabled>إرسال</button>
			
			</div>
		</div>
	</div>
</div>

@foreach ($users as $user)
<div class="popup-box reservation-popup" data-popup="{{$user['user_review']->id}}">
    <div class="popup-body">
    	<h4 class="popup-title">{{__('إرسال العرض')}}</h4>
    	
    	<form action="/dashboard/offer/{{$user['user_review']->user_id}}/{{$user['user_review']->item_id}}" method="post">
    		@csrf
			<div class="row">
				<div class="col-sm-6 col-xs-12">
				    <div class="form-row">
    					<label>{{__('تاريخ بداية العرض:')}}</label>
    					<input type="date" name="start_offer_date" required>
				    </div>
				</div>
				<div class="col-sm-6 col-xs-12">
				    <div class="form-row">
    					<label>{{__('تاريخ نهاية العرض:')}}</label>
    					<input type="date" name="end_offer_date" required>
    				</div>
				</div>
				<div class="col-xs-12">
				    <div class="form-row">
				        <label>{{__('نص العرض')}}</label>
					    <textarea name="offers" required></textarea>
					</div>
				</div>
			</div>
			<button trpe="submit" class="btn btn-default">{{__('إرسال')}}</button>
			<button type="button" data-value="close">{{__('إلغاء')}}</button>
    	</form>
        
    </div>

</div>
@endforeach
<!-- Model For Selected Users -->
<div class="popup-box" data-popup="all_places">
	<div class="popup-body">
		<h4 class="popup-title">{{__('إرسال العرض')}}</h4>
		<form action="/dashboard/multiOffers/{{$item_id}}" method="post">
			@csrf
			<div class="modal-body">
				<input type="hidden" name="client_id" class="selected-invites" val="">
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<label>{{__('تاريخ بداية العرض:')}}</label>
						<input type="date" name="start_offer_date" required>
					</div>
					<div class="col-sm-6 col-xs-12">
						<label>{{__('تاريخ نهاية العرض:')}}</label>
						<input type="date" name="end_offer_date" required>
					</div>
					<div class="col-xs-12">
						<textarea name="offers" placeholder="{{__('نص العرض')}} ..." required></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button trpe="submit" class="btn btn-default">{{__('إرسال')}}</button>
			</div>
		</form>
	</div>
</div>
<!-- ./Model For Selected Users -->
     
@include('vendor.layouts.endsidemenu')
@include('front_views.layouts.footer')
	