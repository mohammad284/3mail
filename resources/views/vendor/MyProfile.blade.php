<?php
	$lang = Session('locale');
	$title = __('تعديل الحساب');
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
				<h3>{{__('تعديل الحساب')}}</h3>
			</div>

			<div class="tg-dashboardcontent">
				<form class="tg-formtheme tg-formdashboard" method="post" enctype="multipart/form-data" action="{{ route('vendor.updateprofile') }}">
				@csrf
					<div class="img-change">
						<label>{{__('تغيير الصورة')}}</label>
						<img src="{{ asset(Auth::user()->image) }}" alt="image description">
						<input type="file" name="image" class="form-control">
					</div>
					<fieldset>
						<div class="form-group">
							<label>{{__('الاسم الكامل')}} <sup>*</sup></label>
							<input type="text" value="{{ Auth::user()->name }}" name="name" class="form-control @if($errors->has('name')) error-input @endif" required >
							@if($errors->has('name')) 
							@if ($lang == 'en')
								<span class="invalid-feedback" role="alert">
									This field is required!
								</span>
							@else 
								<span class="invalid-feedback" role="alert">
									هذا الحقل مطلوب!
								</span>
							@endif
							@endif
						</div>
						<div class="form-group">
							<label>{{__('رقم الهاتف')}} <sup>*</sup></label>
							<input type="tel" value="{{ Auth::user()->phone_number }}" name="phone_number" class="form-control @if($errors->has('phone_number')) error-input @endif" required>
							@if($errors->has('phone_number')) 
							@if ($lang == 'en')
								<span class="invalid-feedback" role="alert">
									This field is required!
								</span>
							@else 
								<span class="invalid-feedback" role="alert">
									هذا الحقل مطلوب!
								</span>
							@endif
							@endif
						</div>
						<div class="clear"></div>
						<div class="form-group">
							<label>{{__('بريدك الالكتروني')}} <sup>*</sup></label>
							<input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control @if($errors->has('email')) error-input @endif" required>
							@if($errors->has('email')) 
							@foreach ( $errors as $err)
							    {{$err}}
							@endforeach
							    @if ($errors->first('email') == "required")
							        @if ($lang == 'en')
    									<span class="invalid-feedback" role="alert">
    										This field is required!
    									</span>
    								@else 
    									<span class="invalid-feedback" role="alert">
    										هذا الحقل مطلوب!
    									</span>
    								@endif
							    @elseif ($errors->first('email') == "unique")
							        @if ($lang == 'en')
    									<span class="invalid-feedback" role="alert">
    										The previous entered email has been taken!
    									</span>
    								@else 
    									<span class="invalid-feedback" role="alert">
    									    البريد الإلكتروني المدخل مسبقاً محجوز!
    									</span>
    								@endif
							    @else
							        @if ($lang == 'en')
    									<span class="invalid-feedback" role="alert">
    										Invalid email!
    									</span>
    								@else 
    									<span class="invalid-feedback" role="alert">
    										البريد الإلكتروني غير صالح!
    									</span>
    								@endif
							    @endif
								
							@endif
						</div>
						<div class="form-group">
							<label>{{__('الدولة')}} <sup>*</sup></label>
							<input type="text" value="{{ Auth::user()->country }}" name="country" class="form-control @if($errors->has('country')) error-input @endif" required> 
							@if($errors->has('country')) 
							@if ($lang == 'en')
								<span class="invalid-feedback" role="alert">
									This field is required!
								</span>
							@else 
								<span class="invalid-feedback" role="alert">
									هذا الحقل مطلوب!
								</span>
							@endif
							@endif
						</div>
						<div class="clear"></div>
						<div class="form-group">
							<label>{{__('تاريخ الميلاد')}} <sup>*</sup></label>
							<input type="text" value="{{ Auth::user()->birthday }}" name="birthday" placeholder="YYYY-MM-DD" class="form-control @if($errors->has('birthday')) error-input @endif" required>
							@if($errors->has('birthday')) 
							@if ($lang == 'en')
								<span class="invalid-feedback" role="alert">
									This field is required!
								</span>
							@else 
								<span class="invalid-feedback" role="alert">
									هذا الحقل مطلوب!
								</span>
							@endif
							@endif
						</div>
						<div class="form-group">
							<label>{{__('الجنس')}} <sup>*</sup></label>
							<input type="text" value="{{ Auth::user()->gender }}" name="gender" class="form-control @if($errors->has('gender')) error-input @endif" required>
							@if($errors->has('gender')) 
							@if ($lang == 'en')
								<span class="invalid-feedback" role="alert">
									This field is required!
								</span>
							@else 
								<span class="invalid-feedback" role="alert">
									هذا الحقل مطلوب!
								</span>
							@endif
							@endif
						</div>
						
						<div class="form-group">
							<label>{{__('كلمة السر')}}</label>
							<input type="password" value="" name="password" class="form-control @if($errors->has('password')) error-input @endif">
							@if($errors->has('password')) 
							@if ($lang == 'en')
								<span class="invalid-feedback" role="alert">
									Password does not match!
								</span>
							@else 
								<span class="invalid-feedback" role="alert">
									كلمة المرور غير متطابقة!
								</span>
							@endif
							@endif
						</div>
						<div class="form-group">
							<label>{{__('تأكيد كلمة السر')}}</label>
							<input type="password" value="" name="password_confirmation" class="form-control @if($errors->has('password')) error-input @endif">
							@if($errors->has('password')) 
							@if ($lang == 'en')
								<span class="invalid-feedback" role="alert">
									Password does not match!
								</span>
							@else 
								<span class="invalid-feedback" role="alert">
									كلمة المرور غير متطابقة!
								</span>
							@endif
							@endif
						</div>
						<div class="clear"></div>
						<input  type="hidden" value="{{ Auth::user()->	user_type }}" value="{{ Auth::user()->user_type }}" name="user_type" class="form-control">
						<button class="tg-btn"  type="submit"><span>{{__('تحديث الملف')}}</span></button>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>

@if(session()->has('message'))
<div class="popup-box open">
    <div class="popup-body">
        @if ($lang == "en")
            <p>Profile has been updated successfully!</p>
        @else
            <p>تم تعديل معلومات الحساب الشخصي بنجاح!</p>
        @endif
        <button type="button" data-value="close">
			{{__('موافق')}}
		</button>
    </div>
</div>
@endif

@include('vendor.layouts.endsidemenu')
@include('front_views.layouts.footer')