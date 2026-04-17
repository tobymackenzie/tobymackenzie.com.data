(function(){
	var _html = document.querySelector('html');

	//==add js styling hook
	_html.className += ' ua-js';

	//==set nav initial state
	var _isVisible = false;
	_html.setAttribute('data-nav-state', 'hidden');

	//==nav toggle
	var _hide = function(){
		_html.setAttribute('data-nav-state', 'hidden');
		_isVisible = false;
	}
	var _show = function(){
		_html.setAttribute('data-nav-state', 'visible');
		_isVisible = true;
	}
	var _toggle = function(){
		if(_isVisible){
			_hide();
		}else{
			_show();
		}
	};
	//--create element
	var _mainNavEl = document.querySelector('.shlNav')
	var _toggleEl = document.createElement('button');
	_toggleEl.setAttribute('class', 'shlNavToggle');
	_toggleEl.innerText = 'Menu';
	var _shlHeader = document.querySelector('.shlHeader');
	_shlHeader.appendChild(_toggleEl);
	//--toggle on click
	_toggleEl.addEventListener('click', function(){
		_toggle();
		_mainNavEl.setAttribute('tabindex', -1);
		_mainNavEl.focus();
	}, false);
	//--toggle on focus of nav item
	_mainNavEl.addEventListener('focusin', _show, false);
	_mainNavEl.addEventListener('focusout', _hide, false);

	//==blocker
	var _blocker = document.createElement('div');
	_blocker.className = 'blocker';
	document.querySelector('body').appendChild(_blocker);
}());
