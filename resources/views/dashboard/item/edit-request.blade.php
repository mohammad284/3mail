


@include('dashboard.layouts.header')

<div class="page-wrapper">
	<div class="container">
		<div class="row">

			<div class="col-12">
				<h2 class="main-title">
					تعديل رابط المكان
				</h2>
			</div>
		
			 <form class="form-group col-12" method="POST" enctype="multipart/form-data" action="{{ url('admin/item/updateRequest/'.$item->id) }}"> 
				@csrf

				
				<div class="group two">
                    <label>link <span class="require">*</span></label>
                    <input type="text" name="link" value="{{ $item->link}}" required>
                </div>
				<div class="group">
					<button type="submit">حفظ</button>
				</div>
			</form>


		</div>
	</div>
</div>

@foreach ($item->images as $img)
<!-- Delete Modal -->

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