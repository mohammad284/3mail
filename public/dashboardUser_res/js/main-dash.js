/* -------------------------------------
		CUSTOM FUNCTION WRITE HERE
-------------------------------------- */
"use strict";
jQuery(document).on('ready', function() {
	
	$('.offers-tabs table thead input[type="checkbox"]').on('click',function(){
		if (!$(this).is(":checked")) {
			$(this).parents('thead').siblings('tbody').find('input[type="checkbox"]').each(function(){
				$(this).removeProp('checked');
			});
			$('.send-group-invites').prop('disabled','disabled');
		} else {
			$(this).parents('thead').siblings('tbody').find('input[type="checkbox"]').each(function(){
				$(this).prop('checked','checked');
			});
			$('.send-group-invites').removeProp('disabled');
		}
		selectedInvites($(this));
	});

	$('.offers-tabs table tbody input[type="checkbox"]').on('click',function(){
		var check_all = true;
		$(this).parents('tbody').find('input[type="checkbox"]').each(function(){
			if (!$(this).is(":checked")) {
				check_all = false;
			}
		});
		if (check_all) {
			$(this).parents('table').find('thead').find('input[type="checkbox"]').prop('checked','checked');
		} else {
			$(this).parents('table').find('thead').find('input[type="checkbox"]').removeProp('checked');
		}
		$(this).parents('tbody').find('input[type="checkbox"]').each(function(){
			$('.send-group-invites').prop('disabled','disabled');
			if ($(this).is(":checked")) {
				$('.send-group-invites').removeProp('disabled');
			}
		});
		selectedInvites($(this));
	});

	$('.offers-tabs .nav-tabs li a').on('click',function(){
		if(!$(this).parent('li').hasClass('active')) {
			$('.offers-tabs table input[type="checkbox"]').each(function(){
				$(this).removeProp('checked');
			});
			$('.send-group-invites').prop('disabled','disabled');
		}
		$('#clients_all .selected-invites').val('');
	});

	function selectedInvites(ele_input) {
		var clients_arr = [];
		ele_input.parents('table').find('tbody').find('input[type="checkbox"]').each(function(){
			var input_val = $(this).data('client');
			if($(this).is(":checked")) {
				clients_arr.push(input_val);
			}
		});
		if(clients_arr.length == 0) {
			$('#clients_all .selected-invites').val('');
		} else {
			$('#clients_all .selected-invites').val(clients_arr);
		}
	}


  // Reservation

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

  // Save New Day Data
  $('.reserve-date-list input[name="agree-changes"]').on('click',function(){
    $('.reserve-date-list input[name="selected_days"]').val(saveSelectedDays());
    $('.reserve-date-list input[name="selected_days"]').val($('.reserve-date-list input[name="selected_days"]').val().slice(0,-1));
    if($(this).is(':checked')) {
      $(this).siblings('button').removeProp('disabled');
    } else {
      $(this).siblings('button').prop('disabled',true);
    }
  });
  $('.reserve-date-list input[name="agree-changes"] + label').on('click',function(){
    $('.reserve-date-list input[name="selected_days"]').val(saveSelectedDays());
    $('.reserve-date-list input[name="selected_days"]').val($('.reserve-date-list input[name="selected_days"]').val().slice(0,-1));
    if($(this).siblings('input[name="agree-changes"]').is(':checked')) {
      $(this).siblings('button').removeProp('disabled');
    } else {
      $(this).siblings('button').prop('disabled',true);
    }
  });

  function saveSelectedDays () {
    var all_reservation_date = [];
    $('.workTimeTable tbody .check-day').each(function(){
      var reservation_date_item = [];
      if($(this).is(':checked')) {
        reservation_date_item[0] = $(this).data('day').toLowerCase();
        var all_day = $(this).parents('tr').find('input[name="all-day"]').is(':checked');
        if (all_day) {
          reservation_date_item[1] = "00:00";
          reservation_date_item[2] = "00:00|";
        } else {
          reservation_date_item[1] = $(this).parents('tr').find('input[name="open-time"]').val();
          reservation_date_item[2] = $(this).parents('tr').find('input[name="close-time"]').val();
          if(reservation_date_item[1] == reservation_date_item[2]) {
            reservation_date_item[1] = "00:00";
            reservation_date_item[2] = "00:00";
          }
          reservation_date_item[2] += "|";
        }
        all_reservation_date.push(reservation_date_item);
      }
    });
    return all_reservation_date;
  }

  // Show saved Dayes
  if($('ul').hasClass('working-time-list')) {
    $('.working-time-list li').each(function(){
      var item_day = $(this).children('.day').text(),
          item_open = $(this).children('.open').text(),
          item_close = $(this).children('.close').text();

      $('.workTimeTable tbody tr').each(function(){
        if ($(this).find('input[name="check-day"]').data('day').toLowerCase() == item_day) {
          $(this).find('input[name="check-day"]').prop('checked',true);
          $(this).find('input[name="open-time"]').prop('disabled',false);
          $(this).find('input[name="close-time"]').prop('disabled',false);
          $(this).find('input[name="all-day"]').prop('disabled',false);
          if (item_open == item_close) {
            $(this).find('input[name="all-day"]').prop('checked',true);
          } else {
            $(this).find('input[name="open-time"]').val(item_open);
            $(this).find('input[name="close-time"]').val(item_close);
          }
        }
      });

    });
    
  }

});