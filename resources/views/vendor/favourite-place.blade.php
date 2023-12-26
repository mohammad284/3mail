<?php
	$lang = Session('locale');
  	$title = __('المفضلة');
  if ($lang != "en") {
      $lang = "ar";
  }
?>

@include('front_views.layouts.header')
@include('vendor.layouts.sidemenu')

    <div id="tg-content" class="tg-content">
		<div class="tg-dashboard">
			
			
			<div class="tg-box tg-changepassword favourite-page">
				<div class="tg-heading">
					<h3>   {{__('المفضلة')}}</h3>
				</div>
				<div class="tg-dashboardcontent">
					@if (count($fav) == 0)
					<div class="alert alert-info">
						{{__('لا يوجد لديك معالم')}}
					</div>
					@else
					<div class="row">
						@foreach ($fav as $item)
						
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="item resturant">
                          <div class="listing-card">
                            <div class="listing-card__box">
                              <div class="listing-card__media shine">
                                  @if ($user)
                                    @php
                                    $isFavourited = false;
                                    @endphp
                                    @if (in_array($item->id,$favourite))
                                      @php
                                      $isFavourited = true;
                                      @endphp
                                    @else
                                      @php
                                      $isFavourited = false;
                                      @endphp
                                    @endif
                                    <button id="deletefavourite{{$item->id}}" 
                                            onClick="deletefromFavourite({{$item->id}}, {{ Auth::user()->id }})" 
                                            name="addfavourite" 
                                            class="custom-favourite-btn done"
                                            style="{{ $isFavourited ? '' : 'display: none;' }}">
                                        <i class="fas fa-heart" ></i>
                                    </button>
                                    <!-- hide if favourited  ADD -->
                                    <button id="addfavourites{{$item->id}}" 
                                            onClick="addToFavourites({{$item->id}}, {{ Auth::user()->id }})" 
                                            name="deletefavourite" 
                                            class="custom-favourite-btn"
                                            style="{{ $isFavourited ? 'display: none;' : '' }}">
                                        <i class="fas fa-heart" ></i>
                                    </button>
                                    
                                    @endif
                                  <a href="/Place_Details/{{$item->id}}">
                                @foreach ( $item->images as $img )
                                <img src="{{ asset($img->img) }}" alt="{{ $item->translate($lang)->name }}" />
                                @break;
                                @endforeach
                              </a>
                              </div>
                              <div class="listing-card__body">
                                <div class="listing-card__title">
                                    <a href="/Place_Details/{{$item->id}}">{{ $item->translate($lang)->name }}</a></div>
                                
                                <div class="listing-card__location"><span class="icon-location-pin"></span><span>{{ $item->translate($lang)->address }}</span></div>
                                <div class="listing-card__phone"><span class="icon-call-in"></span></span>{{ $item->phone_number }}</span></div>
                              </div>
                            
                              <div class="listing-card__info">
                                <div class="listing-card__rating">
                                  <div class="rating-box">
                                    @if (($item->rating == 0) || ($item->rating == null))
                                    <span class="review-title">{{ __('لا يوجد تقييمات') }}</span>
                                    @else
                                    <div class="rating-box__icon">
                                      <i class="fas fa-star @if($item->rating > 0) active @endif" aria-hidden="true"></i>
                                      <i class="fa fa-star @if($item->rating > 1) active @endif" aria-hidden="true"></i>
                                      <i class="fa fa-star @if($item->rating > 2) active @endif" aria-hidden="true"></i>
                                      <i class="fa fa-star @if($item->rating > 3) active @endif" aria-hidden="true"></i>
                                      <i class="fa fa-star @if($item->rating > 4) active @endif" aria-hidden="true"></i>
                                    </div> 
                                    @endif
                                  </div>
                                </div>
                              </div>
            
                              </div>
                            </div>
                        </div>
                      </div>
						@endforeach
				
					</div>
					@endif
					
					</div>
				</div>
			</div>
		</div>
	</div>
        
@include('vendor.layouts.endsidemenu')

<script>
    function addToFavourites(itemid, userid) {
      var user_id = userid;
      var item_id = itemid;
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type: 'post',
          url: '/addToFavourite',
          data: {
              'user_id': user_id,
              'item_id': item_id,
          },
          success: function () {
              // hide add button
              $('#addfavourites' + item_id).hide();
              // show delete button
              $('#deletefavourite' + item_id).show();
          },
          error: function (XMLHttpRequest) {
              // handle error
          }
      });

    }
    function deletefromFavourite(itemid, userid) {
      var user_id = userid;
      var item_id = itemid;
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type: 'post',
          url: '/deletefromFavourite',
          data: {
              'user_id': user_id,
              'item_id': item_id,
          },
          success: function () {
              // hide delete button
              $('#deletefavourite' + item_id).hide();
              // show add button
              $('#addfavourites' + item_id).show();
              
          },
          error: function (XMLHttpRequest) {
              // handle error
          }
      });

    }
  </script> 
@include('front_views.layouts.footer')