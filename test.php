<?php
$xml = simplexml_load_file("xml/ticket.xml");

$ticketTime = date("Y-m-d H:i:s", time());

$selectedTicket= $xml->xpath("/tickets/ticket[@id='1345']");
var_dump($selectedTicket->ticketMessages);
$ticketMsg = $selectedTicket->ticketMessages;
$message = $ticketMsg->addChild('message','hi');
$message->addAttribute('userId','102');
$message->addAttribute('dateTime',$ticketTime);

$dom = dom_import_simplexml($xml)->ownerDocument;
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->save("xml/ticket.xml");
//foreach ($xml->children() as $t)
//{
//    $rows .="<tr>";
//    $rows .='<td>'.$t->attributes()['id']."".'</td>';
//    $rows .= "<td>$t->openDate</td>";
//    $rows .= "<td>$t->subject</td>";
//    $rows .= "<td>$t->status</td>";
//    $ticket = $t->ticketMessages;
//    foreach ($ticket->message as $tm)
//    {
//        $ul .="<li>".($tm)->attributes()['userId']."</li>";
//        $ul .= "<li>".($tm)."</li>";
//    }
//    $rows .= "<td><ul>$ul</ul></td>";
//    $rows .="<td></td>";
//    $rows .="<td>$t->category</td>";
//    $ul = "";
//}

?>
<html>
<table border="1" width="100%">
<tr>
    <th>Role</th>
    <th>Name</th>
</tr>
<?php print($rows);?>
</table>
</html>
