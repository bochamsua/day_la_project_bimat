<div which-notice="timeoutError" id="timeout-error-msg">
	<ul class="messages">
		<li class="error-msg">
			<h2>PHP EXECUTION TIMEOUT ERROR<button class="dismiss-button">x</button></h2>
			Your hosting has an execution time limit of <?php echo SGBoot::$executionTimeLimit;?> seconds for PHP scripts, which is not enough for performing full backup/restore of your website. A full website backup/restore is a complex process which may take a couple of minutes depending on many circumstances. The needed execution time varies depending on the backup options and your server performance, that's why we cannot tell exactly how much execution time is needed. But, almost all hosting providers give users the ability to increase the execution time limit or they increase it themselves, upon user request. Please ask your hosting provider if they are able increase your execution time limit.
		</li>
	</ul>
</div>
