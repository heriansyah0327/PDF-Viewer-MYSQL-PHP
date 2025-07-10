<?php
$conn = new mysqli("localhost", "xheriansyah_kokoko", "JJTF9wBmcfGyS5w3t2DZ", "xheriansyah_kokoko");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
