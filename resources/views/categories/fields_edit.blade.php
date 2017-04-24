<?php

	for($i=1 ; $i<=$category->number_of_fields ; $i++)
	{
		$field_name_i = 'field'.$i.'_name';
		echo('
			<div class="form-group">
				<label>'.$category->$field_name_i.'</label>
				<input type="text" class="form-control" name="field'.$i.'" placeholder="'.$category->$field_name_i.'">
				<small class="help-block hide"></small>
			</div>
		');
	}
	echo('<input type="hidden" class="form-control" name="number_of_fields" value="'.$category->number_of_fields.'" id="nb_fields_add">')

?>