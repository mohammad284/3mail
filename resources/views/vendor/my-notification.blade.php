<?php
$lang = Session('locale');
	$title = __('إشعاراتي');
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
				<h3>{{__('إشعاراتي')}}</h3>
			</div>

			<div class="tg-dashboardcontent">
                @if (count($notifications) == 0)
                <div class="alert alert-info">
                    {{ __('لا يوجد إشعارات لعرضها!')}}
                </div>
                @else
				<ul class="notifi-list">
                    @foreach($notifications as $notification)
                    <li>
                        @if ($lang == "en")
                            <p>{{$notification ->data_en}}</p>
                        @else
                            <p>{{$notification ->data}}</p>
                        @endif
                    
                    <span class="time-box">
                        <i class='bx bx-calendar'></i> {{$notification ->created_at->format('Y.m.d')}}
                    </span>
                    </li>
                    @endforeach
                </ul>
                @endif
                
                <div>
                    {{ $notifications->links() }}
                </div>
			</div>
		</div>
	</div>
</div>

@include('vendor.layouts.endsidemenu')
@include('front_views.layouts.footer')