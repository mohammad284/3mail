@include('dashboard.layouts.header')

<div class="page-wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <h2 class="main-title">
                    إضافة جملة جديدة:
                </h2>
            </div>
                    <form class="form-group col-12" method="POST" enctype="multipart/form-data" action="{{ route('admin.animatedTicker.store') }}">

                @csrf
                <div class="group two">
                    <label>   الجملة (اللغة العربية)  <span class="require">*</span></label>
                    <input type="text" name="title_ar" required>
                    @if ($errors->has('title_ar'))
                    <span class="text-danger">{{ $errors->first('title_ar') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label>  الجملة (اللغة الانكليزية)  <span class="require">*</span></label>
                    <input type="text" name="title_en" required>
                    @if ($errors->has('title_en'))
                    <span class="text-danger">{{ $errors->first('title_en') }}</span>
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

