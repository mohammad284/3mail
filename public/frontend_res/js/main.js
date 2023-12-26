"use strict";

jQuery(document).ready(function ($) {
  
  /* -- open & close mobile menu -- */
  $('.page-header__inner .mobile-btn span').on('click',function(){
    $('.page-header__right').addClass('open');
    $('.overlay-menu').fadeIn(500);
  });
  $('.overlay-menu').on('click',function(){
    $('.page-header__right').removeClass('open');
    $('.tg-widgetdashboard').removeClass('open');
    $('.overlay-menu').fadeOut(500);
  });
  /* -- ./open & close mobile menu -- */

  /* -- open & close dashboard menu -- */
  $('.mobile-menu-btn .all-area').on('click',function(){
    $('.tg-widgetdashboard').addClass('open');
    $('.overlay-menu').fadeIn(500);
  });
  /* -- ./open & close dashboard menu -- */

  $('.owl-carousel').owlCarousel({
    rtl:true,
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    }
  });
  $( ".owl-prev").html('<i class="fa fa-chevron-left"></i>');
  $( ".owl-next").html('<i class="fa fa-chevron-right"></i>');


  /* -- Add New Place option -- */
  $('.place-section-btns li input').on('click',function(){
    var arr_temp = [];
    $(this).parents('.place-section-btns').find('input').each(function() {
        if($(this).is(':checked')) {
          arr_temp.push($(this).val());
        }
    });
    if (arr_temp.includes('31')) {
      $('.food-menu').slideDown(500);
    } else {
      $('.food-menu').slideUp(500);
    }
    if (arr_temp.includes('32')) {
      $('.link-place-reserve').slideDown(500);
    } else {
      $('.link-place-reserve').slideUp(500);
    }
  });
  var arr_temp_all = [];
  $('.place-section-btns li input').each(function() {
    if($(this).is(':checked')) {
      arr_temp_all.push($(this).val());
    }
  });
  if (arr_temp_all.includes('31')) {
    $('.food-menu').slideDown(500);
  } else {
    $('.food-menu').slideUp(500);
  }
  if (arr_temp_all.includes('32')) {
    $('.link-place-reserve').slideDown(500);
  } else {
    $('.link-place-reserve').slideUp(500);
  }

  /* -- Delete Place Image -- */
  $('button[data-type="popup"]').on('click',function(){
    var btn_popup = $(this).data('popup');
    var item_popup = '.popup-box[data-popup="' + btn_popup + '"]';
    $(item_popup).addClass('open');
  });
  $('.popup-box button[data-value="close"]').on('click',function(){
    $(this).parents('.popup-box').removeClass('open');
  });
  /* -- ./Delete Palce Image -- */
  
  
  $(".workTimeTable .check-day").on("click", function () {
    var day = $(this).data("day");
    var target_input1 = $(this).parents("tr").find("td input[name=open-time]");
    var target_input2 = $(this).parents("tr").find("td input[name=close-time]");
    var target_input3 = $(this).parents("tr").find("td input[name=all-day]");
    if ($(this).is(":checked")) {
      target_input1.prop("disabled", false);
      target_input2.prop("disabled", false);
      target_input3.prop("disabled", false);
    } else {
      target_input1.val("");
      target_input2.val("");
      target_input3.prop('checked',false);
      target_input1.prop("disabled", true);
      target_input2.prop("disabled", true);
      target_input3.prop("disabled", true);
    }
  });

  $('.workTimeTable input[name=open-time]').on('change',function(){
    var target_input3 = $(this).parents("tr").find("td input[name=all-day]");
    target_input3.prop('checked',false);
  });

  $('.workTimeTable input[name=close-time]').on('change',function(){
    var target_input3 = $(this).parents("tr").find("td input[name=all-day]");
    target_input3.prop('checked',false);
  });

  $('.workTimeTable input[name=all-day]').on('change',function(){
    var target_input1 = $(this).parents("tr").find("td input[name=open-time]");
    var target_input2 = $(this).parents("tr").find("td input[name=close-time]");
    target_input1.val("");
    target_input2.val("");
  });

  // Reservation Page
  if ($('form').hasClass('reservation-form')) {
    var today_name = $('.today-name-input').val().toLowerCase(),
        opening_date = [],
        opening_full_day = [],
        opening_days = [];
        
    $('.opening-days-array li').each(function(){
      var start_time_temp = $(this).children('.open').text(),
          close_time_temp = $(this).children('.close').text(),
          mins_str = '',
          hours_str = '',
          time_str = '',
          opening_hours = [],
          temp_arr = [],
          start_hour_temp = start_time_temp[0] + start_time_temp[1],
          start_min_temp = start_time_temp[3] + start_time_temp[4],
          close_hour_temp = close_time_temp[0] + close_time_temp[1],
          close_min_temp = close_time_temp[3] + close_time_temp[4];
          start_min_temp = parseInt(start_min_temp);
          start_hour_temp = parseInt(start_hour_temp);
          close_min_temp = parseInt(close_min_temp);
          close_hour_temp = parseInt(close_hour_temp);

      if((close_hour_temp - start_hour_temp) > 2) {
        var start_min_temp_zero = start_min_temp;
        for (var i = start_hour_temp; i < (close_hour_temp -1) ; i++) {
          if (start_min_temp_zero == 0) {
            mins_str = (0).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
            hours_str = (i).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
            time_str = hours_str + ":" + mins_str;
            opening_hours.push(time_str);
            mins_str = (30).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
            hours_str = (i).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
            time_str = hours_str + ":" + mins_str;
            opening_hours.push(time_str);
            
          } else if ((start_min_temp_zero > 0)&& (start_min_temp_zero < 30)) {
            mins_str = (30).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
            hours_str = (i).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
            time_str = hours_str + ":" + mins_str;
            opening_hours.push(time_str);
          }
          start_min_temp_zero = 0;
          if (i == (close_hour_temp - 2)) {
            if ((close_min_temp >= 0) && (close_min_temp < 30)) {
              mins_str = (0).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
              hours_str = (i+1).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
              time_str = hours_str + ":" + mins_str;
              opening_hours.push(time_str);
            } else {
              mins_str = (0).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
              hours_str = (i+1).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
              time_str = hours_str + ":" + mins_str;
              opening_hours.push(time_str);
              mins_str = (30).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
              hours_str = (i+1).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
              time_str = hours_str + ":" + mins_str;
              opening_hours.push(time_str);
            }
          }
        }        
      } else if (start_hour_temp > close_hour_temp) {
        var time_different = close_hour_temp + (24 - start_hour_temp);
        for (var j = 0; j < (time_different -1); j ++) {
          i = j + start_hour_temp;
          if (i >= 24) {
            i -= 24;
          }
          if (start_min_temp_zero == 0) {
            mins_str = (0).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
            hours_str = (i).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
            time_str = hours_str + ":" + mins_str;
            opening_hours.push(time_str);
            mins_str = (30).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
            hours_str = (i).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
            time_str = hours_str + ":" + mins_str;
            opening_hours.push(time_str);
            
          } else if ((start_min_temp_zero > 0)&& (start_min_temp_zero < 30)) {
            mins_str = (30).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
            hours_str = (i).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
            time_str = hours_str + ":" + mins_str;
            opening_hours.push(time_str);
          }
          start_min_temp_zero = 0;
          
          if (j == (time_different - 2)) {
            if (i >= 23) {
              i -= 24;
            }
            if ((close_min_temp >= 0) && (close_min_temp < 30)) {
              mins_str = (0).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
              hours_str = (i+1).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
              time_str = hours_str + ":" + mins_str;
              opening_hours.push(time_str);
            } else {
              mins_str = (0).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
              hours_str = (i+1).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
              time_str = hours_str + ":" + mins_str;
              opening_hours.push(time_str);
              mins_str = (30).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
              hours_str = (i+1).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
              time_str = hours_str + ":" + mins_str;
              opening_hours.push(time_str);
            }
          }
        }
      } else if (start_hour_temp == close_hour_temp) {
        for (var i = 0; i < 24; i++) {
          mins_str = (0).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
          hours_str = (i).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
          time_str = hours_str + ":" + mins_str;
          opening_hours.push(time_str);
          mins_str = (30).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
          hours_str = (i).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
          time_str = hours_str + ":" + mins_str;
          opening_hours.push(time_str);
        }
      }
      temp_arr.push($(this).children('.day').text());
      temp_arr.push(opening_hours);
      opening_date.push(temp_arr);
    });

    switch(today_name) {
      case "saturday":
        today_name = "السبت"
        break;
      case "sunday":
        today_name = "الأحد"
        break;
      case "monday":
        today_name = "الإثنين"
        break;
      case "tuesday":
        today_name = "الثلاثاء"
        break;
      case "wednesday":
        today_name = "الأربعاء"
        break;
      case "thursday":
        today_name = "الخميس"
        break;
      case "friday":
        today_name = "الجمعة"
    }

    var days_number = 15,
        year = parseInt($(this).find('.today-year').val()),
        month = parseInt($(this).find('.today-month').val()) - 1,
        day = parseInt($(this).find('.today-day').val()),
        today_date = new Date(year, month, day),
        day_step = 0,
        days_arr = ['السبت','الأحد','الإثنين','الثلاثاء','الأربعاء','الخميس','الجمعة'],
        date_str = "",
        done = true,
        day_index = days_arr.indexOf(today_name);

    for (var i = 0; i <days_arr.length; i++) {
      for (var j = 0; j < opening_date.length; j++) {
        if (opening_date[j][0] == days_arr[i]) {
          opening_days.push(days_arr[i]);
          break;
        }
      }
    }
    var day_name = days_arr[day_index];
    
      while(days_number > 0) {
        if (opening_days.includes(day_name)) {
          var opening_full_day_item = [];
          var opening_full_day_str = (today_date.getDate()).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false}) +
                                    "/" + 
                                    (today_date.getMonth() + 1).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false}) + 
                                    "/" + today_date.getFullYear();
          var day_name_temp = day_name + ' ';
          opening_full_day_item.push(day_name_temp);       
          opening_full_day_item.push(opening_full_day_str);                      
          opening_full_day.push(opening_full_day_item);
          days_number --;
        }
        const tomorrow = new Date(today_date);
        tomorrow.setDate(tomorrow.getDate() + 1);
        today_date = tomorrow;
        if(day_index >= 6) {
          day_index = 0;
        } else {
          day_index++;
        }
        day_name = days_arr[day_index];
      }
      
    // Show Results in Front
    for (var i = 0; i < opening_full_day.length; i++) {
      var temp = opening_full_day[i][0] + opening_full_day[i][1];
      $('.reservation-form .reservation-days-list').append(`
        <li>
          <div class="single-input">
            <input type="radio" name="reservation_day" value="` + temp +`">
            <span><span class="day-name">`+ opening_full_day[i][0] +`</span>`+ opening_full_day[i][1]+`</span>
          </div>
        </li>
      `);
    }
    
  };

  $('.reservation-form .reservation-days-list input').on('click',function(){
    var input_open_day = $(this).siblings('span').children('.day-name').text();
    for (var i = 0; i <opening_date.length; i++) {
      var date_day = opening_date[i][0];
      if (input_open_day.includes(date_day)) {
        var opening_date_str = [];
        opening_date_str = opening_date[i][1];
        $('.reservation-form .reservation-hours').text('');
        for (var j = 0; j < opening_date_str.length; j++) {
          $('.reservation-form .reservation-hours').append(`
          <li>
            <div class="single-input">
                <input type="radio" name="reservation_time" value="`+ opening_date_str[j] +`">
                <span>`+ opening_date_str[j] +`</span>
            </div>
        </li>
        `);
        }
      }
    }
  });
  
  
});