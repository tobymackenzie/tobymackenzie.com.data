<?php
$titleBit = "Flex";
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
			/*border: 3px dotted black;*/
			padding: 1em;
			width: 50%;
		}
		.boxContent{
			overflow: hidden;
		}
		.boxes{
			display: flex;
			flex-wrap: wrap;
		}
		.box-n-1, .box-n-2{
			border-top: 0;
		}
	}
	@media screen and (min-width: 38em) and (max-width: 47.9999em){
		.box-n-odd{
			border-right: 3px dotted black;
		}
	}
	@media screen and (min-width: 48em){
		.box{
			width: 33.33%;
		}
		.box-n-3{
			border-top: 0;
		}
	}
	@media screen and (min-width: 48em) and (max-width: 59.9999em){
		.box:nth-child(3n+1), .box:nth-child(3n+2){
			border-right: 3px dotted black;
		}
	}
	@media screen and (min-width: 60em){
		.box{
			width: 25%;
		}
		.box-n-4{
			border-top: 0;
		}
		.box:nth-child(4n+1), .box:nth-child(4n+2), .box:nth-child(4n+3){
			border-right: 3px dotted black;
		}
	}
</style>
<?php
$styles = ob_get_contents();
ob_end_clean();

require('./index.php');
