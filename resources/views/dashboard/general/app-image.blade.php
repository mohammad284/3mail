@include('dashboard.layouts.header')

<div class="page-wrapper">
    <div class="container">
        <div class="row">

            <form class="form-group col-12" method="POST" enctype="multipart/form-data" action="{{ route('admin.appImage.store') }}">

                @csrf
                <div class="group">
                    <label> تعديل صورة المفضلة في التطبيق<span class="require"></span></label>
                    <input type="file" name="app_image" required></input>
                    @if ($errors->has('app_image'))
                    <span class="text-danger">{{ $errors->first('app_image') }}</span>
                    @endif
                </div>
                <div>
                    <label for="exampleInputFile"> عرض الصورة الحالية</label>
                    <div class="input-group">
                        <img src="{{ asset($img->image) }}" class="img-fluid small-img"
                            id="image_preview_container">
                    </div>
                </div>

                <div class="group">
                    <button type="submit">تعديل</button>
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

