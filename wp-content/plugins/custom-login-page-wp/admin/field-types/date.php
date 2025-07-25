<?php
// {$setting_id}[$id] - Contains the setting id, this is what it will be stored in the db as.
// $class - optional class value
// $id - setting id
// $options[$id] value from the db

$option_values = array(
	'01'=>__('01-Jan','custom-login-page-wp'),
	'02'=>__('02-Feb','custom-login-page-wp'),
	'03'=>__('03-Mar','custom-login-page-wp'),
	'04'=>__('04-Apr','custom-login-page-wp'),
	'05'=>__('05-May','custom-login-page-wp'),
	'06'=>__('06-Jun','custom-login-page-wp'),
	'07'=>__('07-Jul','custom-login-page-wp'),
	'08'=>__('08-Aug','custom-login-page-wp'),
	'09'=>__('09-Sep','custom-login-page-wp'),
	'10'=>__('10-Oct','custom-login-page-wp'),
	'11'=>__('11-Nov','custom-login-page-wp'),
	'12'=>__('12-Dec','custom-login-page-wp'),
	);


echo "<select id='mm' name='{$setting_id}[$id][month]'>";
foreach ( $option_values as $k => $v ) {
    echo "<option value='$k' " . selected( $options[ $id ]['month'], $k, false ) . ">$v</option>";
}
echo "</select>";

echo "<input id='jj' class='small-text' name='{$setting_id}[$id][day]' placeholder='".__('day','custom-login-page-wp')."' type='text' value='" . esc_attr( $options[ $id ]['day'] ) . "' />";

echo ',';
echo "<input id='aa' class='small-text' name='{$setting_id}[$id][year]' placeholder='".__('year','custom-login-page-wp')."'  type='text' value='" . esc_attr( $options[ $id ]['year'] ) . "' /><br>";
