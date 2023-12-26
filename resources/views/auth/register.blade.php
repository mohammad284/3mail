<?php
	$lang = Session('locale');
	$title = __('انشاء حساب');
  if ($lang != "en") {
      $lang = "ar";
  }
?>

@include('front_views.layouts.header')

		<main id="tg-main" class="tg-main tg-sectionspace tg-haslayout">
			<div class="container">
				<div class="row">
					<div id="tg-twocolumns" class="tg-twocolumns">
						<form class="tg-formtheme tg-formdashboard" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
					    	@csrf	
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3">
								<div id="tg-content" class="tg-content">
									<div class="tg-dashboard">
										
										
										<div class="tg-box tg-changepassword login-account">
											<div class="tg-heading text-center">
												<h3>{{__('انشاء حساب')}}</h3>
											</div>
											<div class="tg-dashboardcontent">
												<div class="tg-content">
													<fieldset>
														<div class="form-group">
															<label>{{__('الإسم الكامل')}}<sup>*</sup></label>
															<input type="text" class="form-control form-control @if($errors->has('name')) error-input @endif" placeholder="" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            <span class="uk-text-danger"></span>
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
															<label>{{__('البريد الالكتروني')}}<sup>*</sup></label>
															<input type="email" name="email" class="form-control form-control @if($errors->has('email')) error-input @endif" placeholder="" value="{{ old('email') }}" required >
                            <span class="uk-text-danger"></span>
                            @if($errors->has('email')) 
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
															<label>{{__('رقم الهاتف')}}<sup>*</sup></label>
															<input type="text" name="phone_number" class="form-control form-control @if($errors->has('phone_number')) error-input @endif" value="{{ old('phone_number') }}" required >
                            <span class="uk-text-danger"></span>
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
																												<div class="form-group">
															<label>{{__('تاريخ الميلاد')}}<sup>*</sup></label>
															<input type="date" name="birthday" placeholder="YYYY-MM-DD" >
															@error('birthday')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
														<div class="form-group add-photo">
															<label>{{__('الجنس')}}<sup>*</sup></label>
															<ul class="user-vendor">
																<li>
																	<input type="radio" name="gender" value="ذكر" checked>
																	<label for="" class="place radio-inline">{{__('ذكر')}}</label>
																</li>
																<li>
																	<input type="radio" name="gender" value="انثى" >
																   <label for="" class="place radio-inline">{{__('انثى')}}</label>
															   </li>
															   
														   
															</ul>
															@error('gender')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
														<div class="form-group">
															<label>{{__('البلد')}}<sup>*</sup></label>
															<input type="text" name="country" class="form-control form-control @if($errors->has('country')) error-input @endif" placeholder="">
                            <span class="uk-text-danger"></span>
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
														<div class="form-group">
															<label>{{__('الصورة الشخصية')}}<sup>*</sup></label>
														
																<input type="file" name="img" class="form-control form-control @if($errors->has('img')) error-input @endif">
                            <span class="uk-text-danger"></span>
                            @if($errors->has('img')) 
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
															<label>{{__('كلمة المرور')}}<sup>*</sup></label>
															<input type="password" name="password" class="form-control form-control @if($errors->has('password')) error-input @endif" placeholder="">
                            <span class="uk-text-danger"></span>
                            @if($errors->has('password')) 
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
															<label>{{__('تأكيد كلمة المرور')}}<sup>*</sup></label>
															<input type="password" name="password_confirmation" class="form-control form-control @if($errors->has('password_confirmation')) error-input @endif" placeholder="">
                            @if($errors->has('password_confirmation')) 
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
														<div class="form-group add-photo">
															<label>{{__('نوع التسجيل')}}<sup>*</sup></label>
															<ul class="user-vendor">
																<li>
																	<input type="radio" name="user_type" value="vendor" checked>
																	<label for="" class="place radio-inline">{{__('مزود خدمة')}}</label>
																</li>
																<li>
																	<input type="radio" name="user_type" value="users" >
																   <label for="" class="place radio-inline">{{__('مستخدم')}}</label>
															   </li>
															   
														   
															</ul>
															@error('user_type')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
														
														</div>
														<button class="tg-btn"><span>{{__('أنشئ حسابك')}}</span></button>
														
													</fieldset>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
				</div>
				
			</div>
		</main>
@include('front_views.layouts.footer')

