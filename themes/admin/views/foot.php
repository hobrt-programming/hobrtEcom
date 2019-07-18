	      
	    </div><!-- Row End -->
	</div> <!-- mainBox End -->

	<!-- Global javascript & jquery Files -->
	<script src="ckeditor/ckeditor.js"></script><!-- ckEditor -->
	<script src="js/strap.min.js" type="text/javascript"></script><!-- BootStrap Libs -->
	<script src="js/strap-toggle.min.js" type="text/javascript"></script><!-- BootStrap ChcekBoxs Element-->
	<script src="js/strap-select.min.js" type="text/javascript"></script><!-- BootStrap Select Element -->
	<script src="js/scrollReveal.min.js" type="text/javascript"></script><!-- Scroll Animation -->
	<script src="js/bootstrap-formhelpers.js" type="text/javascript"></script><!-- BootStrap More Tools For Forms -->
	<script src="js/jquery.maskedinput.js" type="text/javascript"></script><!-- BootStrap More Tools For Forms -->
	<script src="js/jquery.file-input.js" type="text/javascript"></script><!-- BootStrap More Tools For Forms -->
	<script src="js/checkBo.js" type="text/javascript"></script>
	<script src="js/custom.js" type="text/javascript"></script><!-- Custom jQuery Stuff -->
	<script src="js/js.js" type="text/javascript"></script><!-- Custom jQuery Stuff -->

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.ar.min.js"></script>

  <script>


    $("#datep").datepicker({
        language: 'ar',
        format : "yyyy-mm-dd"
    });

$(function () {
    $("#responds").sortable({
        update: function (event, ui) {
            var order = $(this).sortable('serialize');
            $(document).on("click", ".button", function () { //that doesn't work
                $.ajax({
                    data: order,
                    type: 'POST',
                    url: '<?php echo base_url("admin/order_save"); ?>',
                    success : function(re) {
                      //alert(re);
                      if(re == "")
                      {
                        alert("order saved .");
                      }else
                      {
                        alert(re);
                      }
                    }
                });
            });
        }
    }).disableSelection();
    $('.button').on('click', function () {
        var r = $("#responds").sortable("toArray");
        var a = $("#responds").sortable("serialize", {
            attribute: "id"
        });
        console.log(r, a);
    });
});

    CKEDITOR.replace( 'editor1', {
      language: 'ar'
     } );

  </script>
</body>
</html>