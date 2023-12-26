
@include('dashboard.layouts.header')

<div class="page-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-12">
				<div class="info-box">
					<i class="fas fa-map-marker-alt"></i>
					<p>
						<span>{{ $items_count }}</span>  
						معالم
					</p>
					<ul>
						<li>
							<a href="{{ url('/admin/items') }}">
								<i class="far fa-eye"></i>
								عرض الكل
							</a>
						</li>
						<li>
							<a href="{{ url('/admin/item/add') }}">
								<i class="fas fa-plus-circle"></i>
								إضافة مكان جديد							
							</a>
						</li>
					</ul>
				</div>
			</div>
			
			
			<div class="col-md-6 col-12">
				<div class="info-box">
					<i class="fas fa-city"></i>
					<p>
						<span>{{ $city_count }}</span>  
						مدينة
					</p>
					
					<ul>
						<li>
							<a href="{{ url('/admin/cities') }}">
								<i class="far fa-eye"></i>
								عرض الكل
							</a>
						</li>
						<li>
							<a href="{{ url('/admin/city/add') }}">
								<i class="fas fa-plus-circle"></i>
								إضافة مدينة جديدة							
							</a>
						</li>
					</ul>
					
				</div>
			</div>

			
			<div class="col-md-6 col-12">
				<div class="info-box">
					<i class="fas fa-cubes"></i>
					<p>
						<span>{{ $cat_count }}</span>  
						تصنيف
					</p>
					
					<ul>
						<li>
							<a href="{{ url('/admin/categories') }}">
								<i class="far fa-eye"></i>
								عرض الكل
							</a>
						</li>
						<li>
							<a href="{{ url('/admin/city/add') }}">
								<i class="fas fa-plus-circle"></i>
								إضافة تصنيف جديد							
							</a>
						</li>
					</ul>
					
				</div>
			</div>
			
			<div class="col-md-6 col-12">
				<div class="info-box">
					<i class="fas fa-user-cog"></i>
					<p>
						<span>{{ $vendor_count }}</span>  
						طلبات مزودي الخدمة
					</p>
					
					<ul>
						<li>
							<a href="{{ url('/admin/request_accounts') }}">
								<i class="far fa-eye"></i>
								عرض الكل
							</a>
						</li>
					</ul>
					
				</div>
			</div>

			<div class="col-md-6 col-12">
				<div class="info-box">
					<i class="fas fa-users"></i>
					<p>
						<span>{{ $user_count }}</span>  
						عدد المستخدمين
					</p>
					<ul>
						<li>
							<a href="{{ url('/admin/allUsers') }}">
								<i class="far fa-eye"></i>
								عرض الكل
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-md-6 col-12">
				<div class="info-box">
					<i class="fas fa-ban"></i>
					<p>
						<span>{{ $item_count }}</span>  
						طلبات المعالم المعلقة
					</p>
					
					<ul>
						<li>
							<a href="{{ url('/admin/item/requestitem') }}">
								<i class="far fa-eye"></i>
								عرض الكل
							</a>
						</li>

					</ul>
					
				</div>
			</div>
		</div>
	</div>
</div>
			
@include('dashboard.layouts.footer')		