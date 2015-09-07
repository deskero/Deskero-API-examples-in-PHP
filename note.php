<?php
/*
	Title: adds a note for the ticket using Deskero`s API
	Author: Deskero support team, for any information or request about this code please send an email to support@deskero.com.
	Look reference of that section: http://www.deskero.com/en/documentation/api/tickets
	Request type : PUT
	Request URI  : https://api.deskero.com/ticket/addNote/{{ticketId}}
	Headers :
		Authorization : Bearer {{bearer}}
		Content-Type : application/json
		clientId : {{clientId}}
	Example response:
		description : Note id
		response 	:
			{
			  "id": "52bd6d4803647785e90abb34"
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
	//This function accepts as parameters the access token, client id, ticket id, and an array of data representing itself note
	function ticket_note($access_token, $client_id, $ticket_id, $note_data)
	{
		$chp = curl_init("https://api.deskero.com/ticket/addNote/55a8dcc6e4b0a0f49d8118ac");

		$headers = array(
			"Content-type: application/json", 
			"Authorization: Bearer " . $access_token,
			"clientId: " . $client_id
		);

		curl_setopt($chp, CURLOPT_HEADER, 0);
		curl_setopt($chp, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($chp, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($chp, CURLOPT_CUSTOMREQUEST, 'PUT'); 
		curl_setopt($chp, CURLOPT_POSTFIELDS, json_encode($note_data));	

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

	/*
	This array contains a list of options for creating a note
		Fields:
	
			field name: id			
			description: auto-generated id
	
			field name: note		
			description: note text
	
			field name: insertBy	
			description: id of agent who wrote the note
	
			field name: assignedTo	
			description: id of agent who note and reminder must be assigned
	
			field name: date		
			description: insert date
	
			field name: remindMe	
			description: reminder date and hour
	*/
	$note_data = array(
		"note" => "Ticket note from API Update",
		"insertBy" => "530d9890e4b0ae62384b4dd1",
		"assignedTo" => "530d9890e4b0ae62384b4dd1",
		"date" => "1440075185215",
		"remindMe" => "1494119700000",
	);

	//Result of the work will be the creation note for the ticket, id which has been referred to as the third argument
	$note_id = ticket_note($access_token, $client_id, $ticket_id, $note_data);

	echo 'ticket_note';
	echo var_dump($note_id);
?>