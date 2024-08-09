---
categories: [www]
date: 2020-08-20T02:08:22-04:00
date_gmt: 2020-08-20T06:08:22+00:00
guid: 'https://www.tobymackenzie.com/blog/?p=3001'
id: 3001
modified: 2020-08-20T02:08:22-04:00
modified_gmt: 2020-08-20T06:08:22+00:00
name: js-submit-form-overridden-method
tags: [forms, javascript, solution]
---

Javascript: Submit form with overridden submit method
=====================================================

I come across the situation occasionally where I am trying to submit a form programmatically with javascript, but it happens to contain a field with an `id` or `name` attribute of `submit`.<!--more-->  I am referring to using the [`submit()` method](https://developer.mozilla.org/en-US/docs/Web/API/HTMLFormElement/submit) of the form element to actually submit the form, as opposed to submitting via AJAX.  You might want to do this if you have something to do before the form submission goes to the server, such as mutating field values or user-not-bot validation (such as captcha).

The problem with the above scenario is caused by a special habit of form elements, wherein each field contained within it is added as a property of the element having the same name as the attribute value.  Being instance properties, they override the prototype, including methods such as `submit()`.  Thus, calling `_formEl.submit()` will throw an "is not a function" error because the property will be an element.

To get around this, we can use the original method from the prototype.  So, we would check if our `submit` property is a function, like `if(typeof formEl.submit === 'function')`.  If so, we could just call, `formEl.submit()`.  Otherwise, we could get the prototype method off of `window.HTMLFormElement.prototype`, or a new form element in really old browsers.  We'd use `call()` or `apply()` to give it the proper scope of our desired form element.

A simple demonstration:

``` html
<form>
	<input name="s" />
	<input type="submit" name="submit" />
</form>

<script>
document.querySelector('form').addEventListener('submit', function(_event){
	_event.preventDefault();
	if(window.confirm("Are you not a robot?")){
		if(typeof this.submit === 'function'){
			this.submit();
		}else{
			(
				window.HTMLFormElement 
				? HTMLFormElement.prototype 
				: document.createElement('form')
			).submit.call(this);
		}
	}else{
		alert("We don't serve your kind here.");
	}
});
</script>
```
