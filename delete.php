<?php
/*
	Title: delete of a ticket using Deskero's API
	Author: Deskero support team, for any information or request about this code please send an email to support@deskero.com.
	Look reference of that section: http://www.deskero.com/en/documentation/api/tickets
	Request type : DELETE
	Request URI  : https://api.deskero.com/ticket/delete/{{ticketId}}
	Headers :
		Authorization : Bearer {{bearer}}
		Content-Type : application/json
		clientId : {{clientId}}
	Example response:
		desctiption : Deleted ticket id
		response 	:
			{
			  "id": "5277c21ce4b0d3bd74d43841"
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
	//This function accepts as parameters the access token, client id, and ticket id
	function ticket_delete($access_token, $client_id, $ticket_id)
	{
		$chp = curl_init("https://api.deskero.com/ticket/delete/" . $ticket_id);

		$headers = array(
			"Content-type: application/json", 
			"Authorization: Bearer " . $access_token,
			"clientId: " . $client_id
		);

		curl_setopt($chp, CURLOPT_HEADER, 0);
		curl_setopt($chp, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($chp, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($chp, CURLOPT_CUSTOMREQUEST, 'DELETE'); 

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

	//Calling this function will lead to delete ticket, id which has been referred to as the third parameter
	$deleted_ticket_id = ticket_delete($access_token, $client_id, $ticket_id);

	echo 'ticket_delete';
	echo var_dump($deleted_ticket_id);
?>