@include('dashboard.layouts.header')

<div class="page-wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <h2 class="main-title">
                    إضافة كود عميل:
                </h2>
            </div>
                    <form class="form-group col-12" method="POST" enctype="multipart/form-data" action="/admin/addCode">

                @csrf
                <div class="group two">
                    <label>   الايميل  <span class="require">*</span></label>
                    <input type="email" name="email" required>
                    @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="group two">
                    <label>  الكود  <span class="require">*</span></label>
                    <input type="text" name="code" required>
                    @if ($errors->has('code'))
                    <span class="text-danger">{{ $errors->first('code') }}</span>
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

