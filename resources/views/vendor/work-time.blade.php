<?php
    $title = __('أوقات التواجد');
?>

@include('front_views.layouts.header')
@include('vendor.layouts.sidemenu')

<div id="tg-content" class="tg-content">
    <div class="tg-dashboard">
        <div class="tg-box tg-ediprofile">
            <div class="tg-heading">
                <h3>{{__('أوقات التواجد')}}</h3>
            </div>
            <div class="tg-dashboardcontent">
                <div class="table-responsive">
                    <table class="workTimeTable table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('اليوم')}}</th>
                                <th>{{__('وقت البدء')}}</th>
                                <th>{{__('وقت الانتهاء')}}</th>
                                <th>{{__('أو')}}</th>
                                <th>{{__('على مدار اليوم')}}</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    <input type="checkbox" name="check-day" class="check-day" data-day="saturday" value="saturday">
                                </td>
                                <td>
                                    <span>{{__('السبت')}}</span>
                                </td>
                                <td>
                                    <input type="time" name="open-time" data-day="Saturday" disabled>
                                </td>
                                <td>
                                    <input type="time" name="close-time" data-day="Saturday" disabled>
                                </td>
                                <td></td>
                                <td><input type="checkbox" name="all-day" disabled></td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="check-day" class="check-day" data-day="sunday" value="sunday">
                                </td>
                                <td>
                                    <span>{{__('الأحد')}}</span>
                                </td>
                                <td>
                                    <input type="time" name="open-time" data-day="Sunday" disabled>
                                </td>
                                <td>
                                    <input type="time" name="close-time" data-day="Sunday" disabled>
                                </td>
                                <td></td>
                                <td><input type="checkbox" name="all-day" disabled></td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="check-day" class="check-day" data-day="monday" value="monday">
                                </td>
                                <td>
                                    <span>{{__('الإثنين')}}</span>
                                </td>
                                <td>
                                    <input type="time" name="open-time" data-day="Monday" disabled>
                                </td>
                                <td>
                                    <input type="time" name="close-time" data-day="Monday" disabled>
                                </td>
                                <td></td>
                                <td><input type="checkbox" name="all-day" disabled></td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="check-day" class="check-day" data-day="tuesday" value="tuesday">
                                </td>
                                <td>
                                    <span>{{__('الثلاثاء')}}</span>
                                </td>
                                <td>
                                    <input type="time" name="open-time" data-day="Tuesday" disabled>
                                </td>
                                <td>
                                    <input type="time" name="close-time" data-day="Tuesday" disabled>
                                </td>
                                <td></td>
                                <td><input type="checkbox" name="all-day" disabled></td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="check-day" class="check-day" data-day="wednesday" value="wednesday">
                                </td>
                                <td>
                                    <span>{{__('الأربعاء')}}</span>
                                </td>
                                <td>
                                    <input type="time" name="open-time" data-day="wednesday" disabled>
                                </td>
                                <td>
                                    <input type="time" name="close-time" data-day="wednesday" disabled>
                                </td>
                                <td></td>
                                <td><input type="checkbox" name="all-day" disabled></td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="check-day" class="check-day" data-day="thursday" value="thursday">
                                </td>
                                <td>
                                    <span>{{__('الخميس')}}</span>
                                </td>
                                <td>
                                    <input type="time" name="open-time" data-day="Thursday" disabled>
                                </td>
                                <td>
                                    <input type="time" name="close-time" data-day="Thursday" disabled>
                                </td>
                                <td></td>
                                <td><input type="checkbox" name="all-day" disabled></td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="check-day" class="check-day" data-day="friday" value="friday">
                                </td>
                                <td>
                                    <span>{{__('الجمعة')}}</span>
                                </td>
                                <td>
                                    <input type="time" name="open-time" data-day="Friday" disabled>
                                </td>
                                <td>
                                    <input type="time" name="close-time" data-day="Friday" disabled>
                                </td>
                                <td></td>
                                <td><input type="checkbox" name="all-day" disabled></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul style="display:none;" class="working-time-list">
                    @foreach ($workHours as $workHour)
                        <li>
                            <span class="day">{{ $workHour->day }}</span>
                            <span class="open">{{ $workHour->opening_time }}</span>
                            <span class="close">{{ $workHour->close_time }}</span>
                        </li>
                    @endforeach
                </ul>
                <form action="{{ url('dashboard/workHours/save/'.$place->id) }}" class="reserve-date-list" method="post">
                    @csrf
                    <input name="selected_days" type="hidden">
                    <button type="submit">{{__('حفظ')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('vendor.layouts.endsidemenu')
@include('front_views.layouts.footer')