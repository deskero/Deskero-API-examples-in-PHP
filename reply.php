<?php
/*
	Title: adds a reply for the ticket using Deskero`s API
	Author: Deskero support team, for any information or request about this code please send an email to support@deskero.com.
	Look reference of that section: http://www.deskero.com/en/documentation/api/tickets
	Request type : PUT
	Request URI  : https://api.deskero.com/ticket/reply/{{ticketId}}
	Headers :
		Authorization : Bearer {{bearer}}
		Content-Type : application/json
		clientId : {{clientId}}
	Example response:
		description : Reply id
		response 	: 
			{
			  "id": "51e56642e4b0f36e576a8f74"
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
	//This function accepts as parameters the access token, client id, ticket id, and an array of data representing itself reply
	function ticket_reply($access_token, $client_id, $ticket_id, $reply_data)
	{
		$chp = curl_init("https://api.deskero.com/ticket/reply/" . $ticket_id);

		$headers = array(
			"Content-type: application/json", 
			"Authorization: Bearer " . $access_token,
			"clientId: " . $client_id
		);

		curl_setopt($chp, CURLOPT_HEADER, 0);
		curl_setopt($chp, CURLOPT_RETURNTRANSFER, 0);
		curl_setopt($chp, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($chp, CURLOPT_CUSTOMREQUEST, "PUT"); 
		curl_setopt($chp, CURLOPT_POSTFIELDS, json_encode($reply_data));

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

	/*
		This array contains a list of options for creating a note
		Fields:
			field name: text				
			description: reply text
	
			field name: replyDate			
			description: reply date timestamp
	
			field name: replyFromCustomer	
			description: customer who reply, see customer detail
	
			field name: replyToCustomer		
			description: customer who replied by agent, see customer detail
	
			field name: replyFromOperator	
			description: agent who reply, see agent detail
	
			field name: replyToOperator		
			description: agent who replied by customer, see agent detail
	
			field name: attachedDocuments	
			description: attached files, see attached document detail
	
			field name: tweetId				
			description: tweet id, if reply comes from twitter
	
			field name: tweetType			
			description: mention or direct message
	
			field name: facebookId			
			description: post id, if reply comes from facebook
	
			field name: facebookType		
			description: post or private message
	
			field name: linkedinId			
			description: feed id, if reply comes from linkedin
	
			field name: linkedinType		
			description: ?
	
			field name: googlePlusId		
			description: activity id, if reply comes from google plus
	
			field name: googlePlusType		
			description: ?
	
			field name: youtubeId			
			description: video id, if reply comes from youtube
	
			field name: youtubeType			
			description: ?
	
			field name: messageUniqueId		
			description: mail unique id, if reply comes from email
	*/
	$reply_data = array(
		'text' => 'Problem solved!!!', 
		'replyFromOperator' => array('id' => '530d9890e4b0ae62384b4dd1'),
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
	);
	//Result of the work will be the creation reply for the the ticket, id which has been referred to as the third argument
	$reply_id = ticket_reply($access_token, $client_id, $ticket_id, $reply_data);

	echo 'ticket_reply';
	echo var_dump($reply_id);
?>