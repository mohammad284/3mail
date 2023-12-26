@include('dashboard.layouts.header')

<div class="page-wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <h2 class="main-title">
                    تعديل بيانات التصنيف:
                </h2>
            </div>
       
         <form class="form-group col-12" method="POST" enctype="multipart/form-data" action="{{ url('admin/category/update/'.$category->id) }}">
                @csrf
                <div class="group two">
                    <label>اسم التصنيف (اللغة العربية) <span class="require">*</span></label>
                    <input type="text" name="category_title_ar" value="{{ $category->translate('ar')->name }}" required>
                    @if ($errors->has('category_title_ar'))
                    <span class="text-danger">{{ $errors->first('category_title_ar') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label>اسم التصنيف (اللغة الانكليزية) <span class="require">*</span></label>
                    <input type="text" name="category_title_en" value="{{ $category->translate('en')->name }}" required>
                    @if ($errors->has('category_title_en'))
                    <span class="text-danger">{{ $errors->first('category_title_en') }}</span>
                    @endif
                </div>
                <div class="clear"></div>
                <div class="group">
                    <label>صورة التصنيف:</label>
                    <input type="file" name="img" accept="image/*" id="image">
                    @if ($errors->has('img'))
                    <span class="text-danger">{{ $errors->first('img') }}</span>
                    @endif
                    <!-- <img src="{{ asset($category->img) }}" class="small-img"> -->
                </div>
                <div class="col-md-12 mb-2">
                    <div>
                        <label for="exampleInputFile">عرض الصورة</label>
                        <div class="input-group">
                            <img src="{{ asset($category->img) }}" class="img-fluid small-img"
                                id="image_preview_container">
                        </div>
                    </div>
                </div>

                <hr>
                <h5>بيانات الـ SEO: </h5>
                <div class="group two">
                    <label>Meta Title (باللغة العربية)</label>
                    <input type="text" name="meta_title_ar" value="{{ $category->translate('ar')->meta_title }}">
                </div>
                <div class="group two">
                    <label>Meta Title (باللغة الإنجليزية)</label>
                    <input type="text" name="meta_title_en" value="{{ $category->translate('en')->meta_title }}">
                </div>
                
                <div class="group two">
                    <label>Meta keywards (باللغة العربية)</label>
                    <input type="text" name="meta_keywards_ar" value="{{ $category->translate('ar')->meta_keywards }}">
                </div>
                <div class="group two">
                    <label>Meta keywards (باللغة الإنجليزية)</label>
                    <input type="text" name="meta_keywards_en" value="{{ $category->translate('en')->meta_keywards}}">
                </div>

                <div class="group two">
                    <label>Meta Discription (باللغة العربية)</label>
                    <input type="text" name="meta_Discription_ar" value="{{$category->translate('ar')->meta_Discription}}">
                </div>
                <div class="group two">
                    <label>Meta Discription (باللغة الإنجليزية)</label>
                    <input type="text" name="meta_Discription_en" value="{{ $category->translate('en')->meta_Discription}}">
                </div>
                <div class="clear"></div>
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