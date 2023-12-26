
@include('dashboard.layouts.header')

<div class="page-wrapper">
  <div class="container">
    <div class="row">

      <div class="col-12">
          <h2 class="main-title">
              الشريط المتحرك:
              <a href="{{ url('admin/animatedTicker/add') }}">
                  <i class="fas fa-plus"></i>
                  إضافة جملة جديدة
              </a>  
          </h2>
          <ul class="animated-bar-list">
          @foreach ($animatedTickes as $animatedTicke)
            <li>
              <p>{{ $animatedTicke->title_ar }}</p>
              <a class ="btn-edit" href ="/admin/animatedTicker/edit/{{$animatedTicke->id}}">تعديل</a>
              <form method="POST" action="/admin/animatedTicker/delete/{{$animatedTicke->id}}">
              @method('DELETE')
              @csrf
              <button type="submit">حذف</button>
              </form>
            </li>
          @endforeach
          </ul>
      </div>

    </div>
  </div>
</div>

@include('dashboard.layouts.footer')