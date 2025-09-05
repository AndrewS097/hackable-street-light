<?php
// arduino_control.php

// Map button names to sketch directories
$sketches = [
    "blink" => "/home/pi/arduino_projects/blink",
    "servo" => "/home/pi/arduino_projects/servo",
    "traffic" => "/home/pi/arduino_projects/traffic_light"
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $choice = $_POST['sketch'];

    if (array_key_exists($choice, $sketches)) {
        $sketchPath = $sketches[$choice];

        // Compile + upload with Arduino CLI
        $cmd = "arduino-cli compile --fqbn arduino:avr:uno $sketchPath && arduino-cli upload -p /dev/ttyACM0 --fqbn arduino:avr:uno $sketchPath 2>&1";

        exec($cmd, $output, $status);

        echo "<h2>Result for $choice:</h2>";
        echo "<pre>" . implode("\n", $output) . "</pre>";

        if ($status === 0) {
            echo "<p><strong>✅ Upload successful!</strong></p>";
        } else {
            echo "<p><strong>❌ Upload failed!</strong></p>";
        }
    } else {
        echo "<p><strong>Invalid choice.</strong></p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Arduino Control Panel</title>
</head>
<body>
    <h1>Upload a Sketch to Arduino</h1>
    <form method="POST">
        <button type="submit" name="sketch" value="blink">Run Blink</button>
        <button type="submit" name="sketch" value="servo">Run Servo</button>
        <button type="submit" name="sketch" value="traffic">Run Traffic Light</button>
    </form>
</body>
</html>
