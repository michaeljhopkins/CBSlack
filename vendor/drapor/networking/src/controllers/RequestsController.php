<?php namespace Drapor\Networking\Controllers;
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 1/11/15
 * Time: 2:53 PM
 */

use Drapor\Networking\Models\Request;
use Drapor\Networking\Networking;
use \Illuminate\Routing\Controller;
use View;

class RequestsController extends Controller{


    protected $request;
    protected $view;
    protected $networking;

    public function __construct(Request $request, View $view, Networking $networking){
        $this->request    = $request;
        $this->view       = app("view");
        $this->input      = app("request");
        $this->networking = $networking;
    }

    public function index(){
        $requests = $this->request->orderBy('created_at', 'DESC')->paginate(20);

        $view['requests'] = $requests;

        return $this->view->make('networking::logs.index',$view);
    }

    public function store(){
        $request  = $this->input;

        $fields   = array();
        $endpoint = $request->has("endpoint") ? $request->get("endpoint") : "/";
        $method   = $request->get("method");

        $this->networking->baseUrl = $this->input->get("url");
        $this->networking->scheme  = "https";

        If($request->has("proxy")){
            $this->networking->proxy = $request->input("proxy");
        }

        if($request->has("headers") && count($request->get("headers")) >= 1){
            $this->networking->request_headers = $request->get("headers");
        }else{
            $this->networking->request_headers = $this->networking->getDefaultHeaders();
        }

        if($request->has("body") && count($request->get("body")) >= 1){
            $fields = $request->get("body");
        }

       $response =  $this->networking->send($fields,$endpoint,$method);

       return $response;
    }
}