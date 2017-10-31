<?php
// Redirect individual post and pages to the REST API endpoint
if ( is_single() ) {
	header( 'Location: /wp-json/wp/v2/posts/' . get_post()->ID );
} elseif ( is_page() ) {
	header( 'Location: /wp-json/wp/v2/pages/' . get_queried_object()->ID );
} ?>
<!DOCTYPE html>
<html>
<head><title><?php echo $_SERVER['HTTP_HOST'] ?></title></head>
<body>
<!-- Hi, this WordPress site is headless -->
</body>
</html>
