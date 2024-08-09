---
categories: [www]
comment_count: 2
date: 2012-03-30T06:45:20+00:00
date_gmt: 2012-03-30T06:45:20+00:00
guid: 'http://tobymackenzie.wordpress.com/?p=473'
id: 473
modified: 2019-08-01T21:40:46-04:00
modified_gmt: 2019-08-02T01:40:46+00:00
name: symfony-and-custom-validation-for-entity-based-forms
tags: [forms, symfony, validation]
---

Symfony 2.0 and Custom Validation for Entity Based Forms
========================================================

I recently started using [Symfony's form system](http://symfony.com/doc/current/book/forms.html) at work instead of dealing with the forms entirely manually.  I had found it confusing at first and so was reluctant to start using it, but now that I've started to figure it out, it's proving rather nice.  I still haven't figured out how to create form classes or deal with subforms or any fancy stuff like that, but it's helped reduce the amount of work effort per form and normalize the way we handle each.

Forms for entities are nice and do a lot automatically.  However, I did run into a problem with them in dealing with a multi-site system:  They can't currently have custom validation applied to them.  The constraints are specified in annotations in the entity or YAML or other configuration files, which I don't think will easily accommodate being overridden for an individual site's needs.  We have many sites that have similar functionality that we want to share between them but some need things slightly different.  To accommodate a site having custom validation, I created a form service with a function to handle custom validation constraints.  The function looks like:

<!--more-->

``` php
public function validateCustom(&$form, &$constraints = null){
	if(!$constraints){
		$constraints = (isset($form->customConstraints)) ? $form->customConstraints : new ConstraintCollection();
	}
	$violations = new ConstraintViolationList();
	$values = Array();
	foreach($constraints->fields as $key=> $constraint){
		$getter = "get".ucfirst($key);
		$values[$key] = $form->getClientData()->$getter();
	}
	$violations = $this->validator->validateValue($values, $constraints);
	if(count($violations) > 0){
		foreach ($violations as $violation) {
			$propertyPath = new PropertyPath($violation->getPropertyPath());
			$template = $violation->getMessageTemplate();
			$parameters = $violation->getMessageParameters();
			$error = new FormError($template, $parameters);

/*
			$child = $form;
			foreach ($propertyPath->getElements() as $element) {
				$children = $child->getChildren();
				if (!isset($children[$element])) {
					$form->addError($error);
					break;
				}
				$child = &$children[$element];
			}
			$child->addError($error);
*/
			$form->addError($error);
		}
	}
}
```

The function is based on the Symfony core version, but modified to handle a custom ConstraintCollection.  The constraints can be passed in as a parameter along with the form or attached to the form with a custom attribute (obviously this could cause problems in the future, but I'll worry about that then).  It loops through the ConstraintCollection to build an array of values, then validates them, and builds the errors and adds them to the form if need be.  Note that there is a part for handling child forms that is commented out:  I couldn't get this to work (and didn't need to since I haven't used those yet) so it will only work for offspring free forms.

To use then, you'd bind the request like normal, and then run the function before checking if the form is valid:

``` php
$form->bindRequest($this->getRequest());
$this->get('formService')->validateCustom($form);
if($form->isValid()){…}
```

The 2.1 release is supposed to be able to handle custom validation, but this will tide us over until then.
