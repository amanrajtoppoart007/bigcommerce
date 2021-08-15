(function(){
 $.notify =  function(text,color)
   {
       $.toast({
           text: JSON.stringify(text),
           showHideTransition: 'slide',  // It can be plain, fade or slide
           bgColor: '#137A11',              // Background color for toast
           textColor: color,            // text color
           allowToastClose: false,       // Show the close button or not
           hideAfter: 5000,              // `false` to make it sticky or time in miliseconds to hide after
           stack: 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
           textAlign: 'left',            // Alignment of text i.e. left, right, center
           position: 'top-right'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
       });
   }
})(jQuery);
