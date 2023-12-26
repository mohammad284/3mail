<?php
	$lang = Session('locale');
	$title = __('تعديل معالمي');
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
				<h3> {{__('اختر مكان للتعديل')}}</h3>
			</div>
			<div class="tg-dashboardcontent">
				@if (count($items) == 0)
				<div class="alert alert-info">
					{{__('لا يوجد لديك معالم')}}
				</div>
				@else
				<div class="row">
					@foreach ($items as $item)
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="item-dashboard">
						    <button type="button" class="delete-btn" data-type="popup" data-popup="{{ $item->id }}">
										<i class="fas fa-trash-alt"></i>
									</button>
							<a href="/dashboard/editeplace/{{$item->id}}">
								@foreach ( $item->images as $img )
									<img class="city-item__img" src="{{ asset($img->img) }}" alt="" />
									@break;
								@endforeach
								<div class="item-name">
									<span> {{ $item->translate($lang)->name }}</span>
								</div>
							</a>
						</div>
					</div>
					@endforeach
					
					<div class="col-xs-12">
						{{ $items->links() }}
					</div>
			
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
@include('vendor.layouts.endsidemenu')


@foreach ($items as $item)
<!-- Delete Modal -->
<div class="popup-box" data-popup="{{$item->id}}">
	<div class="popup-body">
		<form method="POST" action="/dashbooard/deleteItem/{{$item->id}}">
			@csrf
			@method('DELETE')
			<p>{{ __('هل أنت متأكد من الحذف؟') }}</p>
			<button type="submit">{{__('نعم')}}</button>
			<button type="button" data-value="close">
				{{__('لا')}}
			</button>
		</form>
	</div>
</div>
<!-- ./Delete Modal -->
@endforeach

@include('front_views.layouts.footer')
