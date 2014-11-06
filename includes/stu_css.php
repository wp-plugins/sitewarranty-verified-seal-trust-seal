<h2>
	Woocommerce CSS-Editor 
</h2>
<?php
ob_start();
$url = get_admin_url();
$file = dirname(__FILE__).'/css/stu_style.css';

// check if form has been submitted
if (isset($_POST['text']))
{
	
	$stringData = $_POST['text'];
	$fh = fopen($file, 'w');
	fwrite($fh, $stringData);
	fclose($fh);   
	
}

// read the textfile
if(!file_exists($file))
{
	echo "No file found.";
	exit;
}
$text = file_get_contents($file);

?>
<!-- HTML form -->
<form action="" method="post">
<textarea name="text" id="edit-css"  rows="30" cols="50" ><?php echo htmlspecialchars($text) ?></textarea>
<br />
<p><input type="submit" class="button button-primary" value="Update"/></p>
</form>