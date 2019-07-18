(function(window, document, $) {

	function getImageDimensions(base64Data, callback) {
		$('<img/>')
			.attr('src', base64Data)
			.css({
				visibility: 'hidden',
				position: 'absolute',
				top: -9999,
				left: -9999
			})
			.load(function() {
				var $image = $(this),
					width = $image.width(),
					height = $image.height();

				$image.remove();
				callback({ width: width, height: height });
			})
			.appendTo('body');
	}

	function resizeImage(dataUri, maxSize, base64Decode, quality, callback) {
		if (base64Decode) {
			base64Decode = window.atob || (typeof(base64Decode) === 'function' && base64Decode);
		}

		getImageDimensions(dataUri, function(dimensions) {
			var width = dimensions.width,
				height = dimensions.height,
				image = new Image();

			image.src = dataUri;

			function resize() {
				var canvas = document.createElement('canvas'),
					context = canvas.getContext('2d');

				width = Math.round(width / 1.5);
				height = Math.round(height / 1.5);
				canvas.width = width;
				canvas.height = height;
				context.drawImage(image, 0, 0, width, height);
				dataUri = canvas.toDataURL('image/jpeg', quality || 0.8);
				canvas = null;
				check();
			}

			function check() {
				var base64 = dataUri.substring(dataUri.indexOf(',') + 1);
				if ((base64Decode && base64Decode(base64).length > maxSize) || (base64.length > maxSize)) {
					resize();
				} else {
					callback(dataUri);
				}
			}

			check();
		});
	}

	$.fn.fileInput = function() {
		return this.each(function() {
			var $this = $(this);
			var $input = $('<input/>')
				.attr('type', 'file')
				.css({
					cursor: $this.css('cursor'),
					opacity: 0,
					left: -9999,
					top: -9999,
					position: 'absolute'
				});
			$this.append($input);

			if ($this.css('position') === 'static') {
				$this.css('position', 'relative');
			}
			$this.css('overflow', 'hidden');

			$this.mousemove(function(e) {
				var $wrapper = $(this),
					$input = $wrapper.find('input[type="file"]'),
					mouseX = e.clientX + $(document).scrollLeft(),
					mouseY = e.clientY + $(document).scrollTop(),
					inputWidth = $input.outerWidth(),
					inputHeight = $input.outerHeight();

				var offset = $wrapper.offset(),
					wrapperWidth = $wrapper.outerWidth(),
					wrapperHeight = $wrapper.outerHeight(),
					left = mouseX - offset.left - inputWidth + 30,
					top = mouseY - offset.top - inputHeight / 2;

				if (mouseX > offset.left + wrapperWidth || mouseX < offset.left) {
					left = -9999;
				}
				if (mouseY > offset.top + wrapperHeight || mouseY < offset.top) {
					top = -9999;
				}

				$input.css({ left: left, top: top });
			});
		});
	};

	$.fn.imagePreviewInput = function(options) {
		options = options || {};
		this.fileInput().each(function() {
			var $element = $(this);
			$element.on('change', (function($element) {
				return function(e) {
					if (!e.target.files) {
						return;
					}

					var file = e.target.files[0];
					if (!file) {
						return;
					}

					if (file.type.indexOf('image') !== 0) {
						return;
					}

					var reader = new FileReader();
					reader.onload = function(e) {
						var event = new $.Event('load');
						event.originalEvent = e;

						if (options.resize) {
							resizeImage(e.target.result, options.resize, options.decode, options.quality, function(base64Data) {
								$element.trigger(event, [ base64Data ]);
							});
						} else {
							$element.trigger(event, [ e.target.result ]);
						}
					};

					reader.readAsDataURL(file);
				};
			}($element)));
		});

		return this;
	};

}(window, document, jQuery));