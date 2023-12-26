
$(document).ready(function(){

    $('#menu-btn').on('click',function(){
        $('header').toggleClass('open');
        $('.overlay').fadeToggle(500);
    });

    $('.overlay').on('click',function(){
        $('header').removeClass('open');
        $('.overlay').fadeOut(500);
    })

    /* -- Tinymce Text Editor --*/
     tinymce.init({
        selector: '.tinymce',
        language : "ar",
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table paste"
        ],
        themes: "modern",
        menubar: true,
        resize: true,
      });
    /* -- ./Tinymce Text Editor --*/

});