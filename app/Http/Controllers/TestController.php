<?php namespace CS\Http\Controllers;

use CS\Http\Requests;
use CS\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Input;

class TestController extends BaseController {

	public function get()
	{
		return view('test.get');
	}

	public function post()
	{
		$message = Input::get('message');
		\Slack::send($message);
	}

	public function heartbeat()
	{
		return \Response::make(null,200);
	}
}
