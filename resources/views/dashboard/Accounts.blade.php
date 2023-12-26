@include('dashboard.layouts.header')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>  الحسابات المعلقة</h2>           
  <table class="table table-dark table-striped">
    <thead>
        
      <tr>
        <th>name</th>
        <th>Email</th>
        <th>Request</th>
        <th>Status</th>
        <th>Cancel</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
      @if(($user->vendor_request == 1) && ($user->cancel_account == 0))
      <tr>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->vendor_request}}</td>
        <td>
        <a class ="btn btn-warning" title="press to approve as vendor" href ="/admin/approve/{{$user->id}}" >موافق؟</a>
        </td>
        <td>
        <a class ="btn btn-warning" title="press to cancel  request" href ="/admin/cancel/{{$user->id}}" >تجميد</a>
        </td>
    </tr>
    @endif
      @endforeach
    </tbody>
  </table>
</div>

</body>
</html>

@include('dashboard.layouts.footer')