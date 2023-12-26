@include('dashboard.layouts.header')

<div class="page-wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <h2 class="main-title">
                   تعديل عبارة الشريط المتحرك:
                </h2>
            </div>
       
         <form class="form-group col-12" method="POST" enctype="multipart/form-data" action="{{ url('admin/animatedTicker/update/'.$animatedTicker->id) }}">
                @csrf
                <div class="group two">
                    <label> الجملة (اللغة العربية) <span class="require">*</span></label>
                    <input type="text" name="title_ar" value="{{$animatedTicker->title_ar}}" required>
                    @if ($errors->has('title_ar'))
                    <span class="text-danger">{{ $errors->first('title_ar') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label> الجملة (اللغة الإنجليزية) <span class="require">*</span></label>
                    <input type="text" name="title_en" value="{{$animatedTicker->title_en}}" required>
                    @if ($errors->has('title_en'))
                    <span class="text-danger">{{ $errors->first('title_en') }}</span>
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