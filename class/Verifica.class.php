<?php

if (empty($_SESSION['kt_login_id'])) {
	return false;
} else {
	return true;
}

?>