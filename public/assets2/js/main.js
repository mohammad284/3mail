"use strict";

jQuery(document).ready(function ($) {
  $(document).ready(function () {
    //E-mail Ajax Send
    $("form").submit(function () {
      //Change
      var th = $(this);
      $.ajax({
        type: "POST",
        url: "assets/mail/mail.php",
        //Change
        data: th.serialize()
      }).done(function () {
        UIkit.notification({
          message: 'Form sent successfully!',
          status: 'success',
          pos: 'top-center',
          timeout: 5000
        });
        setTimeout(function () {
          // Done Functions
          th.trigger("reset");
        }, 1000);
      });
      return false;
    });
  });

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
$( ".owl-prev").html('<i class="fas fa-chevron-left"></i>');
$( ".owl-next").html('<i class="fa fa-chevron-right"></i>');
});