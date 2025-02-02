---
categories: [www]
date: 2021-08-30T16:53:17-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=3489'
id: 3489
modified: 2021-08-30T16:53:17-04:00
name: jquery-ajax-multipart-form-handling
pings: ['https://api.jquery.com/serialize/']
tags: [ajax, form, jquery, web]
---

jQuery AJAX and multipart form handling
=======================================

I recently had need to submit a web form with file fields via AJAX.  The application uses jQuery and was already submitting forms just fine without file fields using the [`.serialize()` method](https://api.jquery.com/serialize/) to pass data to a [`jQuery.ajax()`](https://api.jquery.com/jQuery.ajax/) call.  That didn't seem to handle the file fields, though.  Searching the internet, I found a solution using the browser built in [`FormData`](https://developer.mozilla.org/en-US/docs/Web/API/FormData/FormData) object.

<!--more-->

The `jQuery.ajax()` method will accept a `FormData` object for the `data` parameter.  To make this work requires setting the `processData` and `contentType` parameters to `false`.  The `enctype` parameter should be set to `multipart/form-data`, just like the form would have.  Putting this all together, the solution looks something like:

``` js
var $form = jQuery('form');
$form.on('submit', function(event){
  event.preventDefault();
  var request = {
    method: $form.attr('method') || 'POST',
    url: $form.attr('action') || window.location.href
  };
  if($form.attr('enctype')){
    request.enctype = $form.attr('enctype');
  }
  if(window.FormData && $form.attr('enctype') === 'multipart/form-data'){
    request.contentType = false;
    request.data = new FormData($form[0]);
    request.processData = false;
  }else{
    request.data = $form.serialize();
  }
  jQuery.ajax(request, function(response){
   console.log(response);
  });
});
```

It falls back to the `.serialize()` method if it doesn't need `FormData` or the browser doesn't support it.  This worked well enough for our needs.
