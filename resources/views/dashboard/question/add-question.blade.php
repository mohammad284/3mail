@include('dashboard.layouts.header')

<div class="page-wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <h2 class="main-title">
                    إضافة سؤال جديد:
                </h2>
            </div>
                    <form class="form-group col-12" method="POST" enctype="multipart/form-data" action="{{ route('admin.question.store') }}">

                @csrf
                <div class="group two">
                    <label>   السؤال (اللغة العربية )   <span class="require">*</span></label>
                    <textarea name="question_ar" required></textarea>
                    @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label>  الجواب (اللغة العربية)   <span class="require">*</span></label>
                    <textarea name="answer_ar" required></textarea>
                    @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label>   السؤال (اللغة الانكليزية)   <span class="require">*</span></label>
                    <textarea name="question_en" required></textarea>
                    @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label>  الجواب (اللغة الانكليزية)   <span class="require">*</span></label>
                    <textarea name="answer_en" required></textarea>
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

