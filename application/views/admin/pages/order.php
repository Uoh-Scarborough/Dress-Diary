<div id='page'>
	<h1>Re-order</h1>
	<p>Click and drag the boxes around to change the order of the pages. Once you have finished editing your pages click 'Finished editing' to return back to the pages menu.</p>
	<p class='label label-warning'>Notice: Changing the order of pages will save automatically</p>
	<?=$pages?>
	<a href='/admin/pages' class='btn btn-success' >Finished ordering</a>
</div>

<script type="text/javascript">

$(document).ready(function()  {

			$( "#orderable" ).sortable({
				update : function () { 
					$.post("/admin/pages/update_order/", $('#orderable').sortable('serialize')); 
				} 
			});

});

</script>
