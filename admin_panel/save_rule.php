<?php
include("includes/connection.php");

$competition_id = $_POST['competition_id'];
$rule_text = mysqli_real_escape_string($con, $_POST['rule_text']);

mysqli_query($con, "INSERT INTO competition_rules (competition_id, rule_text) VALUES ($competition_id, '$rule_text')");

header("Location: manage_rules.php?competition_id=$competition_id");
?>