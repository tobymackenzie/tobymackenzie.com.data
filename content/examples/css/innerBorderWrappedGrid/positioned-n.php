<?php
$titleBit = "Positioned";
ob_start();
?>
<style>
	*{
		box-sizing: border-box;
	}
	.box{
		border-top: 3px dotted black;
		padding: 1em 0;
	}
	.box-n-1{
		border-top: 0;
	}
	@media screen and (min-width: 38em){
		.box{
			border: 0;
			float: left;
			padding: 0;
			width: 50%;
		}
		.boxContent{
			overflow: hidden;
			padding: 1em;
		}
		.boxes{
			overflow: hidden;
			position: relative;
		}
		.box-n-2:after{
			border-left: 3px dotted black;
			content: ' ';
			height: 100%;
			position: absolute;
			top: 0;
			width: 1px;
			z-index: 10;
		}
		.box-n-1:before{
			display: none;
		}
	}
	@media screen and (min-width: 38em) and (max-width: 47.9999em){
		.box-n-odd{
			clear: left;
		}
		.box-n-odd:before{
			border-top: 3px dotted black;
			content: ' ';
			height: 1px;
			position: absolute;
			right: 0;
			width: 100%;
			z-index: 10;
		}
	}
	@media screen and (min-width: 48em){
		.box{
			width: 33.33%;
		}
		.box-n-3:after{
			border-left: 3px dotted black;
			content: ' ';
			height: 100%;
			position: absolute;
			top: 0;
			width: 1px;
			z-index: 10;
		}
	}
	@media screen and (min-width: 48em) and (max-width: 59.9999em){
		.box:nth-child(3n+1){
			clear: left;
		}
		.box:nth-child(3n+1):before{
			border-top: 3px dotted black;
			content: ' ';
			height: 1px;
			position: absolute;
			right: 0;
			width: 100%;
			z-index: 10;
		}
	}
	@media screen and (min-width: 60em){
		.box{
			width: 25%;
		}
		.box-n-4:after{
			border-left: 3px dotted black;
			content: ' ';
			height: 100%;
			position: absolute;
			top: 0;
			width: 1px;
			z-index: 10;
		}
		.box:nth-child(4n+1){
			clear: left;
		}
		.box:nth-child(4n+1):before{
			border-top: 3px dotted black;
			content: ' ';
			height: 1px;
			position: absolute;
			right: 0;
			width: 100%;
			z-index: 10;
		}
	}
</style>
<?php
$styles = ob_get_contents();
ob_end_clean();

require('./index.php');
