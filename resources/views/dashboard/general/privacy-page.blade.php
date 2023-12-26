@include('dashboard.layouts.header')

<div class="page-wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <h2 class="main-title">
                    صفحة سياسة الخصوصية:
                </h2>
            </div>
            <form class="form-group col-12" method="POST" enctype="multipart/form-data" action="{{ url('/admin/privacy/save') }}">

                @csrf
                <div class="group">
                    <label> محتوى الصفحة باللغة العربية <span class="require"></span></label>
                    <textarea name="privacy_policy_ar" class="tinymce"></textarea>
                    @if ($errors->has('privacy_policy_ar'))
                    <span class="text-danger">{{ $errors->first('privacy_policy_ar') }}</span>
                    @endif
                </div>
                <div class="group">
                    <label>  محتوى الصفحة باللغة الإنكليزية  <span class="require"></span></label>
                    <textarea name="privacy_policy_en" class="tinymce"></textarea>
                    @if ($errors->has('privacy_policy_en'))
                    <span class="text-danger">{{ $errors->first('privacy_policy_en') }}</span>
                    @endif
                </div>

                <div class="group">
                    <button type="submit">حفظ</button>
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

