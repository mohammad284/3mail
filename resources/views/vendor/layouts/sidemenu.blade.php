<main id="tg-main" class="tg-main tg-sectionspace tg-haslayout">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-4 col-lg-3">
                <aside id="tg-sidebar" class="tg-sidebar">

                    <!-- Mobile Btn -->
                    <div class="mobile-menu-btn">
                        <div class="all-area">
                            <span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                            <span class="word">{{__('قائمة لوحة التحكم')}}</span>
                        </div>
                    </div>
                    <!-- ./Mobile Btn -->

                    <div class="tg-widget tg-widgetdashboard">
                        <div class="tg-widgettitle">
                            <h3>{{__('حسابي')}}</h3>
                        </div>
                        <div class="tg-widgetcontent">
                            <ul>
                                <li class="selected"><a href="/dashboard"><i class='bx bx-user-circle'></i><span>{{__('معلومات الحساب')}}</span></a></li>
                                <li><a href="/dashboard/MyProfile"><i class='bx bx-pencil'></i><span>{{__('تعديل الحساب')}}</span></a></li>
                                <li><a href="/dashboard/myNotification"><i class='bx bx-bell'></i><span> {{__('إشعاراتي')}}</span></a></li>
                                @if (Auth::user()->user_type == 'vendor')
                                <li><a href="/dashboard/newplace"><i class='bx bx-plus-circle'></i><span>{{__('اضافة مكان جديد')}}</span></a></li>
                                <li><a href="/dashboard/MyPlace"><i class='bx bx-buildings'></i><span>{{__('تعديل معالمي')}}</span></a></li>
                                <li><a href="/dashboard/myOffers"><i class='bx bxs-discount'></i><span>{{__('عروضي المستلمة')}}</span></a></li>
                                <li><a href="/dashboard/vendorOffer"><i class='bx bxs-offer'></i><span> {{__('العروض المرسلة')}}</span></a></li>
                                <li><a href="/dashboard/BookingPlace"><i class='bx bx-list-check'></i><span>{{__('طلبات الحجز')}}</span></a></li>
                                <li><a href="/dashboard/previousReservation"><i class='bx bx-spreadsheet'></i><span>{{__('حجوزات الزبائن السابقة')}}</span></a></li>
                                <li><a href="/dashboard/userReservation"><i class='bx bx-chair'></i><span>{{__('حجوزاتي')}}</span></a></li>
                                <li><a href="/dashboard/myClients"><i class='bx bx-group'></i><span>{{__('عملائي')}}</span></a></li>
                                <li><a href="/dashboard/workHoursPlaces"><i class='bx bx-time-five'></i><span>{{__('أوقات التواجد')}}</span></a></li>
                                
                            
                                @endif
                                @if (Auth::user()->user_type == 'users')
                                <li><a href="/dashboard/myOffers"><i class='bx bxs-discount'></i><span>{{__('عروضي')}}</span></a></li>
                                <li><a href="/dashboard/userReservation"><i class='bx bx-chair'></i><span>{{__('حجوزاتي')}}</span></a></li>
                                @endif
                                <li><a href="/dashboard/favourite"><i class='bx bxs-heart' ></i><span>{{__('المفضلة')}}</span></a></li>
                                <li><a href="/logout"><i class='bx bx-power-off' ></i><span>{{__('تسجيل خروج')}}</span></a></li>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
            <div class="col-xs-12 col-md-8 col-lg-9">
