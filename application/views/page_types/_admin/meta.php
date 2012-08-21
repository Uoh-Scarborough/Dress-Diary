<script type='text/javascript'>
$(document).ready(function() {
var intro_config = {
	resize_enabled: false,
	forcePasteAsPlainText: true,
	height: 150,
	toolbar:
	[
		['Source', '-', 'Bold', 'Italic', 'FontSize', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'Image', 'Format', 'TextColor']
	]
};

var body_config = {
	resize_enabled: false,
	forcePasteAsPlainText: true,
	height: 300,
	toolbar:
	[
		['Source', '-', 'Bold', 'Italic', 'FontSize', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'Image', 'Format', 'TextColor']
	]
};

	$(".intro_editor").ckeditor(intro_config);
	$(".editor").ckeditor(body_config);
});
</script>

<form action="" method="post">

<p><span class="right">Page Slug: <span id="slug_path"><?=@$page->slug?></span></span><label for="title">Title</label></p>
<p><input type="text" class="text_big" name="array[title]" id="title" value="<?=@$page->title?>" /></p>

<h3>Meta Data</h3>

<div id="meta_data">
	<table class='table'>
		<tr>
			<th><p><label for="meta_title">Meta Title</label></p></th>
			<th><p><label for="meta_keywords">Meta Keywords</label></p></th>
			<th><p><label for="meta_description">Meta Description</label></p></th>
		</tr>
		<tr>
			<td><p><input type="text" name="array[meta_title]" class="text_box" id="meta_title" value="<?=@$page->meta_title?>" /></p></td>
			<td><p><input type="text" class="text_box" id="meta_keywords" name="array[meta_keywords]" value="<?=@$page->meta_keywords?>" /></p></td>
			<td><p><input type="text" class="text_box" id="meta_description" name="array[meta_description]" value="<?=@$page->meta_description?>" /></p></td>
		</tr>
	</table>


</div>