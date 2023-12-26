@include('dashboard.layouts.header')

<div class="page-wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <h2 class="main-title">
                    إضافة جملة جديدة:
                </h2>
            </div>
            <form class="form-group col-12" method="POST" enctype="multipart/form-data" action="{{ route('admin.general.store') }}">

                @csrf
                <div class="group two">
                    <label>   الاحكام والشروط (اللغة العربية)  <span class="require"></span></label>
                    <textarea name="Terms_and_conditions_ar" required></textarea>
                    @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label>  الاحكام والشروط (اللغة الانكليزية)  <span class="require"></span></label>
                    <textarea name="Terms_and_conditions_en" required></textarea>
                    @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label>   سياسة الخصوصية (اللغة العربية)  <span class="require"></span></label>
                    <textarea name="privacy_policy_ar" required></textarea>
                    @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label>  سياسة الخصوصية (اللغة الانكليزية)  <span class="require"></span></label>
                    <textarea name="privacy_policy_en" required></textarea>
                    @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label>   نبذة عن التطبيق (اللغة العربية)  <span class="require"></span></label>
                    <textarea name="about_ar" required></textarea>
                    @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label>  نبذة عن التطبيق (اللغة الانكليزية)  <span class="require"></span></label>
                    <textarea name="about_en" required></textarea>
                    @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>


                <div class="group">
                    <button type="submit">إضافة</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Message -->
@if(session()->has('message'))
<p class="message-box done">
    {{ session()->get('message') }}
</p>
@endif
<!-- ./Message -->

@include('dashboard.layouts.footer')

