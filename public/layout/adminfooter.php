	</div>
	<div id="footer">
		Copyright <?php echo date("Y",time()); ?>, Nasir khan
	</div>	
</body>
</html>
<?php if(isset($database)){$database->closeConnection();} ?>