<?php
require 'db.php';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$page = $_GET['page'];

	$conn->query("UPDATE images SET like_count = like_count + 1 WHERE id=$id");
	header('Location: gallery.php?page=' . $page);
	die();
}
