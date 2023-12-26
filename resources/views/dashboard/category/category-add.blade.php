@include('dashboard.layouts.header')

<div class="page-wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <h2 class="main-title">
                    إضافة تصنيف جديد:
                </h2>
            </div>
                    <form class="form-group col-12" method="POST" enctype="multipart/form-data" action="{{ route('admin.category.store') }}">

                @csrf
                <div class="group two">
                    <label> اسم التصنيف (اللغة العربية) <span class="require">*</span></label>
                    <input type="text" name="category_title_ar" required>
                    @if ($errors->has('category_title_ar'))
                    <span class="text-danger">{{ $errors->first('category_title_ar') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label>اسم التصنيف (اللغة الانكليزية) <span class="require">*</span></label>
                    <input type="text" name="category_title_en" required>
                    @if ($errors->has('category_title_en'))
                    <span class="text-danger">{{ $errors->first('category_title_en') }}</span>
                    @endif
                </div>
                <div class="clear"></div>
                <div class="group">

                    <label>صورة التصنيف: <span class="require">*</span></label>
                    <input type="file" name="img" accept="image/*" id="image" required>
                    @if ($errors->has('img'))
                    <span class="text-danger">{{ $errors->first('img') }}</span>
                    @endif
                </div>

                <hr>
                <h5>بيانات الـ SEO: </h5>
                <div class="group two">
                    <label>Meta Title (اللغة العربية)</label>
                    <input type="text" name="meta_title_ar">
                </div>            
                <div class="group two">
                    <label>Meta Title (اللغة الإنجليزية)</label>
                    <input type="text" name="meta_title_en">
                </div>
                
                <div class="group two">
                    <label>Meta keywards (اللغة العربية)</label>
                    <input type="text" name="meta_keywards_ar">
                </div>           
                 <div class="group two">
                    <label>Meta keywards (اللغة الإنجليزية)</label>
                    <input type="text" name="meta_keywards_en">
                </div>

                <div class="group two">
                    <label>Meta Discription (اللغة العربية)</label>
                    <input type="text" name="meta_Discription_ar">
                </div>            
                <div class="group two">
                    <label>Meta Discription (اللغة الإنجليزية)></label>
                    <input type="text" name="meta_Discription_en">
                </div>
                <div class="clear"></div>
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
