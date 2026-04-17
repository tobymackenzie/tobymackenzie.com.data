<?php
$titleBit = "Flex Negative Margin with Positioned Fallback";
ob_start();
?>
<style><!--
	*{
		box-sizing: border-box;
	}

	/*--mobile first */
	.box{
		border-top: 3px dotted black;
		padding: 1em;
	}
	.box-n-1{
		border-top: 0;
	}

	/*--flex */
	@media screen and (min-width: 38em){
		.box{
			border: 0;
			border-bottom: 3px dotted black;
			border-right: 3px dotted black;
			flex: 0 1 50%;
		}
		.boxContent{
			overflow: hidden;
		}
		.boxes{
			display: flex;
			flex-wrap: wrap;
			margin: 0 -3px -3px 0;
			max-width: none;
			position: relative;
		}
		.boxesWrap{
			overflow: hidden;
		}
	}
	@media screen and (min-width: 48em){
		.box{
			flex-basis: 33.33%;
		}
	}
	@media screen and (min-width: 60em){
		.box{
			flex-basis: 25%;
		}
	}

	/*--fallback */
	@media screen and (min-width: 38em){
		html.ua-no-flexbox .box{
			border: 0;
			float: left;
			padding: 0;
			width: 50%;
		}
		html.ua-no-flexbox .boxContent{
			/*overflow: hidden;*/
			padding: 1em;
		}
		html.ua-no-flexbox .boxes{
			overflow: hidden;
			/*position: relative;*/
		}
		html.ua-no-flexbox .box-n-2 .boxAfter{
			border-left: 3px dotted black;
			content: ' ';
			height: 100%;
			position: absolute;
			top: 0;
			width: 1px;
			z-index: 10;
		}
		html.ua-no-flexbox .box-n-1 .boxBefore{
			display: none;
		}
	}
	@media screen and (min-width: 38em) and (max-width: 47.9999em){
		html.ua-no-flexbox .box-n-odd{
			clear: left;
		}
		html.ua-no-flexbox .box-n-odd .boxBefore{
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
		html.ua-no-flexbox .box{
			width: 33.33%;
		}
		html.ua-no-flexbox .box-n-3 .boxAfter{
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
		html.ua-no-flexbox .box:nth-child(3n+1){
			clear: left;
		}
		html.ua-no-flexbox .box:nth-child(3n+1) .boxBefore{
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
		html.ua-no-flexbox .box{
			width: 25%;
		}
		html.ua-no-flexbox .box-n-4 .boxAfter{
			border-left: 3px dotted black;
			content: ' ';
			height: 100%;
			position: absolute;
			top: 0;
			width: 1px;
			z-index: 10;
		}
		html.ua-no-flexbox .box:nth-child(4n+1){
			clear: left;
		}
		html.ua-no-flexbox .box:nth-child(4n+1) .boxBefore{
			border-top: 3px dotted black;
			content: ' ';
			height: 1px;
			position: absolute;
			right: 0;
			width: 100%;
			z-index: 10;
		}
	}
--></style>
<!--[if lte IE 8]><style>
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
	.box-n-2 .boxAfter{
		border-left: 3px dotted black;
		content: ' ';
		height: 100%;
		position: absolute;
		top: 0;
		width: 1px;
		z-index: 10;
	}
	.box-n-1 .boxBefore{
		display: none;
	}
	.box-n-odd{
		clear: left;
	}
	.box-n-odd .boxBefore{
		border-top: 3px dotted black;
		content: ' ';
		height: 1px;
		position: absolute;
		right: 0;
		width: 100%;
		z-index: 10;
	}
</style><![endif]-->
<?php
$styles = ob_get_contents();
ob_end_clean();

require('./index.php');
