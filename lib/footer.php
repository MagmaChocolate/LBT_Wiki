<!--
  relation: index.php
-->
<?php
//$host  = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
//$host .= $_SERVER['HTTP_HOST'];
$host = "https://lbt-wiki.magcho.com";
?>
<!-- Include JQery -->
<script src="<?php echo $host; ?>/resource/jquery/jquery-3.1.1.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo $host; ?>/resource/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>


<!-- drawer.css -->
<link rel="stylesheet" href="<?php echo $host; ?>/resource/drawer/css/drawer.min.css">
<!-- jquery & iScroll -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
<script src="<?php echo $host; ?>/resource/iscroll/iscroll.js"></script>
<!-- drawer.js -->
<script src="<?php echo $host; ?>/resource/drawer/js/drawer.min.js"></script>
<script>$(document).ready(function(){$('.drawer').drawer();});</script>

<script src="<?php echo $host; ?>/resource/js/view.js"></script>
<link href="<?php echo $host; ?>/resource/css/view.css" rel="stylesheet" />
</body>
</html>
