<?php

/**
* Add to array if value does not exist
*/
function seed_cl_array_add($arr, $key, $value){
    if (!array_key_exists($key, $arr)) {

        $arr[$key] = $value;
    }
    return $arr;
}



function seed_cl_select($id,$option_values,$selected = null){
echo "<select id='$id' name='$id' class='form-control input-sm'>";
if(!empty($option_values)){
foreach ( $option_values as $k => $v ) {
	if(is_array($v)){
		echo '<optgroup label="'.ucwords($k).'">';
		foreach ( $v as $k1=>$v1 ) {
			echo '<option value="'.$k1.'"' . selected( $selected , $k1, false ) . ">$v1</option>";
		}
		echo '</optgroup>';
	}else{
			if(!isset($options[ $id ])){
				$options[ $id ] = '';
			}
    		echo "<option value='$k' " . selected( $selected , $k, false ) . ">$v</option>";
	}
}
}
echo "</select> ";
}



