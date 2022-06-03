<?PHP
function encripta($text){
	$ci =& get_instance();
	$ci->load->library('encryption');
	return $ci->encryption->encrypt($text);
}


function desencripta($text){
	$ci =& get_instance();
	$ci->load->library('encryption');
	return $ci->encryption->decrypt($text);
}

function imp_array($data){
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	echo '<br>';
}


?>
