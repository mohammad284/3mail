<footer id="tg-footer" class="tg-footer tg-haslayout">
			<div class="tg-fourcolumns">
				<div class="container">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
							<div class="tg-footercolumn tg-widget tg-widgettext">
								<div class="logo"><a class="logo__link" href="index.html"><img class="logo__img" src="{{ asset('dashboardUser_res/images/logo.png') }}" alt="Doremi"></a></div>
								<p>هذا النص هو مثال لنص يمكن أن <br> هذا النص هو مثال لنص يمكن أن <br> هذا النص هو مثال لنص يمكن أن </p>
							   
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
							<div class="tg-footercolumn tg-widget tg-widgetdestinations">
								<div class="tg-widgettitle">
									<h3>المدن</h3>
								</div>
								<div class="tg-widgetcontent">
									<ul>
									@foreach ($cities as $city)
												<li><a href="/city/{{$city->id}}">{{ $city->translate('ar')->name }}</a></li>
									@endforeach
									</ul>
								</div>
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
							<div class="tg-footercolumn tg-widget tg-widgetnewsletter">
								<div class="tg-widgettitle">
									<h3>{{__('تواصل معنا')}}</h3>
								</div>
								<div class="tg-widgetcontent">
									<ul class="uk-list">
										<li> <span>{{__('البريد الالكتروني')}} </span><a href="mailto:support@domain.com">support@domain.com</a></li>
										<li> <span>{{__('الهاتف')}} </span><a href="tel:104023513690">+1 (040) 2351 3690</a></li>
									  </ul>
									  <ul class="social">
										<li><a href="#!"><i class="fab fa-twitter"></i></a></li>
										<li><a href="#!"><i class="fab fa-facebook-f"></i></a></li>
										<li><a href="#!"><i class="fab fa-youtube"></i></a></li>
										<li><a href="#!"><i class="fab fa-instagram"></i></a></li>
									  </ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!--************************************
				Footer End
		*************************************-->
	</div>
	<!--************************************
			Wrapper End
	*************************************-->
	<!--************************************
			Search Start
	*************************************-->
	<div id="tg-search" class="tg-search">
		<button type="button" class="close"><i class="icon-cross"></i></button>
		<form>
			<fieldset>
				<div class="form-group">
					<input type="search" name="search" class="form-control" value="" placeholder="search here">
					<button type="submit" class="tg-btn"><span class="icon-search2"></span></button>
				</div>
			</fieldset>
		</form>
		<ul class="tg-destinations">
			<li>
				<a href="javascript:void(0);">
					<h3>Europe</h3>
					<em>(05)</em>
				</a>
			</li>
			<li>
				<a href="javascript:void(0);">
					<h3>Africa</h3>
					<em>(15)</em>
				</a>
			</li>
			<li>
				<a href="javascript:void(0);">
					<h3>Asia</h3>
					<em>(12)</em>
				</a>
			</li>
			<li>
				<a href="javascript:void(0);">
					<h3>Oceania</h3>
					<em>(02)</em>
				</a>
			</li>
			<li>
				<a href="javascript:void(0);">
					<h3>North America</h3>
					<em>(08)</em>
				</a>
			</li>
		</ul>
	</div>
	<!--************************************
			Search End
	*************************************-->
	<!--************************************
			Login Singup Start
	*************************************-->
	<div id="tg-loginsingup" class="tg-loginsingup" data-vide-bg="poster: images/singup-img.jpg" data-vide-options="position: 0% 50%">
		<div class="tg-contentarea tg-themescrollbar">
			<div class="tg-scrollbar">
				<button type="button" class="close">x</button>
				<div class="tg-logincontent">
					<nav id="tg-loginnav" class="tg-loginnav">
						<ul>
							<li><a href="#">About Us</a></li>
							<li><a href="#">Contact Us</a></li>
							<li><a href="#">My Account</a></li>
							<li><a href="#">My Wishlist</a></li>
						</ul>
					</nav>
					<div class="tg-themetabs">
						<ul class="tg-navtbs" role="tablist">
							<li role="presentation" class="active"><a href="#home" data-toggle="tab">Already Registered</a></li>
							<li role="presentation"><a href="#profile" data-toggle="tab">New to Travleu ?</a></li>
						</ul>
						<div class="tg-tabcontent tab-content">
							<div role="tabpanel" class="tab-pane active fade in" id="home">
								<form class="tg-formtheme tg-formlogin">
									<fieldset>
										<div class="form-group">
											<label>Name or Email <sup>*</sup></label>
											<input type="text" name="firstname" class="form-control" placeholder="">
										</div>
										<div class="form-group">
											<label>Password <sup>*</sup></label>
											<input type="password" name="password" class="form-control" placeholder="">
										</div>
										<div class="form-group">
											<div class="tg-checkbox">
												<input type="checkbox" name="remember" id="rememberpass">
												<label for="rememberpass">Remember Me</label>
											</div>
											<span><a href="#">Lost your password?</a></span>
										</div>
										<button class="tg-btn tg-btn-lg"><span>update profile</span></button>
									</fieldset>
								</form>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="profile">
								<form class="tg-formtheme tg-formlogin">
									<fieldset>
										<div class="form-group">
											<label>Name or Email <sup>*</sup></label>
											<input type="text" name="firstname" class="form-control" placeholder="">
										</div>
										<div class="form-group">
											<label>Password <sup>*</sup></label>
											<input type="password" name="password" class="form-control" placeholder="">
										</div>
										<div class="form-group">
											<div class="tg-checkbox">
												<input type="checkbox" name="remember" id="remember">
												<label for="remember">Remember Me</label>
											</div>
											<span><a href="#">Lost your password?</a></span>
										</div>
										<button class="tg-btn tg-btn-lg"><span>update profile</span></button>
									</fieldset>
								</form>
							</div>
						</div>
					</div>
					<div class="tg-shareor"><span>or</span></div>
					<div class="tg-signupwith">
						<h2>Sign in With...</h2>
						<ul class="tg-sharesocialicon">
							<li class="tg-facebook"><a href="#"><i class="icon-facebook-1"></i><span>Facebook</span></a></li>
							<li class="tg-twitter"><a href="#"><i class="icon-twitter-1"></i><span>Twitter</span></a></li>
							<li class="tg-googleplus"><a href="#"><i class="icon-google4"></i><span>Google+</span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--************************************
			Login Singup End
	*************************************-->
    <script src="{{ asset('dashboardUser_res/js/vendor/jquery-library.js') }}"></script>
	<script src="{{ asset('dashboardUser_res/js/vendor/bootstrap-arabic.min.js') }}"></script>
	
	<script src="{{ asset('dashboardUser_res/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('dashboardUser_res/js/jquery.mmenu.all.js') }}"></script>
    <script src="{{ asset('dashboardUser_res/js/jquery.vide.min.js') }}"></script>
    <script src="{{ asset('dashboardUser_res/js/packery.pkgd.min.js') }}"></script>
    <script src="{{ asset('dashboardUser_res/js/scrollbar.min.js') }}"></script>
    <script src="{{ asset('dashboardUser_res/js/prettyPhoto.js') }}"></script>
    <script src="{{ asset('dashboardUser_res/js/countdown.js') }}"></script>
    <script src="{{ asset('dashboardUser_res/js/parallax.js') }}"></script>
    <script src="{{ asset('dashboardUser_res/js/main-dash.js') }}"></script>
</body>
</html>

