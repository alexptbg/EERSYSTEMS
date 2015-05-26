<script type="text/javascript" src="js/jquery.js"></script>
<script>
 $(document).ready(function() {
 	 $("#tabledata").load("edata.php?x=");
   var refreshId = setInterval(function() {
      $("#tabledata").load('edata.php?x=?randval='+ Math.random());
   }, 1000);
   $.ajaxSetup({ cache: false });  
});
</script>
<div align="left" id="tabledata"></div>