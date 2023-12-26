@include('dashboard.layouts.header')

<div class="page-wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <h2 class="main-title">
                    تعديل السؤال:
                </h2>
            </div>
       
            <form class="form-group col-12" method="POST" enctype="multipart/form-data" action="{{ url('admin/question/update/'.$questions->id) }}">
                @csrf
                <div class="group two">
                    <label> السؤال (اللغة العربية) <span class="require">*</span></label>
                    <textarea name="question_ar"  required>{{$questions->translate('ar')->question }}</textarea>
                    @if ($errors->has('question_ar'))
                    <span class="text-danger">{{ $errors->first('question_ar') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label> الجواب (اللغة العربية) <span class="require">*</span></label>
                    <textarea name="answer_ar"  required>{{$questions->translate('ar')->answer }}</textarea>
                    @if ($errors->has('answer_ar'))
                    <span class="text-danger">{{ $errors->first('answer_ar') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label> السؤال (اللغة الإنجليزية) <span class="require">*</span></label>
                    <textarea name="question_en"  required>{{$questions->translate('en')->question }}</textarea>
                    @if ($errors->has('question_ar'))
                    <span class="text-danger">{{ $errors->first('question_ar') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label> الجواب (اللغة الإنجليزية) <span class="require">*</span></label>
                    <textarea name="answer_en"  required>{{$questions->translate('en')->answer }}</textarea>
                    @if ($errors->has('answer_ar'))
                    <span class="text-danger">{{ $errors->first('answer_ar') }}</span>
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