( function ($, elementor) {
	"use strict";


    var Exhibs = {

        init: function () {
            
            var widgets = {
				'exhibz-speaker.default': Exhibs.Speaker_Image_Popup,
				'exhibz-speaker-slider.default': Exhibs.Speaker_Slider_popup,
				'exhibz-testimonial.default': Exhibs.Testimonial_Slider,
				'exhibz-slider.default': Exhibs.Main_Slider,
				'exhibz-gallery-slider.default': Exhibs.Exhibz_Gallery_Slider,
				'exhibz-event-category-slider.default': Exhibs.Exhibz_Category_Slider,
                'exhibz-creative-speaker.default': Exhibs.Exhibz_Creative_Speaker_Widget,
                'creative-schedule.default': Exhibs.Exhibz_Creative_Schedule_Tab
            };
            $.each(widgets, function (widget, callback) {
                elementor.hooks.addAction('frontend/element_ready/' + widget, callback);
            });
           
		},
        Exhibz_Creative_Speaker_Widget: function ($scope) {
            const container = $scope.find('.exhibz-creative-speaker');
            if (container.length > 0) {
                const settings = container.data('widget_settings');
                const slider_space_between = parseInt(settings.slider_space_between);
                const slide_autoplay = (settings.speaker_slider_autoplay === 'yes') ? true : false;
                const speaker_slider_speed = parseInt(settings.speaker_slider_speed);
                new Swiper($scope.find('.swiper-container'), {
                    slidesPerView: settings.slider_items,
                    spaceBetween: slider_space_between,
                    loop: true,
                    speed: speaker_slider_speed,
                    autoplay: slide_autoplay,
                    navigation: {
                        nextEl: `.swiper-next-${settings.widget_id}`,
                        prevEl: `.swiper-prev-${settings.widget_id}`,
                    },
                    pagination: {
                        el: ".exhibz-speaker-scrollbar",
                        type: "progressbar",
                    },
                    // Responsive breakpoints
                    breakpoints: {
                        // when window width is >= 320px
                        0: {
                            slidesPerView: 1,
                        },
                        // when window width is >= 480px
                        767: {
                            slidesPerView: 2,
                        },
                        // when window width is >= 640px
                        1024: {
                            slidesPerView: settings.slider_items,
                        }
                    }
                })
            }

            $('.exh-speaker-title a').each(function () {
                let speakerName = $(this);
                speakerName.html(speakerName.text().replace(/([^\s]+)/, '<span class="first-name">$1</span>'));
            });
        },
        
		Exhibz_Category_Slider: function ($scope) {
			var $container = $scope.find('.ts-event-category-slider');

            if ($container.length > 0) {
                    var count =	$(".ts-event-category-slider").data("count");
                    $($container).each(function (index, element) {
                        let $element = $( element ).find( '.swiper-container' );
                        new Swiper( $element, {
                        wrapperClass: 'swiper-wrapper',
                        slideClass: 'swiper-slide',
                        slidesPerView: count,
                        mouseDrag: true,
                        loop: false,
                        touchDrag: true,
                        autoplay:true,
                        nav: true,
                        spaceBetween: 30,
                        dots: true,
                        autoplayTimeout: 5000,
                        autoplayHoverPause: true,
                        smartSpeed: 600,
                        breakpoints: {
                            // when window width is >= 320px
                            0: {
                                slidesPerView: 2,
                            },
                            // when window width is >= 480px
                            767: {
                                slidesPerView: 3,
                            },
                            // when window width is >= 640px
                            1024: {
                                slidesPerView: count
                            }
                        }
                    });
                }
            )};	
        },

		Speaker_Slider_popup: function ($scope){
			var $container = $scope.find('.ts-image-popup');
            var $container2 = $scope.find('.ts-speaker-slider');
            let controls = $container2.data( 'controls' );
			$container.magnificPopup({
				type: 'inline',
				closeOnContentClick: false,
				midClick: true,
				callbacks: {
				beforeOpen: function () {
					this.st.mainClass = this.st.el.attr('data-effect');
				}
				},
				zoom: {
				enabled: true,
				duration: 500, // don't foget to change the duration also in CSS
				},
				mainClass: 'mfp-fade',
			});

            let widget_id = controls.widget_id;
            let speaker_slider_speed = parseInt(controls.speaker_slider_speed);            
            let slider_count = parseInt(controls.slider_count);            
            let speaker_slider_autoplay = Boolean(controls.speaker_slider_autoplay?true:false);

            $($container2).each(function (index, element) {
				let $element = $( element ).find( '.swiper-container' );
				new Swiper( $element, {
					slidesPerView: slider_count,
					spaceBetween: 0,
					loop: true,
					wrapperClass: 'swiper-wrapper',
					slideClass: 'swiper-slide',
					grabCursor: false,
					allowTouchMove: true,
                    autoplay: speaker_slider_autoplay ? { delay: 5000 } : false,
					speed: speaker_slider_speed, //slider transition speed
					mousewheelControl: 1,
					pagination: {
						el: '.swiper-pagination',
						type: 'bullets',
						dynamicBullets: true,
						clickable: true,
					},
					navigation: {
						nextEl: `.swiper-next-${widget_id}`,
						prevEl: `.swiper-prev-${widget_id}`,
					},
                    breakpoints: {
                        // when window width is >= 320px
                        0: {
                            slidesPerView: 1,
                        },
                        // when window width is >= 480px
                        767: {
                            slidesPerView: 2,
                        },
                        // when window width is >= 640px
                        1024: {
                            slidesPerView: slider_count,
                        }
                    }
				} );
			} );
		},

		Speaker_Image_Popup: function ($scope) {
			var $container = $scope.find('.ts-image-popup');
		
			$container.magnificPopup({
				type: 'inline',
				closeOnContentClick: false,
				midClick: true,
				callbacks: {
				beforeOpen: function () {
					this.st.mainClass = this.st.el.attr('data-effect');
				}
				},
				zoom: {
				enabled: true,
				duration: 500, // don't foget to change the duration also in CSS
				},
				mainClass: 'mfp-fade',
			});																										
		
		},

		Main_Slider: function( $scope ) {
			let $container = $scope.find( '.main-slider' );
			let controls = $container.data( 'controls' );
			
			var autoslide = Boolean(controls.auto_nav_slide?true:false);
			const slider_speed = parseInt(controls.slider_speed);            
			let widget_id = controls.widget_id;

			$($container).each(function (index, element) {
				let $element = $( element ).find( '.swiper-container' );
				new Swiper( $element, {
					slidesPerView: 1,
					centeredSlides: true,
					spaceBetween: 0,
					loop: true,
					wrapperClass: 'swiper-wrapper',
					slideClass: 'swiper-slide',
					grabCursor: false,
					allowTouchMove: true,
					speed: slider_speed, //slider transition speed
					parallax: true,
					autoplay: autoslide ? { delay: 5000 } : false,
					effect: 'slide',
					mousewheelControl: 1,
					pagination: {
						el: '.swiper-pagination',
						type: 'bullets',
						dynamicBullets: true,
						clickable: true,
					},
					navigation: {
						nextEl: `.swiper-next-${widget_id}`,
						prevEl: `.swiper-prev-${widget_id}`,
					},
				} );
			} );
		},
        
        Exhibz_Gallery_Slider: function ($scope) {
            const container = $scope.find('.ts-gallery-slider');
            if (container.length > 0) {
                const settings = container.data('widget_settings');
                const slider_space_between = parseInt(settings.slider_space_between);
                const slide_autoplay = (settings.speaker_slider_autoplay === 'yes') ? true : false;
                const speaker_slider_speed = parseInt(settings.speaker_slider_speed);
                new Swiper($scope.find('.swiper-container'), {
                    slidesPerView: settings.slider_items,
                    spaceBetween: slider_space_between,
                    loop: true,
                    centeredSlides: true,
                    speed: speaker_slider_speed,
                    autoplay: slide_autoplay,
                    navigation: {
                        nextEl: `.swiper-next-${settings.widget_id}`,
                        prevEl: `.swiper-prev-${settings.widget_id}`,
                    },
                    pagination: {
                        el: ".swiper-pagination",
                        type: "bullets",
                        clickable: true
                    },
                    // Responsive breakpoints
                    breakpoints: {
                        // when window width is >= 320px
                        0: {
                            slidesPerView: 1,
                        },
                        // when window width is >= 480px
                        767: {
                            slidesPerView: 2,
                        },
                        // when window width is >= 640px
                        1024: {
                            slidesPerView: settings.slider_items,
                        }
                    }
                })
            }
        },
        Testimonial_Slider: function ($scope) {
            const container = $scope.find('.testimonial-carousel');
            if (container.length > 0) {
                const settings = container.data('widget_settings');
                const slide_autoplay = (settings.autoplay_onoff === 'yes') ? true : false;
                const quote_slider_speed = parseInt(settings.quote_slider_speed);
                new Swiper($scope.find('.swiper-container'), {
                    slidesPerView: settings.quote_slider_count,
                    spaceBetween: 10,
                    loop: true,
                    speed: quote_slider_speed,
                    autoplay: slide_autoplay,
                    navigation: {
                        nextEl: `.swiper-next-${settings.widget_id}`,
                        prevEl: `.swiper-prev-${settings.widget_id}`,
                    },
                    pagination: {
                        el: ".swiper-pagination",
                        type: "bullets",
                        clickable: true
                    },
                    // Responsive breakpoints
                    breakpoints: {
                        // when window width is >= 320px
                        0: {
                            slidesPerView: 1,
                        },
                        // when window width is >= 480px
                        767: {
                            slidesPerView: 2,
                        },
                        // when window width is >= 640px
                        1024: {
                            slidesPerView: settings.quote_slider_count,
                        }
                    }
                })
            }
        },

        Exhibz_Creative_Schedule_Tab: function ($scope) {
            const container = $scope.find('.creative-schedule');
            const sliderSelector = $scope.find('.etn-tab-speaker-slide');
            if (container.length > 0) {
                $(sliderSelector).each(function (index, element) {
                    let thisElm = $(element),
                        thisElmWrap = thisElm.closest('.etn-schedule-speaker');
                    new Swiper(thisElm, {
                        slidesPerView: 3,
                        spaceBetween: 5,
                        navigation: {
                            nextEl: thisElmWrap.find('.swiper-button-next'),
                            prevEl: thisElmWrap.find('.swiper-button-prev'),
                        },
                        // Responsive breakpoints
                        breakpoints: {
                            // when window width is >= 320px
                            0: {
                                slidesPerView: 1,
                            },
                            // when window width is >= 480px
                            767: {
                                slidesPerView: 2,
                            },
                            // when window width is >= 640px
                            1024: {
                                slidesPerView: 3,
                            }
                        }
                    })
                });
            }
        }
    };
    $(window).on('elementor/frontend/init', Exhibs.init);
}(jQuery, window.elementorFrontend) ); 
