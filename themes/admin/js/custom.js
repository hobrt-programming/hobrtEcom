$(document).ready(function() {

	var pa = 1;

	$(document).on('change','.add-mor',function(e) {
      var tes = $(this);
      if($(".morfakat > li").length < 15){
        var files = e.target.files[0];
        if(files.size < 20 * 1024 * 1024){
          var types = tes.attr("accept");
              var tps_array = types.split(',');
          if(jQuery.inArray(files.type , tps_array) !== -1) {
            var ext = files.name.split('.').pop();
            if (files.type.match('image.*')) {

              var dau = URL.createObjectURL(files);

              }else {
                var dau = "img/" + ext.toUpperCase() + ".png";
              }
              
              var tt = "<li style='text-align: center;'><img class='test-simg' src='"+dau+ "' style='height: 50px;width: auto;' alt='"+ files.name +"' title='"+ files.name +"'> <br /> <a href='' style='color:red;' class='deltip' data-d='"+pa+"'><i class='fa fa-remove'></i></a></li>";
              $(".morfakat").append(tt);
            tes.hide();
            pa++;
            var te = '<input type="file" class="file_select add-mor pa'+pa+'" name="file[]" accept="image/jpeg,image/gif,image/png">';
            tes.after(te);
            }
        } else {
          swal("", "حجم الملف اكبر من المسموح به", "error")
        }
      }else
      {
        $(this).val('');
        alert("you can add only 15 images ");
      }
      
    })
    
    $(document).on('click','.deltip',function(){
      var sel = ".pa" + $(this).data('d');
      $(sel).remove();
      $(this).parent().remove();
      return false;
    })


	//Responsive Button
	$('.res-menu').on('click', function(){
		$('#sidebar').toggleClass('res-menu-up');
	});

	// Notif gonne
	$('.topA:has("i.badge")').on('click', function() {
		$('>i.badge', this).stop(true, true).addClass('displaynone');
		$('i.badge').click(function(e) { e.stopPropagation(); });
	});

	// SlideDown SideBar Child
	$('ul.sideBar li:has("i.sideDown")').on('click', function(){
			$('>ul.sideChild', this).stop(true, true).slideToggle(300);
			$('ul.sideChild').click(function(e) { e.stopPropagation(); });
	});

	// Init BootStrap ToolTip
  $('[data-toggle="tooltip"]').tooltip();
  $('select').mobileSelect({
  	padding: {
  		'top': '50px',
      'left': '50px',
      'right': '50px',
      'bottom': '20px'
  	},
  	animation: 'bottom',
  	animationSpeed: 200,
  });

	var config = {
		mobile: true,
		reset: true,
		delay: 'always',  
		vFactor: 0.10,
		viewport: document.getElementById('main'),
		opacity: 0,

	};
	window.sr = new scrollReveal( config );

	// Masks
	jQuery(function($){
		$.mask = {
        definitions: {
            "9": "[0-9]",
            a: "[A-Za-z]",
            "*": "[A-Za-z0-9]"
        },
        autoclear: !0,
        dataName: "rawMaskFn",
        placeholder: "_"
    };
		$(".phone-number").mask("+9 999-99999-999",{placeholder:"+2 999-99999-999"});
	});

	

	$('.image-preview-input-1').imagePreviewInput({ resize: 300 * 1024, decode: true}).on('load', function(e, data) {
		var $preview = $('#image-preview-1').css('display', 'inline-block'),
		$img = $preview.find('img');
		if (!$img.length) {
			$img = $('<img/>').appendTo($preview);
		}
		$img.attr('src', data);
	});

	/*var wrapper = $('<div/>').css({height:0,width:0,'overflow':'hidden'});
	var fileInput = $(':file').wrap(wrapper);

	fileInput.change(function(){
    $('#post_img').addClass('upload-done');
	});

	$('#post_img').click(function(){
    fileInput.click();
	}).show();

	$('ANY').checkBo();*/
});




