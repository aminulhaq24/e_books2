<?php
include("includes/connection.php");

$rule_id = $_POST['rule_id'];
$competition_id = $_POST['competition_id'];
$rule_text = mysqli_real_escape_string($con, $_POST['rule_text']);

mysqli_query($con, "UPDATE competition_rules SET rule_text = '$rule_text' WHERE id = $rule_id");

header("Location: manage_rules.php?competition_id=$competition_id");
?>