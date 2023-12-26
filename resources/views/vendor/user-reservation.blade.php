
<?php
	$lang = Session('locale');
	$title = __('حجوزاتي');
  if ($lang != "en") {
      $lang = "ar";
  }
?>
@include('front_views.layouts.header')
@include('vendor.layouts.sidemenu')

<div id="tg-content" class="tg-content">
	<div class="tg-dashboard">
		<div class="tg-box tg-ediprofile">
			<div class="tg-heading">
				<h3>{{__('حجوزاتي')}}</h3>
			</div>

		    <div class="tg-dashboardcontent">
			    <div class="table-responsive">
                    <table class="previous-reservation table">
                        <thead>
                            <tr>
                                <th>{{__('اسم المكان')}}</th>
                                <th>{{__('يوم الحجز')}}</th>
                                <th>{{__('عدد الأشخاص')}}</th>
                                <th>{{__('وقت الحجز')}}</th>
                                <th>{{__('الحالة')}}</th>
                            </tr>
                        </thead>

                        <tbody>
                                @foreach ($user_reserve as $user_res )
                                <tr>
                                    <td>
                                        <span>{{$user_res['item']->translate('ar') -> name  }}</span>
                                    </td>
                                    <td>
                                        <span>{{$user_res['reservation'] ->reservation_day}}</span>
                                    </td>
                                    <td>
                                        <span>{{$user_res['reservation'] ->reservation_presons}}</span>
                                    </td>
                                    <td>
                                        <span>{{$user_res['reservation'] ->reservation_time}}</span>
                                    </td>
                                    <td>
                                        <span>
                                            @if($user_res['reservation']->status == 0  && $user_res['reservation']->cancel == 0)
                                            {{__('بإنتظار الموافقة')}}
                                            @endif
                                            @if($user_res['reservation']->status == 0  && $user_res['reservation']->cancel == 1)
                                            {{__('إلغاء الحجز')}}
                                            @endif
                                            @if($user_res['reservation']->status == 1  && $user_res['reservation']->cancel == 0)
                                            {{__(' تم الموافقة')}}
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
                
		    </div>
		</div>
	</div>
</div>

@include('vendor.layouts.endsidemenu')
@include('front_views.layouts.footer')

