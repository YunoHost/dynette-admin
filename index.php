<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    set_time_limit(30);
    $domain = escapeshellarg($_POST["domain"]);
    exec("curl -X DELETE dyndns.yunohost.org/domains/".$domain, $result, $result_code);
    $deleted = $result[0] == "\"OK\"";
}
?>
<html>
<head>
<title>Dynette</title>
<meta charset="UTF-8">
<script type="text/javascript" src="vendor/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="jquery.dynatable.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="jquery.dynatable.css"> 
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> 
<script type="text/javascript">
$( document ).ready(function() {
    $('#table').dynatable({
        dataset: {
            records: JSON.parse($('#domains').text())
        }
    });
});
</script>
</head>

<body>
<div class="container">

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>

<br>
<div class="alert alert-<?php echo $deleted ? "success": "danger" ?>" role="alert">
<?php echo $deleted ? "Domain successfully deleted: ".$domain : "An error occured on domain deletion: ".$domain ?>
</div>

<?php } ?>

<h2>Dynette domains : <small><?php passthru("curl dyndns.yunohost.org/domains"); ?></small></h2>
<table class="table table-striped" id="table">
  <thead style="background: #428bca">
    <th style="color: #428bca">id</th>
    <th>subdomain</th>
 <!--   <th>initial_ip</th> -->
    <th>created_at</th>
  </thead>
  <tbody>
  </tbody>
</table>
<script id="domains">
<?php passthru("curl dyndns.yunohost.org/all"); ?>
</script>
<br>
<hr>
<br>
<h2>Delete a domain</h2>
<form action="index.php" method="post" accept-charset="utf-8">
    <label for="domain">Domain name: </label><br />
    <input style="width: 400px" type="text" name="domain" id="domain" placeholder="yoloswag.nohost.me" required /><br /><br />
    <input class="btn btn-primary" type="submit" value="Delete" />
</form>

</div>
</body>
</html>
