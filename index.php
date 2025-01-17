<?php
include("config.php");
include("reactions.php");
$getReactions = Reactions::getReactions();
// $sql = "DELETE FROM reactions";
// if ($con->query($sql) === TRUE) {
//     echo "<p style='color: green;'>Alle reacties zijn succesvol verwijderd.</p>";
// } else {
//     echo "<p style='color: red;'>Fout bij het verwijderen: " . $con->error . "</p>";
// }
//uncomment de volgende regel om te kijken hoe de array van je reactions eruit ziet
// echo "<pre>".var_dump($getReactions)."</pre>";

if (!empty($_GET)) {

    //dit is een voorbeeld array.  Deze waardes moeten erin staan.
    $postArray = [
        'name' => $_GET['name'],
        'email' => $_GET['email'],
        'message' => $_GET['message'],
    ];

    $setReaction = Reactions::setReaction($postArray);

    if (isset($setReaction['error']) && $setReaction['error'] != '') {
        prettyDump($setReaction['error']);
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youtube remake</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/OpJdQYKsuJE?list=RDHBH0473BYLk&index=19"
        title="YouTube video player" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    <form action="">
        <label for="name">Naam:</label>
        <input type="text" id="name" name="name" value="">
        <label for="email">e-mail:</label>
        <input type="text" id="email" name="email" value="">
        <label for="Comment">Comment:</label>
        <textarea id="message" name="message" value=""></textarea>
        <input type="submit" value="submit">
    </form>
    <?php

    $gevondenReactions = Reactions::getReactions();

    for ($i = 0; $i < count($gevondenReactions); $i++) {
        $reaction = $gevondenReactions[$i];
        echo '<p><strong>Name: </strong> ' . htmlspecialchars($reaction['name']) . '</p>';
        echo '<p><strong>Email: </strong> ' . htmlspecialchars($reaction['email']) . '</p>';
        echo '<p><strong>Comment: </strong> ' . htmlspecialchars($reaction['message']) . '</p>';
    }
    ?>
    </body>

</html>

<?php
$con->close();
?>