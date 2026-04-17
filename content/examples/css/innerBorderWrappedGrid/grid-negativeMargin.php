<?php
$titleBit = "Grid negative margin";
ob_start();
?>
<style>
	.box{
		border-top: 3px dotted black;
		padding: 1em 0;
	}
	.boxes{
		margin-top: -3px;
	}
	.boxesWrap{
		overflow: hidden;
	}
	@supports (display: grid){
		@media screen and (min-width: 38em){
			.box{
				border-left: 3px dotted black;
				padding: 1em;
			}
			.boxes{
				display: grid;
				grid-template-columns: repeat(2, 1fr);
				margin-left: -3px;
			}
		}
		@media screen and (min-width: 48em){
			.boxes{
				grid-template-columns: repeat(3, 1fr);
			}
		}
		@media screen and (min-width: 60em){
			.boxes{
				grid-template-columns: repeat(4, 1fr);
			}
		}
	}
</style>
<?php
$styles = ob_get_contents();
ob_end_clean();

require('./index.php');
