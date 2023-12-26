@include('dashboard.layouts.header')

<div class="page-wrapper">
  <div class="container">
    <div class="row">

      <div class="col-12">
        <h2 class="main-title">
            أكواد العملاء:
        </h2>

        @if($count == 0)
				<div class="alert alert-info col-12" role="alert">
					لا يوجد اكواد للعملاء حاليا!
				</div>
        @else

        <div class="table-responsive">
          <table class="table table-striped custom-table">
            <thead>
                
              <tr>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الكود</th>
                <th>رقم الهاتف</th>
                <th> حذف الكود</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($code_details as $user)
                <tr>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->code}}</td>
                  <td style="direction: ltr">{{$user->phone_number}}</td>
                  <td>
                    <a class ="btn btn-warning" href ="/admin/delete/{{$user->id}}" >حذف</a>
                  </td>
                </tr>
            @endforeach
            </tbody>
          </table>
        </div>    



        @endif

      </div>

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