<?php
session_start();
$userId = $_SESSION['userid'];
$userName = $_SESSION['username'];
$rows = "";
if (!isset($_SESSION['userid'])) {
    header('Location: index.php');
}
$tickets = simplexml_load_file("xml/ticket.xml");

foreach ($tickets as $t) {
    $rows .= "<tr>";
    $rows .= '<td>' . $t->attributes()['id'] . "" . '</td>';
    $rows .= "<td>$t->openDate</td>";
    $rows .= "<td>$t->subject</td>";
    $rows .= "<td>$t->status</td>";
    $ticketId = $t->attributes()["id"] . '';
    $rows .= "<td>
                    <a href='adminTicketDetail.php?id=$ticketId' class='btn btn-dark'>View Details</a> </td>";
    $rows .= "</tr>";
}

?>
<html lang="en">
<head>
    <title>User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<link rel="stylesheet" href="./css/style.css"/>
<body>
<?php include "header.php"; ?>
<main class="container">
    <div class="greeting">
        <h2>Welcome, <?= $userName; ?></h2>
        <a href="logout.php">Logout</a>
    </div>
    <h2 class="text-center mt-5">Your Tickets</h2>
    <table class="table table-striped table-dark">
        <thead>
        <tr>
            <th scope="col">Ticket Id</th>
            <th scope="col">Ticket Issue Date</th>
            <th scope="col">Subject</th>
            <th scope="col">Status</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?= $rows ?>
        </tbody>
    </table>
</main>
<?php include "bootstrapjs.php" ?>
<body>
</html>