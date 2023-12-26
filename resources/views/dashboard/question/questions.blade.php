@include('dashboard.layouts.header')


<div class="page-wrapper">
  <div class="container">
    <div class="row">

      <div class="col-12">
          <h2 class="main-title">
              الأسئلة المتكررة:
              <a href="{{ url('admin/question/add') }}">
                  <i class="fas fa-plus"></i>
                  إضافة سؤال جديد
              </a>  
          </h2>
          <ul class="animated-bar-list">
          @foreach ($questions as $question)
            <li>
              <p>{{ $question->translate('ar')->question }}</p>
              <a class ="btn-edit" href ="/admin/question/edit/{{$question->id}}">تعديل</a>
              <form method="POST" action="/admin/question/delete/{{$question->id}}">
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