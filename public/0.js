(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./resources/js/custom.js":
/*!********************************!*\
  !*** ./resources/js/custom.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// Save new user to database
jQuery(document).ready(function () {
  jQuery('#create-user-btn').click(function (e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    jQuery.ajax({
      url: '/create-user',
      method: 'post',
      data: {
        name: jQuery('#name').val(),
        email: jQuery('#email').val(),
        password: jQuery('#password').val()
      },
      success: function success(result) {
        jQuery('.alert').show();
        jQuery('.alert').html(result.success);
        console.log('Uspesno!');
      }
    });
  });
}); // Get your profile data

jQuery(document).ready(function () {
  jQuery('#profile-btn').click(function (e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    jQuery.ajax({
      url: '/user-profile',
      method: 'get',
      data: {
        userId: jQuery('#userId').val()
      },
      success: function success(result) {
        jQuery('.alert').show();
        jQuery('.alert').html(result.success);
        console.log('Uspesno!');
      }
    });
  });
});

/***/ })

}]);