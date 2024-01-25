<footer class="bg-light text-center text-lg-start mt-auto">
	<div class="text-center p-3">

		<?php if(isset($_SESSION['LOGGED_ADMIN'])): ?>
		<a href="admin/dashboard.php">Administration</a>
		<?php endif ?>

		<p class="text-dark">©<?= date("Y") ?> Copyright: Méline Pischedda</p>
	</div>
</footer>

</body>

</html>