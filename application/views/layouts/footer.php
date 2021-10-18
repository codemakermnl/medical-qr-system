		<footer class="footer">
			<div class="container text-center">
				<span class="footer-copyright">Copyright &copy; <?= date('Y') ?> Medical Inventory System. All Rights Reserved.</span>
			</div>
		</footer>

		<?php if($this->session->userdata('position_Id') == 1) {  ?>
		<script>
		</script>
		<?php } ?>

	</body>
	</html>