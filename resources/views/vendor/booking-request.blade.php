<?php
  $title = __('طلبات الحجز');
?>

@include('front_views.layouts.header')
@include('vendor.layouts.sidemenu')

<div id="tg-content" class="tg-content">
	<div class="tg-dashboard">
		<div class="tg-box tg-changepassword">
			<div class="tg-heading">
				<h3> {{__('طلبات الحجز')}}</h3>
			</div>
			<div class="tg-dashboardcontent">
                <table class="reservation-order table">
                    <thead>
                        <tr>
                            <th>{{__('اسم العميل')}}</th>
                            <th>{{__('يوم الحجز')}}</th>
                            <th>{{__('عدد الأشخاص')}}</th>
                            <th>{{__('وقت الحجز')}}</th>
                            <th>{{__('خيارات')}}</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($user_reserve as $user_res )
                        <tr>
                            <td>
                                <span>{{$user_res['user'] -> name  }}</span>
                            </td>
                            <td>
                                <span> {{$user_res['reservation'] ->reservation_day}}</span>
                            </td>
                            <td>
                                <span>{{$user_res['reservation'] ->reservation_presons}}</span>
                            </td>
                            <td>
                                <span>{{$user_res['reservation'] ->reservation_time}}</span>
                            </td>
                            <td>
                                <a href="/dashboard/ReservationAccepted/{{$user_res['reservation']->id}}" class="approve-btn">{{__('موافقة')}}</a>
                                <a href="/dashboard/ReservationCancel/{{$user_res['reservation']->id}}" class="reject-btn">{{__('إلغاء')}}</a>
                                <button class="suggest-btn" data-type="popup"
                                data-popup="{{ $user_res['user'] -> id }}">{{__('اقتراح حجز')}}</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
			</div>
		</div>
	</div>
</div>

@include('vendor.layouts.endsidemenu')


    @foreach ($user_reserve as $user_res )
    <div class="popup-box reservation-popup" data-popup="{{ $user_res['user'] -> id }}">
    	<div class="popup-body">
    	    <h4>{{__('اقتراح حجز')}}</h4>
    		<form method="POST" action="{{ url('dashboard/suggestReservation/'.$user_res['user'] -> id) }}">
    			@csrf
			    <div class="form-row">
                    <label for="reservationDate">{{__('تاريخ الحجز')}}</label>
                    <input type="date" name="reservationDate">
			    </div>
			    <div class="form-row">
                    <label for="reservationTime">{{__('وقت الحجز')}}</label>
                    <input type="time" name="reservationTime">
			    </div>
			    <button type="submit">{{__('إرسال')}}</button>
			    <button type="button" data-value="close">{{__('إلغاء')}}</button>
    		</form>
    	</div>
    </div>
    @endforeach


@include('front_views.layouts.footer')
