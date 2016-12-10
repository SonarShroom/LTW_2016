<?php

//codigo de ativaçao
function activation_code($code) {
	$dbh = new PDO('sqlite:rest.db');
	$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->prepare("SELECT code from user WHERE code=?");
	$stmt->execute(array($code));
	$duplicate = $stmt->fetchAll();
	return count($duplicate);
}
	//recovery code, ver de onde vem =====================================================
function recovery_code($code) {
	$dbh = new PDO('sqlite:rest.db');
	$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->prepare("SELECT code from pass_recovery WHERE code=?");
	$stmt->execute(array($code));
	$duplicate = $stmt->fetchAll();
	return count($duplicate);
}
 
?>