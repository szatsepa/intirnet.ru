<?php 

// Есть ли дополнительный параметр в URL?

$url_add = '';

if (isset($attributes["choose"])) {

	$url_add = '&amp;choose='.$attributes["choose"];

}

?>

	<p class="box"><a href="#" class="btn-info"><span>Теги</span></a><a href="#" class="btn-info"><span>Алфавит</span></a><a href="#" class="btn-info"><span>Все</span></a></p>

<!-- Upload -->
<!--<fieldset id="fieldset_filter_tags" style="display:none;">
	<legend>Теги</legend>
    <?php include ("dsp_users_tagscloud.php");?>
</fieldset>-->

<!-- Upload -->
<!--<fieldset id="fieldset_filter_alphabet" style="display:none;">
	<legend>Алфавит</legend>
    <?php  include ("dsp_users_alphabet.php");?>
</fieldset>-->
