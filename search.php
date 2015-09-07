<?php
/*
	Title: search tikets by fields, using Deskero`s API
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
	
		field name 	: {{fieldName}}
		field value : a value to search
		required 	: false
		default 	:
	Example response:
		response:
			{
			  "ticket": {
			    "totalRecords": 4,
			    "recordsPerPage": 25,
			    "previousQuery": null,
			    "nextQuery": null,
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
			
	Fields:

		field name	: id
		description : auto-generated ticket id

		field name	: number
		description : auto-generated ticket number, number/year

		field name	: subject
		description : subject

		field name	: description
		description : complete text

		field name	: insertDate
		description : insert date timestamp

		field name	: managedDate
		description : last edit/reply/change status date timestamp

		field name	: closedDate
		description : close date timestamp

		field name	: priority
		description : int priority value, 0 or 1

		field name	: assignedTo
		description : agent who ticket must be assigned, see agent detail

		field name	: cc
		description : list of cc agent, see agent detail

		field name	: openedBy
		description : customer who opened the ticket, see customer detail

		field name	: numberOfReplies
		description : int replies number

		field name	: replies
		description : list of replies, see reply detail

		field name	: tags
		description : list of tags, see tag detail

		field name	: attachedDocuments
		description : list of attached documents, see attached document detail

		field name	: status
		description : ticket status (opened, closed, on hold, solved), see status detail

		field name	: type
		description : ticket type, see ticket type detail

		field name	: area
		description : ticket area, see ticket area detail

		field name	: group
		description : ticket group, see ticket group detail

		field name	: source
		description : ticket source, see source detail

		field name	: memo
		description : text note

		field name	: customFields
		description : list of custom fields, see custom field detail

		field name	: tweetId
		description : tweet id, if reply comes from twitter

		field name	: tweetType
		description : mention or direct message

		field name	: facebookId
		description : post id, if reply comes from facebook

		field name	: facebookType
		description : post or private message

		field name	: linkedinId	
		description : feed id, if reply comes from linkedin

		field name	: linkedinType	
		description : ?

		field name	: googlePlusId	
		description : activity id, if reply comes from google plus

		field name	: googlePlusType	
		description : ?

		field name	: youtubeId	
		description : video id, if reply comes from youtube

		field name	: youtubeType	
		description : ?

		field name	: messageUniqueId	
		description : mail unique id, if reply comes from email

		field name	: customPortalId	
		description : id of custom portal

		field name	: toReply	
		description : agent have to reply to this ticket

		field name	: toReplyCustomer	
		description : customer have to reply to this ticket

*/
	//This function accepts as parameters the access token, client id, ticket id, and an array of fields to perform the search
	function ticket_search($access_token, $client_id, $fields)
	{
		$query = "?";

		foreach($fields as $field_name => $value_to_search)
		{
			$query = $query . $field_name . '._' . $value_to_search . '&';
		}

		$chp = curl_init("https://api.deskero.com/ticket/list" . $query);

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
	//See the beginning of the file for all possible fields
	$fields = array('openedBy' => 'id=5458d615e4b02bed71bfb79b');

	//The result work will be an array of tickets matching search criteria
	$searched_tickets = ticket_search($access_token, $client_id, $fields);

	echo 'ticket_search';
	echo var_dump($searched_tickets);
?>