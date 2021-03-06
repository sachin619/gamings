<!-- Footer
============================================= -->
<footer id="footer" class="dark">

    <!-- Copyrights
    ============================================= -->
    <div id="copyrights">

        <div class="container center clearfix">

            &copy; 2016 by<a href="#"> Event Exchange </a>. All Rights Reserved Developed by <a href="http://infinisystem.com/" target="_blank"> Infini Systems </a>. <br>
            <a href="<?= get_site_url()."/terms-conditions" ?>" target="_blank"> Terms & Condition </a> &nbsp;&nbsp; | &nbsp;&nbsp; 
            <a href="<?= get_site_url()."/privacy-policy" ?>" target="_blank"> Privacy & Policy </a>
        </div>

    </div><!-- #copyrights end -->

</footer><!-- #footer end -->

</div><!-- #wrapper end -->

<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>

<!-- External JavaScripts
============================================= -->
<?php
if(strpos($_SERVER['REQUEST_URI'], 'tournaments') == false):
?>
<script type="text/javascript" src="<?= get_template_directory_uri() ?>/js/jquery.js"></script>
<?php
endif;
?>
<script type="text/javascript" src="<?= get_template_directory_uri() ?>/js/plugins.js"></script>
<script type="text/javascript" src="<?= get_template_directory_uri() ?>/js/jquery-ui.js"></script>
<!-- Footer Scripts
============================================= -->
<script type="text/javascript" src="<?= get_template_directory_uri() ?>/js/functions.js"></script>
<script type="text/javascript" src="<?= get_template_directory_uri() ?>/js/datepicker.js"></script>
<script type="text/javascript">
    $(function () {
        $('.travel-date-group .input-daterange').datepicker({
            autoclose: true
        });


    });
    $(document).ready(function () {
        $('.datePicker').datepicker({
            format: 'yyyy-mm-dd'
        });
    })

</script>
<?php
//$getTime = "<script>getTimezoneName();</script>";
?>
</body>
</html>