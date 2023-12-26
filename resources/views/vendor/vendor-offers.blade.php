<?php
	$lang = Session('locale');
	$title = __('العروض المرسلة');
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
				<h3>{{__('العروض المرسلة')}}</h3>
			</div>

		    <div class="tg-dashboardcontent">
			    <div class="table-responsive">
                    <table class="previous-reservation table">
                        <thead>
                            <tr>
                                <th>{{__('اسم المكان')}}</th>
                                <th>{{__('اسم الشخص')}}</th>
                                <th>{{__('نص العرض')}}</th>
                                <th>{{__('تاريخ بداية العرض')}}</th>
                                <th>{{__('تاريخ نهاية العرض')}}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($offer_item as $offer)
                            <tr>
                                <td>{{$offer['item'] ->name }}</td>
                                <td>{{$offer['user'] ->name }}</td>
                                <td>{{$offer['offer'] ->offers }}</td>
                                <td>{{$offer['start']}}</td>
                                <td>{{$offer['end']}}</td>
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




