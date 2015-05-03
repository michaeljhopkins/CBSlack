<h1> Easy Networking For PHP :) </h1>


     use Drapor\Networking\Networking;

     class FooService extends Networking{

      public $baseUrl = "https://api.foo.com/v1";
      public $headers = ["authorization" => "foo:bar"];
      
      public function getBar($id, $active){
         $endpoint = "/users/{$id}";
         $type     = "get";
 
         $res = $this->send(['active' => $active],$endpoint,$type);  
      
          return $res;
         }
      }
