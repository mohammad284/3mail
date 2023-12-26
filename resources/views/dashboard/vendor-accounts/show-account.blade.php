@include('dashboard.layouts.header')

<div class="page-wrapper">
  <div class="container">
    <div class="row">

      <div class="col-12">
        <h2 class="main-title">
            تفاصيل الحساب:
        </h2>

        <form class="form-group col-12">
            <div class="group user-image-block">
                <img src="{{ asset($user->image) }}">
            </div>
            <div class="group two">
                <label>الاسم: </label>
                <span>{{ $user->name }}</span>
            </div>
            <div class="group two">
                <label>البريد الإلكتروني: </label>
                <span>{{ $user->email }}</span>
            </div>
            <div class="clear"></div>
            <div class="group two">
                <label>الدولة: </label>
                <span>{{ $user->country }}</span>
            </div>
            <div class="group two">
                <label>رقم الهاتف: </label>
                <span class="phone-number-block">{{ $user->phone_number }}</span>
            </div>
            <div class="clear"></div>
            <div class="group">
                <label>نوع الحساب: </label>
                @if (($user->vendor_request == 0) && ($user->type == 0))
                <span>حساب مستخدم عادي</span>
                @elseif (($user->vendor_request == 1) && ($user->type == 0))
                <span>حساب مزود خدمة بانتظار الموافقة</span>
                @elseif (($user->vendor_request == 0) && ($user->type == 1))
                <span>حساب مزود خدمة مفعل</span>
                @elseif (($user->cancel_account == 1) && ($user->type == 0))
                <span>حساب مزود خدمة مجمد</span>
                @endif
            </div>


        </form>

      </div>

    </div>
  </div>
</div>

@include('dashboard.layouts.footer')