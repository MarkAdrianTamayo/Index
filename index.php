<?php
$name = "";
require("config.php");
while (true) {
    $name = "User" . mt_rand(1, 1000);
    if (!usernameExists($conn, $name)) break;
}
createNewUser($conn, $name);
$conn->close();

function createNewUser($conn, $username)
{
    $sql = "INSERT INTO live_location (user_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
}

function usernameExists($conn, $username)
{
    $sql = "SELECT user_id FROM live_location WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if any rows are returned
    if ($stmt->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <p id="awd">AWD</p>
    <div id="map">
        <?php require("process.php"); ?>
    </div>
</body>

</html>
<script>
    const x = document.getElementById("x");
    const y = document.getElementById("y");
    const awd = document.getElementById("awd");
    var xPos = 0;
    var yPos = 0;

    function getLocation() {
        console.log("meoww");
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        x.innerHTML = position.coords.latitude;
        y.innerHTML = position.coords.longitude;
        awd.innerHTML = position.coords.latitude + ", " + position.coords.longitude;
        xPos = position.coords.latitude;
        yPos = position.coords.longitude;
    }

    // setInterval(function() {
    //     getLocation();
    // }, 1000);
    $(document).ready(function() {
        setInterval(function() {
            // Get the value of the input field
            console.log("meow");
            getLocation();
            var x = xPos;
            var y = yPos;
            var userName = "<?php echo $name ?>";

            // Perform AJAX request
            $.ajax({
                url: 'process.php', // The PHP file that will process the data
                type: 'POST',
                data: {
                    x: x,
                    y: y,
                    userName: userName
                }, // Data to send
                success: function(response) {
                    // Handle the response from PHP
                    $('#map').html(response);
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.log("AJAX error: ", status, error);
                }
            });
        }, 1000);
    });
</script>
