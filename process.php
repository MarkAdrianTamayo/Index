<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userName = isset($_POST['userName']) ? $_POST['userName'] : '';
    $x = isset($_POST['x']) ? $_POST['x'] : "";
    $y = isset($_POST['y']) ? $_POST['y'] : "";
    require("config.php");
    $stmt = $conn->prepare("UPDATE live_location SET x = ?, y = ? WHERE user_name = ?");
    $stmt->bind_param("dds", $x, $y, $userName);

    if ($stmt->execute()) {
        // echo "Record updated successfully $x, $y, $userName";
    } else {
        echo "Error: " . $stmt->error;
    }
    $sql = "SELECT * FROM live_location WHERE user_name != '$userName'";
    $result = $conn->query($sql);

    // Check if there are results and display them
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $xPos = (($row['x']-$x)*1000)+250;
            $yPos = (($row['y']-$y)*1000)+250;
?>
            <span class="labels" style="left: <?php echo $xPos ?>px; top: <?php echo $yPos ?>px"><?php echo $row['user_name'] ?></span>
            <div class="users" style="left: <?php echo $xPos ?>px; top: <?php echo $yPos ?>px"></div>
<?php
        }
    }
}
?>
<span id="user-label" class="labels"><?php echo "YOU"//empty($userName) ? $name : $userName ?></span>
<div id="user" class="users"></div>
<div id="loc">
    <p><span>Latitude: </span><span id="x"><?php echo empty($userName) ? "" : $x ?></span></p>
    <p><span>Longitude: </span><span id="y"><?php echo empty($userName) ? "" : $y ?></span></p>
</div>