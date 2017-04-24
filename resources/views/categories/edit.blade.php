<div id=wrap1>

	<div class="form-group">
        <label class="control-label">Category name</label>
        <input type="text" class="form-control" name="category_name" value="{{ $category->category_name }}">
    </div>

    <div class="form-group">
        <label class="control-label">Parents</label>
       	<input type="text" class="form-control" name="parents" value="{{ $category->parents }}">
    </div>

</div>


<div id=wrap2>
	<div class="form-group" id="fields_edit">
		<label class="control-label">Fields</label>
	    <?php
	    	for($i = 1; $i <= $category->number_of_fields; $i++)
	    	{
	    		$prop = 'field'.$i.'_name';
	    		echo('<input type="text" class="form-control" name="field'.$i.'_name" placeholder="field'.$i.'" id="field'.$i.'_edit" value="'.$category->$prop.'"><small class="help-block" id="small'.$i.'_edit"></small>');
	    	}
	    ?>

	</div>

	<input type="hidden" class="form-control" name="number_of_fields" value="{{ $category->number_of_fields }}" id="nb_fields_edit">
	
</div>
