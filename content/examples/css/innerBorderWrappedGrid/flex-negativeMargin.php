<?php
$titleBit = "Flex Negative Margin";
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
			border-bottom: 3px dotted black;
			border-right: 3px dotted black;
			flex: 0 1 50%;
			padding: 1em;
		}
		.boxContent{
			overflow: hidden;
		}
		.boxes{
			display: flex;
			flex-wrap: wrap;
			margin: 0 -3px -3px 0;
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
</style>
<?php
$styles = ob_get_contents();
ob_end_clean();

require('./index.php');
