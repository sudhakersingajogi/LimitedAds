
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('generateEmailConfirmationCode'))
{
function generateEmailConfirmationCode() {
	
  $chars = 'abcdefghijklmnopqrstuvwxyz*ABCDEFGHI*.JKLMNOPQRSTUVWXYZ0123456789';
  $code = '';
 
  for ($i = 0; $i < 20; $i++) {
    $code .= $chars[ rand( 0, strlen( $chars ) - 1 ) ];
  }
  return md5($code);
}
}
?>