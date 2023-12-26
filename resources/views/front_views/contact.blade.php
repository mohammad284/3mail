<?php
  $lang = Session('locale');
  $title = __('تواصل معنا');
  if ($lang != "en") {
      $lang = "ar";
  }
?>
@include('front_views.layouts.header')
  @if(session()->has('message'))
    @if ($lang == 'en')
      <p class="message-box done">
        {{ "Message sent successfully" }}
      </p>
    @else 
      <p class="message-box done">
        {{ "تم إرسال الرسالة بنجاح" }}
      </p>
    @endif
  @endif
<main class="page-main">
      <div class="contact">
        
        <div class="uk-section uk-section-default">
          <div class="uk-container uk-container-small contact-body">
            <div class="contact-heading">
              <h3>{{__('تواصل معنا')}}</h3>
            </div>
            
            
            <div id="result"></div>
            
            <form id="myForm" method="post" action="{{ url ('/sendContact') }}">
                @csrf
              <div class="uk-margin">
                <label class="uk-form-label">{{__('الإسم')}} *</label>
                <input id="fullname" class="uk-input form-control @if($errors->has('name')) error-input @endif " type="text" name="name" required >
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
        
              <div class="uk-margin">
                <label class="uk-form-label">{{__('البريد الإلكتروني')}} *</label>
                <input id="email" class="uk-input form-control @if($errors->has('email')) error-input @endif " type="email" name="email" required>
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
              <div class="uk-margin">
                <label class="uk-form-label">{{__('رقم الهاتف')}} *</label>
                <input id="phone" class="uk-input form-control @if($errors->has('phone')) error-input @endif " type="text" name="phone" required>
                <span class="uk-text-danger"></span>
                @if($errors->has('phone')) 
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
              <div class="uk-margin">
                <label class="uk-form-label">{{__('الموضوع')}} *</label>
                <input id="subject" class="uk-input form-control @if($errors->has('subject')) error-input @endif " type="text" name="subject" required>
                <span class="uk-text-danger"></span>
                @if($errors->has('subject')) 
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
        
              <div class="uk-margin">
                <label class="uk-form-label">{{__('الرسالة')}}*</label>
                <textarea id="message" class="uk-textarea uk-height-small form-control @if($errors->has('message')) error-input @endif " name="message" required></textarea>
                <span class="uk-text-danger"></span>
                @if($errors->has('message')) 
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
        
             
              <button class="uk-button btn-contact" type="submit">{{__('ارسال')}}</button>
              
              </form>
            
          </div> <!-- /.uk-container -->
        </div> <!-- /.uk-section -->
        
      </div>
    </main>
    @include('front_views.layouts.footer')