<?php
/*
	Title: show of a ticket using Deskero's API
	Author: Deskero support team, for any information or request about this code please send an email to support@deskero.com.
	Look reference of that section: http://www.deskero.com/en/documentation/api/tickets
	Request type : GET
	Request URI  : https://api.deskero.com/ticket/{{ticketId}}
	Headers :
		Authorization : Bearer {{bearer}}
		Accept 		  : application/json
		clientId 	  : {{clientId}}
	Example response:
		response:
			{
				"id": "5277c21ce4b0d3bd74d43841",
				"number": "2015/2013",
				"subject": "Problem with on-line order!",
				"description": "Hello, I've just ordered from your on-line catalogue the complete hardback collection on Little Nemo in Slumberland, by Winsor McCay. Despite being available on your inventory, I keep getting an \"item not found\" error, and can't complete my order. Is there something you can do?",
				"insertDate": 1383580226312,
				"managedDate": 1383580226397,
				"closedDate": null,
				"priority": 0,
				"assignedTo": {
				  See agent detail
				},
				"cc": [],
				"openedBy": {
				  See customer detail
				},
				"numberOfReplies": 1,
				"replies": [
				  See reply detail
				],
				"tags": [
				  See tag detail
				],
				"attachedDocuments": [
				  See attached document detail
				],
				"status": {
				  See ticket status detail
				},
				"type": {
				  See ticket type detail
				},
				"area": {
				  See ticket area detail
				},
				"group": {
				  See ticket group detail
				},
				"memo": null,
				"source": {
				  See ticket source detail
				},
				"customFields": [
				  See custom field detail
				],
				"ticketNotes": [
				  See ticket note detail
				],
		  		"tweetId": null,
		  		"tweetType": null,
		  		"facebookId": null,
		  		"facebookType": null,
		  		"linkedinId": null,
		  		"linkedinType": null,
		  		"googlePlusId": null,
		  		"googlePlusType": null,
		  		"youtubeId": null,
		  		"youtubeType": null,
		  		"messageUniqueId": null,
		  		"customPortalId": null,
		  		"toReply": false,
		  		"toReplyCustomer": false
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
	function ticket_detail($access_token, $client_id, $ticket_id)
	{
		$chp = curl_init("https://api.deskero.com/ticket/" . $ticket_id);

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

	$ticket_id = '55d7292ae4b00f2507dfd78b'; //You can find the ticket id using the ticket list or ticket seach API, see also list.php or search.php

	//Result of the work this function will be detailed information about that ticket, id which transferred as the third parameter $ ticket_id
	$ticket_detail = ticket_detail($access_token, $client_id, $ticket_id);

	echo 'ticket_detail';
	echo var_dump($ticket_detail);
?>