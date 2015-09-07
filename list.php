<?php
/*
	Title: list of a tickets using Deskero's API
	Author: Deskero support team, for any information or request about this code please send an email to support@deskero.com.
	Look reference of that section: http://www.deskero.com/en/documentation/api/tickets
	Request type : GET
	Request URI  : https://api.deskero.com/ticket/list 
	Headers :
		Authorization : Bearer {{bearer}}
		Accept 		  : application/json
		clientId 	  : {{clientId}}
	Parameters :

		field name 	: page
		field value : int value for page to show
		required 	: false
		default 	: 1

		
	Example response:
		response:
			{
			  "ticket": {
			    "totalRecords": 50,
			    "recordsPerPage": 25,
			    "previousQuery": null,
			    "nextQuery": "https://api.deskero.com/ticket/list?page=2",
			    "records": [
			      See ticket detail
			    ]
			  }
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
	//This function accepts as parameters the access token, client id, and page number for display (default is 1)
	function ticket_list($access_token, $client_id, $page = 1)
	{	
		$chp = curl_init("https://api.deskero.com/ticket/list?page=" . $page);

		$headers = array(
			"Accept: application/json", 
			"Authorization: Bearer " . $access_token,
			"clientId: " . $client_id
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

	//The result work will be an array of tickets satisfying this page
	$tickets = ticket_list($access_token, $client_id);

	echo 'ticket_list';
	echo var_dump($tickets);
?>