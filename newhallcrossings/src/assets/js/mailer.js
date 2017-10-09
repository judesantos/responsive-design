'use strict'

function send_mail(type, url, formData, success_cb, error_cb) {
  $.ajax({
      type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
      url: url, // the url where we want to POST
      data: formData, // our data object
      dataType: 'text', // what type of data do we expect back from the server
      encode: true,
      success: function (response) {
        if (typeof success_cb !== 'undefined') {
          success_cb(response);
        }
      },
      error: function (error) {
        if (typeof error_cb !== 'undefined') {
          error_cb(error);
        }
      },
  })
  // using the done promise callback
  //.done(function(data) {
  //    if (typeof success_cb !== 'undefined') {
  //      success_cb();
  //    }
  //
  //});
}
