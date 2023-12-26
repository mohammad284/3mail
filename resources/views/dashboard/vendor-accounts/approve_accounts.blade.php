@include('dashboard.layouts.header')

<div class="page-wrapper">
  <div class="container">
    <div class="row">

      <div class="col-12">
        <h2 class="main-title">
            الحسابات المفعلة:
        </h2>

        @if(count($users) == 0)
				<div class="alert alert-info col-12" role="alert">
					لا يوجد حسابات حالياً لعرضها!
				</div>
        @else

        <div class="table-responsive">
          <table class="table table-striped custom-table">
            <thead>
                
              <tr>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الدولة</th>
                <th>رقم الهاتف</th>
                <th>تجميد الحساب</th>
                <th>تفاصيل الحساب</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->country}}</td>
                  <td style="direction: ltr">{{$user->phone_number}}</td>
                  <td>
                    <a class ="btn btn-warning" href ="/admin/cancel/{{$user->id}}" >تجميد</a>
                  </td>
                  <td>
                    <a class ="btn btn-info" href ="/admin/showUser/{{$user->id}}">عرض</a>
                  </td>
                </tr>
            @endforeach
            </tbody>
          </table>
        </div>    

        <div class="col-12">
					{{ $users->links() }}
				</div>

        @endif

      </div>

    </div>
  </div>
</div>

@include('dashboard.layouts.footer')