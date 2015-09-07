<?php
/*	
	Title: obtaining Access Token using Deskero API
	Author: Deskero support team, for any information or request about this code please send an email to support@deskero.com.
	Look reference of that section: http://www.deskero.com/en/documentation/api/authentication
	Request type : GET
	Request URI  : https://api.deskero.com/oauth/token?grant_type=client_credentials
	Headers :
		Authorization : Basic {{apiToken}}
	Parameters :

			field name 	: grant_type
			field value : client_credentials
			required 	: true
			default 	:
			
	Exemple response:
		response:
			{
			  "access_token": "58cfg61g-1585-5c72-g35f-7fe76893ed2f",
			  "token_type": "bearer",
			  "expires_in": 1398616,
			  "scope": "trust write read"
			}
		the possible response codes:

			HTTP Code 	: 200 OK
			Description : Operation completed
			Calls 		: List, Search, Detail, Update, Delete, Reply

			HTTP Code 	: 201 CREATED
			Description : Element successfully inserted
			Calls 		: Create

			HTTP Code 	: 204 NO CONTENT
			Description : No elements retrieved with a list, search or detail call
			Calls 		: List, Search, Detail

			HTTP Code 	: 400 BAD REQUEST
			Description : Validation error or field name mismatch
			Calls 		: All

			HTTP Code 	: 500 INTERNAL SERVER ERROR
			Description : An internal exception does not allow to complete the requested operation
			Calls 		: All
*/

	//This function accepts as a parameter Authorized API Token, for more details look http://www.deskero.com/en/documentation/api/configuration
	function auth($auth_token)
	{
		$chp = curl_init("https://api.deskero.com/oauth/token?grant_type=client_credentials");

		$headers = array(
			"Accept: application/json", 
			"Authorization: Basic " . $auth_token
		);

		curl_setopt($chp, CURLOPT_HEADER, 0);
		curl_setopt($chp, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($chp, CURLOPT_HTTPHEADER, $headers);

		$result=curl_exec($chp);

		$info = curl_getinfo($chp);
		if(curl_errno($chp))
		{
		    echo 'error:' . curl_error($chp);
		}
		else if (!in_array($info['http_code'], array(200, 201, 204)))
		{
			echo 'error: response code ' . $info['http_code'];
		}

		curl_close($chp);

		return json_decode($result, true);
	}

	//your client id (см. http://www.deskero.com/en/documentation/api/configuration)
	$client_id = "530d9890e4b0ae62384b4dd4";
	//your Authorized API Token (см. http://www.deskero.com/en/documentation/api/configuration)
	$authorized_token  = "NTMwZDk4OTBlNGIwYWU2MjM4NGI0ZGQ0OmJkOWE5YTU1LTZjMGItNDY5YS04MTA1LTQ1ZDM0ZTYyNGJlZg==";
	//function call with the transfer Authorized API Token, result of the work will be the answer to the access token, which we use for the commission of any other API call`s
	$access_token = auth($authorized_token);
	
	echo 'auth';
	echo var_dump($access_token);
?>