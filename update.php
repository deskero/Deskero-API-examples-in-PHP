<?php
/*
	Title: update of a ticket using Deskero's API
	Author: Deskero support team, for any information or request about this code please send an email to support@deskero.com.
	Look reference of that section: http://www.deskero.com/en/documentation/api/tickets
	Request type : PUT
	Request URI  : https://api.deskero.com/ticket/update/{{ticketId}}
	Headers :
		Authorization : Bearer {{bearer}}
		Content-Type : application/json
		clientId : {{clientId}}
	Example response:
		description : Updated ticket id
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
	//This function accepts as a parameter access token, client id, ticket id, and an array of data for updating ticket
	function ticket_update($access_token, $client_id, $ticket_id, $ticket_data)
	{
		$chp = curl_init("https://api.deskero.com/ticket/update/" . $ticket_id);

		$headers = array(
			"Content-type: application/json", 
			"Authorization: Bearer " . $access_token,
			"clientId: " . $client_id
		);

		curl_setopt($chp, CURLOPT_HEADER, 0);
		curl_setopt($chp, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($chp, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($chp, CURLOPT_CUSTOMREQUEST, 'PUT'); 
		curl_setopt($chp, CURLOPT_POSTFIELDS, json_encode($ticket_data));

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

	//this block of code read file and present it as base64
	$file_data = file_get_contents("/path/to/file");
	$base64 = base64_encode($file_data);

	//this block of code read file and present it as hex
	$filename = "path_to_your_file";
	$handle = fopen($filename, "rb");
	$hex = bin2hex( fread( $handle, filesize($filename) ) );
	fclose($handle);

	//See create.php for fields which can use
	//In array ticket_data you can see that Deskero`s API espouse transfer files not only to hex but also to base64 encryption
	$ticket_data  = array(
		'subject' => 'Ticket from API Update',
		'description' => 'Ticket description update',
		'openedBy' => array('id' => '5458d615e4b02bed71bfb79b'),
		'type' => array('id' => '50913dd4c2e67797f82e5bb4'),
		'attachedDocuments' => array(
				array(
        			"documentName" => "doc.txt",
        			"documentType" => "text/plain",
        		    "documentBlob"=> $hex
				)
		)
		'replies' => array(
			array(
				"text" => "Problem solved!",
        		"replyDate" => "1382455565000",
        		"replyFromOperator"=> array(
        		  "id" => "530d9890e4b0ae62384b4dd1"
        		),
        		"attachedDocuments"=> array(
        		  	array(
        		    	"documentName"=> "doc.txt",
        		    	"documentType"=> "text/plain",
        		    	"documentBase64" => $base64
        		  	)
        		)
			)
		)
	);

	//Calling this function will update only those fields, which have been transferred from array $ ticket_data, for the ticket, id which has been referred to as the third argument
	$ticket_update = ticket_update($access_token, $client_id, $ticket_id, $ticket_data);

	echo 'ticket_update';
	echo var_dump($ticket_update);
?>