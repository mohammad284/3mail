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
  <h2>معلومات  عامة</h2>   
        <a href="{{ url('admin/general/add') }}">
            <i class="fas fa-plus"></i>
            إضافة المعلومات
        </a>     
        <a href="{{ url('admin/appImage/add') }}">
            <i class="fas fa-plus"></i>
            إضافة صورة المفضلة
        </a>    
  <table class="table table-dark table-striped">
    <thead>
      <tr>
        <th>الجملة</th>
        <th>حذف</th>
        <th>تعديل</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($general as $general)
      <tr>
        <td>{{$general->title_ar}}</td>
        <td>
        <form method="POST" action="/admin/general/delete/{{$general->id}}">
        @method('DELETE')
        @csrf
        <button type="submit">حذف</button>
        </form>
        </td>
        <td>
        <a class ="btn btn-warning" title="press to cancel  request" href ="/admin/general/edit/{{$general->id}}" >تعديل</a>
        </td>
    </tr>
    @endforeach
    </tbody>
  </table>
</div>

</body>
</html>

@include('dashboard.layouts.footer')