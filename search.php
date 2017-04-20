<div class="col-lg-12">
  <?
		$json_detail = json_decode($_POST['search_results']);
	?>
	<ul id="item_search_container">
		<?
		foreach ($json_detail as $value) {
			echo '<a onclick="detail('.$value->id.','.$value->latitude.','.$value->longitude.')" class="item-search-click" ><li class="item_search"><div class="image_item_search_container"><img src="'.$value->image.'" /></div><ul class="item_search_child_container"><li class="name_section">'. $value->nama .'</li><li class="harga_section">'. $value->harga .'</li><li class="kabupaten_section">'. $value->nama_kabupaten .'</li></ul></li></a>';
		}
		?>
	</ul>
	<button class="btn btn-warning" onclick="cancel()">Selesai</button>
</div>
