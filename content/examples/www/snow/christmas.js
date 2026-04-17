import {ready as _ready} from './scripts/ready.js';
import {CanvasSnowView} from './scripts/canvasSnowView.js';

if(
	document.querySelector
	&& window.requestAnimationFrame
	&& !(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches)
){
	_ready(function(){
		var _view = new CanvasSnowView();
		_view.activate();
	});
}
