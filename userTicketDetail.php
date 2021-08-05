<?php
session_start();
$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
if (!isset($_SESSION['userid'])) {
    header('Location: index.php');
}
$recTicketId = $_GET['id'];
$tickets = simplexml_load_file("xml/ticket.xml");
$users = simplexml_load_file("xml/users.xml");
$ticketId = $openDate = $category = $xmlUserId = $status = $msgList = $subject = "";
foreach ($tickets->ticket as $p) {
    $xmlTicketId = $p->attributes()['id'] . "";
    if ($recTicketId == $xmlTicketId) {
        // var_dump($p);
        $ticketId = $xmlTicketId;
        $openDate = $p->openDate;
        $category = $p->Category;
        $status = $p->status;
        $msgList = $p->ticketMessages;
        $subject = $p->subject;
    }
}

if (isset($_POST['addMessage'])) {
    if ($_POST['message'] == "" || $_POST['message'] == null) {
        $errorMsg = "Please enter a message";
    } else {
        if ($ticketId == $_POST['tId']) {
            $ticketTime = date("Y-m-d H:i:s", time());

            $message = $msgList->addChild('message', $_POST['message']);
            $message->addAttribute('userId', $userid);
            $message->addAttribute('dateTime', $ticketTime);

            $dom = dom_import_simplexml($tickets)->ownerDocument;
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->save("xml/ticket.xml");
        }

    }
}
?>
<html>
<body>
<head>
    <title>User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<link rel="stylesheet" href="./css/style.css"/>
<body>
<?php include "header.php"; ?>
<main>
    <div class="page-container">
        <div class="container">
            <div class="greeting">
                <h3>Ticket Details</h3>
                <div class="mb-4">
                    <a class="mb-2" href="user.php">Back to list</a>
                    <a class="mb-2" href="logout.php">Logout</a>
                </div>
            </div>
            <div class="jumbotron">
                <dl class="row">
                    <dt class="col-sm-3">Ticket ID:</dt>
                    <dd class="col-sm-9"><?php print $ticketId ?></dd>

                    <dt class="col-sm-3">Issue Date:</dt>
                    <dd class="col-sm-9"><?php print $openDate ?></dd>

                    <dt class="col-sm-3">Status:</dt>
                    <dd class="col-sm-9"><?php print $status ?></dd>

                    <dt class="col-sm-3">UserId:</dt>
                    <dd class="col-sm-9"><?php print $userid ?></dd>

                    <dt class="col-sm-3 text-truncate">Issue Category:</dt>
                    <dd class="col-sm-9"><?php print $subject ?></dd>

                    <dt class="col-sm-3">Messages</dt>
                    <dd class="col-sm-9" class="ticket-Msg">

                        <dl class="row">

                            <?php foreach ($msgList->message as $msg) { ?>


                                <dt class="col-sm-10">
                                    Posted:<?php print $msg->attributes()['dateTime'] . ""; ?>
                                    <b>
                                        <?php
                                        if (($msg->attributes()['userId'] == $userid)) {
                                            print("User");
                                        } else {
                                            print("Staff");
                                        }
                                        ?>
                                    </b><?php print $msg->attributes()['userId'] . ""; ?>
                                </dt>
                                <dd class="col-sm-8"><?php echo $msg; ?></dd>
                            <?php } ?>
                        </dl>

                    </dd>
                </dl>

                <form method="post">
                    <div class="col-md-6 mb-3">
                        <label for="message">Your message</label>
                        <textarea class="form-control" rows="5" name="message"
                                  placeholder="Here you can enter additional messages for the staff."></textarea>
                    </div>
                    <input type="hidden" name="tId" value="<?php echo $ticketId; ?>">
                    <p class="text-danger"><?= isset($errorMsg) ? $errorMsg : ""; ?></p>
                    <input class="btn btn-primary" type="submit" name="addMessage" value="Add Message" role="button"/>
                </form>
            </div>
        </div>
    </div>
</main>
<?php include "bootstrapjs.php" ?>
</body>
</html>
