<?php namespace Drapor\Networking;

/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 12/29/14
 * Time: 2:57 PM
 */
use GuzzleHttp\Client;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Message\ResponseInterface;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Utils;
use Illuminate\Events\Dispatcher;
use Drapor\Networking\Traits\TimeElapsed;
use Illuminate\Queue\Queue;

class Networking
{
    use TimeElapsed;
    /**
     * @var string
     */
    public $baseUrl;

    /** @var string $method * */
    public $method;

    /** @var string  $scheme * */
    public $scheme;

    /** @var string  $proxy * */
    public $proxy;

    /** @var array  $auth**/
    public $auth;

    /** @var array  $request_headers **/
    public $request_headers;

    /** @var array  $request_cookies **/
    public $request_cookies;

    /** @var array $options  * */
    public $options;

    /** @var bool $queued  * */
    public $queued;

    /** @var $response_body array * */
    protected $response_body;

    /** @var $request_body array * */
    protected $request_body;

    /** @var $status_code Int * */
    protected $status_code;

    /** @var $response ResponseInterface * */
    protected $response;

    /** @var $responseType String  * */
    protected $responseType;

    /** @var $response_headers array * */
    protected  $response_headers;

    /** @var $request RequestInterface * */
    protected $request;

    /** @var array $cookies * */
    protected $cookies;

    /** @var CookieJar $jar * */
    protected $jar;

    /** @var string $url * */
    protected $url;

    /** @var $events Dispatcher * */
    protected $events;


    function __construct()
    {
        $this->events = app('events');
        $this->setOptions($this->getDefaultOptions());
    }

    public function getDefaultHeaders(){
        return  [
            "Cache-Control" => "no-cache",
            "Connection"    => "keep-alive",
            "Accept-Language" => "en;q=1",
            "Accept-Encoding" => "gzip, deflate",
            "Proxy-Connection" => "keep-alive"
        ];
    }

    public function getDefaultOptions(){
        return [
            'body'            => false,
            'query'           => false,
            'allow_redirects' => false,
            'auth'            => false
        ];
    }

    /**
     * If you want to encode any body or query parameters, authenticate or set
     * redirect settings then you would call this method to set
     * a new array of options before calling send()
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * Unless $fields['body'] or $fields['query'] is specified, they will not
     * be sent in the http request.
     * @param $fields
     * @param $endpoint
     * @param $method
     * @return array
     */
    public function send(array $fields, $endpoint, $method)
    {
        $this->method = $method;
        $this->setUrl($this->baseUrl . $endpoint);
        $this->setRequestBody($fields);

        if(!isset($this->queued)){
            $this->queued = false;
        }

        $sha          = sha1(serialize($fields) . time());
        $rel          = "/request/{$sha}";

        $this->syncRequest($body, $status_code, $cookie, $responseType);

        /*
          TODO : Implement this...
           if(!$this->queued){
             $this->syncRequest($body, $status_code, $cookie, $responseType);
           }else{
             $this->asyncRequest($body, $status_code, $cookie, $responseType);
            }
         */

        $response = [
            'body'         => $body,
            'status_code'  => $status_code,
            'cookie'       => $cookie,
            'responseType' => $responseType,
            'rel'          => $rel
        ];

        return $response;
    }

    /**
     * @return void
     */
    private function createRequest()
    {
        $this->setStartedAt();
        $this->setJar();
        /** @var Client $client */
        $this->finalize($client, $url, $opts, $method);

        /** $request RequestInterface * */
        $request  = $client->createRequest($method, $url, $opts);
        /** $response ResponseInterface * */
        $response = $client->send($request);

        $this->setRequestAndResponse($request, $response);
    }

    /**
     *
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function createStreamRequest()
    {
        $this->setStartedAt();
        $this->setJar();
        /** @var Client $client */
        $this->finalize($client, $url, $opts, $method);

        $req = $client->createRequest($method, $url,$opts);
        $body = json_encode($this->getRequestBody());
        $req->setBody(Stream::factory($body));
        /** $response RequestInterface * */
        $response = $client->send($req);

        return $response;
    }

    /**
     * @param array $fields
     *
     * @return array
     */
    private function configureOptions(array $fields)
    {

        $opts = [
            'headers' => $this->request_headers,
            'cookies' => $this->jar
        ];

        if (!empty($fields)) {
            $config = $this->getOptions();
            //If the request is not a stream request then set the body.
            if ($config['body']) {
                $opts['body'] = $fields;
            }
            if ($config['query']) {
                $opts['query'] = $fields;
            }
            if($config['allow_redirects']){
                $opts['allow_redirects'] = [
                    'max'       => 10,
                    'strict'    => false,
                    'referer'   => true,
                    'protocols' => ["http","https"]
                ];
            }
        }
        return $opts;
    }

    /**
     * Check for empty properties and set some sensible defaults
     *
     */
    private function configureRequest(){
        if(!isset($this->method)){
            $this->method = "get";
        }
        if(!isset($this->baseUrl)){
            $this->baseUrl = "http://httpbin.org/";
        }
        if(!isset($this->request_headers)){
            $this->request_headers = $this->getDefaultHeaders();
            if(isset($this->method) && $this->method == "post" && $this->options["query"] == false && isset($this->request_body)){
                //Assume that a post request is submitting a standard urlencoded request

                $this->request_headers["Content-Type"] = "application/x-www-form-urlencoded";
                $this->options["body"]                 = true;
            }
        }
    }

    /**
     * @return Client
     */
    private function getClient()
    {

        $defaults = array();

        if (!empty($this->proxy)) {
            $defaults['proxy'] = $this->proxy;
        }
        if (!empty($this->auth)) {
            $defaults['auth'] = $this->auth;
        }

        $guzzle = new Client([
            'base_url' => $this->url,
            'defaults' => $defaults
        ]);

        return $guzzle;
    }

    private function setJar(){
        if(!isset($this->request_cookies)){
            $jar = new CookieJar();
        }else{
            $jar = new CookieJar(false,$this->request_cookies);
        }
        $this->jar =  $jar;
    }

    private function getJar()
    {
        return $this->jar;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    private function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @param CookieJar $jar
     */
    private function setCookies(CookieJar $jar)
    {
        $jar->extractCookies($this->getRequest(), $this->getResponse());
        $this->cookies = $jar->toArray();

        $payload = [
            'status_code'           => $this->getStatusCode(),
            'response_body'         => $this->getResponseBody(),
            'request_body'          => $this->getRequestBody(),
            'url'                   => $this->getUrl(),
            'response_headers'      => $this->getResponseHeaders(),
            'request_headers'       => $this->request_headers,
            'cookies'               => $this->getCookies(),
            'time_elapsed'          => $this->getTimeElapsed(),
            'response_type'         => $this->getResponseType(),
            'method'                => $this->method,
            'multi'                 => $this->isMultiPart()
        ];

        $this->events->fire('networking.response.created', [$payload]);
    }

    /**
     * @return array
     */
    private function getOptions()
    {
        return $this->options;
    }

    /**
     * @return RequestInterface
     */
    private function getRequest()
    {
        return $this->request;
    }

    /**
     * @param RequestInterface $request
     */
    private function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }


    /**
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    private function getResponse()
    {
        return $this->response;
    }

    /**
     * Set the response & related info from the response.
     * @param ResponseInterface $response
     */
    private function setResponse(ResponseInterface $response)
    {
           $is_json = false;
        try{
            $body             = json_decode($response->getBody(),true);
            $is_json          = true;
        }catch(\InvalidArgumentException $e){
            $body = [$response->getBody()->__toString()];
        }

        //HTML/XML will always have an output.
        if((count($body) < 1) && $is_json){
            $body = [
                "message" => "No Response Received."
            ];
        }

        $status_code      = $response->getStatusCode();
        $response_headers = $response->getHeaders();

        $this->setEndedAt();
        $this->setResponseBody($body);
        $this->setResponseHeaders($response_headers);
        $this->setStatusCode($status_code);
        $this->setResponseType($is_json ? "json" : "html/xml");
        $this->response = $response;
    }

    /**
     * @return String
     */
    public function getResponseType()
    {
        return $this->responseType;
    }

    /**
     * @param String $responseType
     */
    public function setResponseType($responseType)
    {
        $this->responseType = $responseType;
    }

    /**
     * @return Int
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * @param Int $status_code
     */
    private function setStatusCode($status_code)
    {
        $this->status_code = $status_code;
    }

    /**
     * @return array
     */
    public function getResponseBody()
    {
        return $this->response_body;
    }

    /**
     * @param array $body
     */
    public function setResponseBody(array $body)
    {
        $this->response_body = $body;
    }


    /**
     * @return array
     */
    public function getRequestBody()
    {
        return $this->request_body;
    }

    /**
     * @param array $body
     */
    private function setRequestBody(array $body)
    {
        $this->request_body = $body;
    }

    /**
     * @return array
     */
    public function getResponseHeaders()
    {
        return $this->response_headers;
    }

    /**
     * @param array $response_headers
     */
    public function setResponseHeaders($response_headers)
    {
        $this->response_headers = $response_headers;
    }


    /**
     * @param $request
     * @param $response
     */
    private function setRequestAndResponse(RequestInterface $request,ResponseInterface $response)
    {
        $this->setRequest($request);
        $headers = $request->getHeaders();
        $this->request_headers = isset($headers) ? $headers : ["headers invalid" => ":("];
        $this->setResponse($response);
        $this->setCookies($this->getJar());
    }

    /**
     * @param $body
     * @param $status_code
     * @param $cookie
     * @param $responseType
     */
    private function syncRequest(&$body, &$status_code, &$cookie, &$responseType)
    {
        try {
            $this->createRequest();
        } catch (RequestException $e) {
            //If request fails we recreate the required fields from the error
            $this->setRequestAndResponse($e->getRequest(), $e->getResponse());
        }
        $body = $this->getResponseBody();
        $status_code = $this->getStatusCode();
        $cookie = $this->getCookies();
        $responseType = $this->getResponseType();
    }

    /**
     * @param $body
     * @param $status_code
     * @param $cookie
     * @param $responseType
     */
    private function asyncRequest(&$body, &$status_code, &$cookie, &$responseType)
    {
        $body = "request successfully enqueued";
        $status_code = 201;
        $cookie = [];
        $responseType = "json";

        $this->events->fire(['response.bus'], [
            'client' => $this->getClient(),
            'url' => $this->getUrl(),
            'options' => $this->configureOptions($this->getRequestBody()),
            'method' => $this->method
        ]);
    }

    /**
     * @param Client $client
     * @param string $url
     * @param array $opts
     * @param string $method
     */
    private function finalize(&$client, &$url, &$opts, &$method)
    {
        /* Do final setup before sending the request..*/
        $this->configureRequest();
        $client = $this->getClient();
        $url    = $this->getUrl();
        $opts   = $this->configureOptions($this->getRequestBody());
        $method = $this->method;
    }

    /**
     *
     * @return bool
     */
    private function isMultiPart()
    {
        if (array_key_exists('Content-Type',$this->request_headers)){
            if($this->request_headers["Content-Type"] != "multipart/form-data") {
                return false;
            }else{
                return true;
            }
        }
        return false;
    }


}
