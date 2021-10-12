$(document).ready(function () {
  $('.slider').slick({
    centerMode: false,
    infinite: false,
    arrows: false,
    fade: false,
    //dots: true,
    //centerPadding: '60px',
    slidesToShow: 5,
    speed: 500,
    responsive: [{
      breakpoint: 1452,
      settings: {
        slidesToShow: 4
      }
    }, {
      breakpoint: 1172,
      settings: {
        slidesToShow: 3
      }
    }, {
      breakpoint: 912,
      settings: {
        slidesToShow: 2
      }
    }, {
      breakpoint: 650,
      settings: {
        slidesToShow: 1
      }
    }]
  });

  $('.slider-progress').each(function (i, el) {
    let sliderId = $(el).data('slider')
    let $slider = $('#' + sliderId)
    let $progressInput = $(el).find('.slider-progress-input')
    let val_max = $slider[0].slick.slideCount - 1
    $progressInput.attr('max', val_max)
	//let var_mid = val_max / 2
    //$progressInput.val(val_max / 2)
    //$slider.slick('slickGoTo', var_mid)

    $slider.on('afterChange', function (event, slick, currentSlide) {
      checkPosition();
      $progressInput.val(currentSlide);
      //console.log(currentSlide)
    });

    $($progressInput).mousedown(function () {
      $slider.slick('slickPause')
    });

    $($progressInput).mouseup(function () {
      $slider.slick('slickPlay')
    })

    $($progressInput).on('input', function () {
      checkPosition()
      $slider.slick('slickGoTo', $(this).val())

    })
  })

  $(document).scroll(function () {
    checkPosition()
  });
  checkPosition();
  $(window).resize(function () {
    checkPosition()
  });

  function checkPosition () {
    $('div.card.slider-item.slick-slide').each(function (i, el) {
      let item_position = $(el).offset()
      let item_width = $(el).width()
      let item_x1 = item_position.left
      let item_x2 = item_x1 + item_width

      let left_scroll = $(document).scrollLeft()
      let screen_width = $(window).width()
      let see_x1 = left_scroll
      let see_x2 = screen_width + left_scroll
      //console.log(el, 'x1: ' + item_x1 + ' x2: ' + item_x2 + ' see_x1: ' + see_x1 + ' see_x2: ' + see_x2 + ' screen_width: ' + screen_width)
      if (item_x1 >= see_x1 && item_x2 <= see_x2) {
		$(el).css('opacity', '1').css('transition', 'opacity .1s')
		  if (screen_width > 1800 && (item_x1 < (see_x1 + item_width) || item_x2 > (see_x2 - item_width))) {
          	$(el).css('opacity', '0.4')
			}
      } else {
        $(el).css('opacity', '0.4').css('transition', 'opacity .1s')
      }
    })
  }

})