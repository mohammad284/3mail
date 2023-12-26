
<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <!-- Internet Explorer Meta -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- First Mobile Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>لوحة التحكم</title>
		<link rel="icon" href="{{ asset('images/logo.png') }}">
		<link rel="stylesheet" href="{{ asset('dashboard_res/css/bootstrap.min.css') }}"> <!-- Arabic Bootstrap -->
		<link rel="stylesheet" href="{{ asset('dashboard_res/css/all.css') }}">
		<link rel="stylesheet" href="{{ asset('dashboard_res/css/style.css') }}"> <!-- Arabic Style -->
        <!--[if lt IE 9]>
        <script src="{{ asset('dashboard_res/js/html5shiv.min.js') }}"></script>
       	<script src="{{ asset('dashboard_res/js/respond.min.js') }}"></script>
        <![endif]-->
	</head>
	<body>


		<!-- Header -->
		<header>
			<div class="menu">
				<img src="{{ asset('dashboard_res/images/logo.png') }}" class="img-fluid logo">
				<img src="{{ asset('dashboard_res/images/icon-white.png') }}" class="img-fluid logo-mobile">
				<button id="menu-btn">
					<span></span>
					<span></span>
					<span></span>
				</button>
				<nav class="navbar navbar-expand-lg">					
					<div class="collapse navbar-collapse show" id="navbarSupportedContent">
						<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="{{ url('/admin') }}">
								<i class="fas fa-tachometer-alt"></i>
								<span class="link">
									لوحة التحكم
								</span>
								<span class="sr-only">(current)</span>
							</a>
						</li>
						
						<li class="nav-item menu">
							<a class="nav-link">
								<i class="fas fa-cog"></i>
								<span class="link">
									إعدادات عامة 
								</span>
							</a>							
							<ul>
								<li>
									<a href="{{ url('admin/privacy') }}">
										<i class="fas fa-shield-alt"></i>
										<span class="link">
											سياسة الخصوصية
										</span>
									</a> 
								</li>
								<li>
									<a href="{{ url('admin/term') }}">
										<i class="fas fa-cogs"></i>
										<span class="link">
											الشروط والأحكام
										</span>
									</a> 
								</li>
								<li>
									<a href="{{ url('admin/about-app') }}">
										<i class="fas fa-mobile-alt"></i>
										<span class="link">
											نبذة عن التطبيق
										</span>
									</a> 
								</li>
								<li>
									<a href="{{ url('admin/appImage/add') }}">
										<i class="far fa-image"></i>
										<span class="link">
											صورة المفضلة في التطبيق
										</span>
									</a> 
								</li>
								<li>
									<a href="{{ url('/admin/animatedTicker') }}">
										<i class="fas fa-bars"></i>
										<span class="link">
											الشريط المتحرك	
										</span>
									</a> 
								</li>
								<li>
									<a href="{{ url('/admin/questions') }}">
										<i class="fas fa-question"></i>
										<span class="link">
										الاسئلة المتكررة
										</span>
									</a> 
								</li>
							</ul>
						</li>	
						<li class="nav-item menu">
							<a class="nav-link" href="{{ url('/admin/cities') }}">
								<i class="fas fa-city"></i>
								<span class="link">
									المدن
								</span>
							</a>
							<ul>
								<li>
									<a href="{{ url('/admin/city/add') }}">
										<i class="fas fa-plus"></i>
										<span class="link">
											إضافة مدينة جديدة
										</span>
									</a> 
								</li>
							</ul>
						</li>
						<li class="nav-item menu">
							<a class="nav-link" href="{{ url('/admin/categories') }}">
								<i class="fas fa-cubes"></i>
								<span class="link">
									التصنيفات
								</span>
							</a>
							<ul>
								<li>
									<a href="{{ url('/admin/category/add') }}">
										<i class="fas fa-plus"></i>
										<span class="link">
											إضافة تصنيف جديد
										</span>
									</a> 
								</li>
							</ul>
						</li>
						<li class="nav-item menu">
							<a class="nav-link" href="{{ url('/admin/items') }}">
								<i class="fas fa-map-marker-alt"></i>
								<span class="link">
									المعالم المفعلة
								</span>
							</a>
							<ul>
								<li>
									<a href="{{ url('/admin/item/add') }}">
										<i class="fas fa-plus"></i>
										<span class="link">
											إضافة مكان جديد
										</span>
									</a> 
								</li>
								<li>
									<a href="{{ url('/admin/item/requestitem') }}">
										<i class="fas fa-exclamation"></i>
										<span class="link">
											طلبات المعالم المعلقة
										</span>
									</a> 
								</li>
								<li>
									<a href="{{ url('/admin/item/updateItem') }}">
										<i class="fas fa-pencil-alt"></i>
										<span class="link">
											طلبات تعديل المعالم 
										</span>
									</a> 
								</li>
							</ul>
						</li>
						<li class="nav-item menu">
							<a class="nav-link">
								<i class="fas fa-store-alt"></i>
								<span class="link">
									حسابات مزودي الخدمات
								</span>
							</a>
							<ul>
								<li>
									<a href="{{ url('/admin/user_accounts') }}">
										<i class="fas fa-user-check"></i>
										<span class="link">
											الحسابات المفعلة 
										</span>
									</a>
								</li>
								<li>
									<a href="{{ url('/admin/request_accounts') }}">
										<i class="fas fa-user-times"></i>
										<span class="link">
											الحسابات المعلقة 
										</span>
									</a>
								</li>
								<li>
									<a href="{{ url('/admin/cancel_accounts') }}">
										<i class="fas fa-user-slash"></i>
										<span class="link">
											الحسابات المجمدة 
										</span>
									</a>
								</li>
							</ul>
						</li>	
						<li class="nav-item menu">
							<a class="nav-link" href="{{ url('/admin/items') }}">
								<i class="fas fa-map-marker-alt"></i>
								<span class="link">
								أكواد العملاء
								</span>
							</a>
							<ul>
								<li>
									<a href="{{ url('/admin/showAddCode') }}">
										<i class="fas fa-plus"></i>
										<span class="link">
											إضافة كود جديد
										</span>
									</a> 
								</li>
								<li>
									<a href="{{ url('/admin/userCodes') }}">
										<i class="fas fa-exclamation"></i>
										<span class="link">
											أكواد العملاء
										</span>
									</a> 
								</li>
							</ul>
						</li>		
						<li class="nav-item">
          					<a class="nav-link" href="{{ url('admin/allUsers') }}">
							  	<i class="fas fa-users"></i>
								<span class="link">
									حسابات المستخدمين
								</span>
							</a>
							<a class="nav-link" href="{{ url('admin/userLogin') }}">
							  	<i class="fas fa-users"></i>
								<span class="link">
									 تسجيلات الدخول 
								</span>
							</a>
							<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
          				</li>						
						<li class="nav-item">
          					<a class="nav-link" href="{{ route('admin.logout') }}"
								onclick="event.preventDefault();
												document.getElementById('logout-form').submit();">
								<i class="fas fa-power-off"></i>
								<span class="link">
									تسجيل خروج
								</span>
							</a>
							<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
          				</li>

					</div>
				</nav>
			</div>
		</header>
		<div class="overlay"></div>
		<!-- ./Header -->