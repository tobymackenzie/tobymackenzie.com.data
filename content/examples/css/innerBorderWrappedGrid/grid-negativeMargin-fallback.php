<?php
$titleBit = "Grid negative margin with flex fallback";
ob_start();
?>
<style>
	*{
		box-sizing: border-box;
	}
	.box{
		border-bottom: 3px dotted black;
		padding: 1em;
	}
	.boxes{
		margin-bottom: -3px;
	}
	.boxesWrap{
		overflow: hidden;
	}
	@media screen and (min-width: 38em){
		.box{
			border-right: 3px dotted black;
			flex: 0 1 50%;
			-ms-flex-positive: 1; /*-! make look better for IE 11, see [flexbug 7](https://github.com/philipwalton/flexbugs#flexbug-7) */
		}
		.boxes{
			display: flex;
			display: grid;
			flex-wrap: wrap;
			grid-template-columns: repeat(2, 1fr);
			margin-right: -3px;
		}
	}
	@media screen and (min-width: 48em){
		.box{
			flex-basis: 33.33%;
		}
		.boxes{
			grid-template-columns: repeat(3, 1fr);
		}
	}
	@media screen and (min-width: 60em){
		.box{
			flex-basis: 25%;
		}
		.boxes{
			grid-template-columns: repeat(4, 1fr);
		}
	}
</style>
<?php
$styles = ob_get_contents();
ob_end_clean();

require('./index.php');
