		<!-- Footer
		============================================= -->
		<footer id="footer" class="dark">

			<!-- Copyrights
			============================================= -->
			<div id="copyrights">

				<div class="container center clearfix">

					 &copy; 2016 by<a href="#"> Lagayega </a>. All Rights Reserved Developed by <a href="http://infinisystem.com/" target="_blank"> Infini Systems </a>.

				</div>

			</div><!-- #copyrights end -->

		</footer><!-- #footer end -->

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- External JavaScripts
	============================================= -->
	<script type="text/javascript" src="<?= get_template_directory_uri() ?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?= get_template_directory_uri() ?>/js/plugins.js"></script>
        <script type="text/javascript" src="<?= get_template_directory_uri() ?>/js/jquery-ui.js"></script>
	<!-- Footer Scripts
	============================================= -->
	<script type="text/javascript" src="<?= get_template_directory_uri() ?>/js/functions.js"></script>
	<script type="text/javascript" src="<?= get_template_directory_uri() ?>/js/datepicker.js"></script>
	<script type="text/javascript">
		$(function() {
			$('.travel-date-group .default').datepicker({
				autoclose: true,
				startDate: "today",
			});

			$('.travel-date-group .today').datepicker({
				autoclose: true,
				startDate: "today",
				todayHighlight: true
			});

			$('.travel-date-group .past-enabled').datepicker({
				autoclose: true,
			});
			$('.travel-date-group .format').datepicker({
				autoclose: true,
				format: "dd-mm-yyyy",
			});

			$('.travel-date-group .autoclose').datepicker();

			$('.travel-date-group .disabled-week').datepicker({
				autoclose: true,
				daysOfWeekDisabled: "0"
			});

			$('.travel-date-group .highlighted-week').datepicker({
				autoclose: true,
				daysOfWeekHighlighted: "0"
			});

			$('.travel-date-group .mnth').datepicker({
				autoclose: true,
				minViewMode: 1,
				format: "mm/yy"
			});

			$('.travel-date-group .multidate').datepicker({
				multidate: true,
				multidateSeparator: " , "
			});

			$('.travel-date-group .input-daterange').datepicker({
				autoclose: true
			});

			$('.travel-date-group .inline-calendar').datepicker();

			

		});

	</script>
</body>
</html>