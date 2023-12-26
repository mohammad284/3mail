
<?php
  $title = __('حسابك معلق');
?>

@include('front_views.layouts.header')
@include('vendor.layouts.sidemenu')

<div id="tg-content" class="tg-content">
	<div class="tg-dashboard">
		<div class="tg-box tg-changepassword">
			<div class="tg-heading">
				<h3> {{__('حسابك معلق')}}</h3>
			</div>
			<div class="tg-dashboardcontent">
                <div class="alert alert-danger">
                    {{__('حسابك معلق يمكنك')}} <a href="/contact"> {{__('التواصل مع الإدارة')}} </a>
                </div> 
			</div>
		</div>
	</div>
</div>

@include('vendor.layouts.endsidemenu')
@include('front_views.layouts.footer')