<?php
defined('BASEPATH') or exit('No direct script access allowed');

// use Yabacon\Paystack;
#[\AllowDynamicProperties]
class My_paystack_lib
{

	private $secert_key = null;
	protected $paystack;
	public function __construct()
	{
		$this->secret_key = "sk_test_95663f53a5793a65c283396ed0f6ceb69b0a63a6";
	}


	/*** start customer ***/
	public function create_customer($email, $name)
	{
		$url = "https://api.paystack.co/customer";

		$fields = [
			"email" => $email,
			"first_name" => $name,

		];

		$fields_string = http_build_query($fields);

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Authorization: Bearer " . $this->secret_key,
			"Cache-Control: no-cache",
		));

		//So that curl_exec returns the contents of the cURL; rather than echoing it
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		//execute post
		$result = curl_exec($ch);
		return $result;
	}

	function fetch_customer($customer_code)
	{
		// pr($customer_code);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.paystack.co/customer/" . $customer_code,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer " . $this->secret_key,
				"Cache-Control: no-cache",
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			return "cURL Error #:" . $err;
		} else {
			return $response;
		}
	}

	function create_plan($plan_name)
	{
		$url = "https://api.paystack.co/plan";

		$fields = [
			'name' => "Monthly retainer",
			'interval' => "monthly",
			'amount' => "500000"
		];

		$fields_string = http_build_query($fields);

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Authorization: Bearer SECRET_KEY",
			"Cache-Control: no-cache",
		));

		//So that curl_exec returns the contents of the cURL; rather than echoing it
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		//execute post
		$result = curl_exec($ch);
		echo $result;
	}
}
