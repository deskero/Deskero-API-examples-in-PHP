<?php
/*
	Title: create of a ticket using Deskero's API
	Author: Deskero support team, for any information or request about this code please send an email to support@deskero.com.
	Look reference of that section: http://www.deskero.com/en/documentation/api/tickets
	Request type : POST
	Request URI  : https://api.deskero.com/ticket/insert
	Headers :
		Authorization : Bearer {{bearer}}
		Content-Type : application/json
		clientId : {{clientId}}
	Example response:
		desctiption : Created ticket id
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
	//This function accepts as a parameter access token, client id, and an array of data for creation of ticket
	function ticket_create($access_token, $client_id, $ticket_data)
	{

		$chp = curl_init("https://api.deskero.com/ticket/insert");
		
		$headers = array(
			"Content-type: application/json", 
			"Authorization: Bearer " . $access_token,
			"clientId: " . $client_id
		);
		
		curl_setopt($chp, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($chp, CURLOPT_POST, 1);
		curl_setopt($chp, CURLOPT_POSTFIELDS, json_encode($ticket_data));
		curl_setopt($chp, CURLOPT_RETURNTRANSFER, true);

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

	//"This array contains the ticket's fields to create. 
	//Some fields are object please refer for example to this file detail.php to look ticket fields"
	//In array ticket_data you can see that Deskero`s API espouse transfer files not only to hex but also to base64 encryption
	$ticket_data  = array(
		'subject' => 'Ticket from API',
		'description' => 'Ticket description',
		'openedBy' => array('id' => '5458d615e4b02bed71bfb79b'),
		'type' => array('id' => '50913dd4c2e67797f82e5bb4'),
		'attachedDocuments' => array(
			array(
				'documentName'=>'doc_1.txt', 
				'documentType'=>'text/plain', 
				'documentBlob'=> $contents
			),
			array(
				'documentName'=>'doc_2.txt', 
				'documentType'=>'text/plain', 
				'documentBase64'=> $base64
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
						'documentName'=>'doc_3.txt', 
						'documentType'=>'text/plain', 
						'documentBlob'=> $contents
					),
					array(
						'documentName'=>'doc_4.txt', 
						'documentType'=>'text/plain', 
						'documentBase64'=> $base64
					)
        		)
			)
		)
	);

	//This function uses the Deskero API for creating a new ticket according to the transmitted data array, the result of the work will be the id of the newly established ticket
	$created_ticket_id = ticket_create($access_token, $client_id, $ticket_data);

	echo 'ticket_create';
	echo var_dump($created_ticket_id); 
?>