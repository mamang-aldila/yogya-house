<div class="col-lg-12">
  <?
		$json_detail = json_decode($_POST['search_results']);
	?>
	<ul id="item_search_container">
		<?
		foreach ($json_detail as $value) {
			echo '<li class="item_search"><ul><li class="name_section">'. $value->nama .'</li><li class="harga_section">'. $value->harga .'</li><li class="kabupaten_section">'. $value->nama_kabupaten .'</li></ul></li>';
		}
		?>
	</ul>
	<button class="btn btn-warning" onclick="cancel()">Selesai</button>
</div>
