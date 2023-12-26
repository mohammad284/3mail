@include('dashboard.layouts.header')

<div class="page-wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <h2 class="main-title">
                    صفحة الشروط والأحكام:
                </h2>
            </div>
            <form class="form-group col-12" method="POST" enctype="multipart/form-data" action="{{ url('/admin/term/save') }}">

                @csrf
                <div class="group">
                    <label> محتوى الصفحة باللغة العربية <span class="require"></span></label>
                    <textarea name="term_ar" class="tinymce">{{ $term->translate('ar')->Terms_and_conditions }}</textarea>
                    @if ($errors->has('term_ar'))
                    <span class="text-danger">{{ $errors->first('term_ar') }}</span>
                    @endif
                </div>
                <div class="group">
                    <label>  محتوى الصفحة باللغة الإنكليزية  <span class="require"></span></label>
                    <textarea name="term_en" class="tinymce">{{ $term->translate('en')->Terms_and_conditions }}</textarea>
                    @if ($errors->has('term_en'))
                    <span class="text-danger">{{ $errors->first('term_en') }}</span>
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

