<?php
require 'db.php';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$conn->query("UPDATE images SET like_count = like_count + 1 WHERE id=$id");
	header('Location: gallery.php');
	die();
}
?>