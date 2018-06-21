/**
 * Description of UrlAmigavel
 * @author Egberto/Rodrigo
 */
class base64_helper {

   public function base64url_encode($data) {
      return rtrim(strtr(base64_encode(trim($data)), '+/', '-_'), '=');
  }


  public function base64url_decode($data) {
      return base64_decode(str_pad(strtr(trim($data), '-_', '+/'), strlen(trim($data)) % 4, '=', STR_PAD_RIGHT));
  } 


}
