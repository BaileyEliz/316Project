<html>
<head><title>Request</title></head>
<body>
<h1>Request Success!</h1>

Thank you, <?php echo $_POST["name"]; ?>, your request has been submitted.<br><br>

<a href="javascript:history.go(-1)">Go back</a><br>
<a href="index.php">Back to home</a>

<!-- can implement later to use history.go when request fails due to some constraint violation or use index.php if the request succeeds -->
<!-- or will likely use form vaildation to ensure it doesn't fail, but on the off chance it does, the go back link can still be present -->

</body>
</html>