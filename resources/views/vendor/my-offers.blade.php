<?php
  $lang = Session('locale');
  $title = __('عروضي');
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
					<h3>{{__('عروضي')}}</h3>
				</div>

				<div class="tg-dashboardcontent">
					<div class="table-responsive">
                        <table class="previous-reservation table">
                            <thead>
                                <tr>
                                    <th>{{__('اسم المكان')}}</th>
                                    <th>{{__('نص العرض')}}</th>
                                    <th>{{__('تاريخ انتهاء العرض')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($offers as $offer)
                                <tr>
                                    <td>
                                        <span>{{$offer_user['offers'] ->item_name}}</span>
                                    </td>
                                    <td>
                                        <span>{{$offer ->offers}}</span>
                                    </td>
                                    <td>
                                        <span>} {{$offer ->end_offer_date}}</span>
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
