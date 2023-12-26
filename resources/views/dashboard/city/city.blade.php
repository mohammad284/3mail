
@include('dashboard.layouts.header')

<div class="page-wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <h2 class="main-title">
                    المدن:
                    <a href="{{ url('admin/city/add') }}">
                        <i class="fas fa-plus"></i>
                        إضافة مدينة جديدة
                    </a>
                </h2>
            </div>

            @foreach ($cities as $city)
				<div class="col-md-4 col-sm-6 col-12">
					<div class="guide-block">					
						<img src="{{ asset($city->image) }}" class="img-fluid">
						<h3>{{ $city->translate('ar')->name }}</h3>
						<ul>
							<li>
								<a href="{{ url('admin/city/items/'.$city->id) }}" title="عرض المعالم التابعة للمدينة">
                                    <i class="far fa-eye"></i>
								</a> 
							</li>
							<li>
								<a href="{{ url('admin/city/edit/'.$city->id) }}">
									<i class="fas fa-pencil-alt"></i>
								</a> 
							</li>
							<li>
								<button data-toggle="modal" data-target="{{'#exampleModal'.$city->id }}">
									<i class="fas fa-trash-alt"></i>
								</button>
							</li>
						</ul>
					</div>
				</div>
				@endforeach

            <div class="col-12">
                {{ $cities->links() }}
            </div>

        </div>
    </div>
</div>

@foreach ($cities as $city)
<!-- Delete Modal -->
<div class="modal fade" id="{{'exampleModal'.$city->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">حذف تصنيف</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{url('admin/city/delete/'.$city->id)}}">
                    @csrf
                    @method('DELETE')
                    <p>هل أنت متأكد من الحذف</p>
                    <div class="alert alert-danger">سيتم حذف جميع المعالم التابعة للمدينة</div>
                    <button type="submit">نعم</button>
                    <button type="button" data-dismiss="modal" aria-label="Close">
                        لا
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ./Delete Modal -->
@endforeach

<!-- Message -->
@if(session()->has('message'))
<p class="message-box done">
    {{ session()->get('message') }}
</p>
@endif
<!-- ./Message -->
        
@include('dashboard.layouts.footer')		