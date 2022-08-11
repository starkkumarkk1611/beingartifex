(function ($, elementor) {
    "use strict";
    

	var ElementskitLite = {
		init: function () {
			elementor.hooks.addAction('frontend/element_ready/global', function($scope){
				new EkitStickyHandler({ $element: $scope });
			});
		}
	};
	$(window).on('elementor/frontend/init', ElementskitLite.init);

	var CompareVersion = function (v1, v2) {
		if (typeof v1 !== 'string') return false;
		if (typeof v2 !== 'string') return false;
		v1 = v1.split('.');
		v2 = v2.split('.');
		const k = Math.min(v1.length, v2.length);
		for (let i = 0; i < k; ++ i) {
			v1[i] = parseInt(v1[i], 10);
			v2[i] = parseInt(v2[i], 10);
			if (v1[i] > v2[i]) return 1;
			if (v1[i] < v2[i]) return -1;
		}
		return v1.length == v2.length ? 0: (v1.length < v2.length ? -1 : 1);
	}


	var ElementsKitModule = (typeof window.elementorFrontend.version !== 'undefined' && CompareVersion(window.elementorFrontend.version, '2.6.0' ) < 0)
							? elementorFrontend.Module
							: elementorModules.frontend.handlers.Base;

	var EkitStickyHandler = ElementsKitModule.extend({

		isTrue: function isTrue(key, val){
            if(this.getElementSettings(key) != false && this.getElementSettings(key) == val){
				return true;
			}
			return false;
		},

		shouldRun: function shouldRun(val){
			var $should_run = false;
			
            if(this.isTrue('ekit_we_effect_on', val)){
				$should_run = true;
			}

			if(Boolean(elementor.isEditMode()) && this.isTrue('ekit_we_on_test_mode', 'yes')){
				$should_run = false;
			}

			return $should_run;
		},

		active: function active() {
            if(this.shouldRun('tilt')){
                this.tilt();
            }
            if(this.shouldRun('mousemove')){
                this.mousemove();
            }
            if(this.shouldRun('onscroll')){
                this.onscroll();
            }
		},

		deactivate: function deactivate(forceUnbind) {
            if(forceUnbind || !this.getElementSettings('ekit_we_effect_on') || this.getElementSettings('ekit_we_effect_on') != 'tilt' || this.isTrue('ekit_we_on_test_mode', 'yes')){
                this.$element.find('.elementor-widget-container').tilt().tilt.destroy.call(this.$element.find('.elementor-widget-container'));
            }
            if(forceUnbind || !this.getElementSettings('ekit_we_effect_on') || this.getElementSettings('ekit_we_effect_on') != 'mousemove' || this.isTrue('ekit_we_on_test_mode', 'yes')){
                this.$element.parents('.elementor-section').first().off('mousemove.elementskitwidgethovereffect');
            }
            if(forceUnbind || !this.getElementSettings('ekit_we_effect_on') || this.getElementSettings('ekit_we_effect_on') != 'onscroll' || this.isTrue('ekit_we_on_test_mode', 'yes')){
                $(window).off('scroll.magicianscrolleffect' + this.getID());
            }
		},

		onElementChange: function onElementChange(settingKey) {
            if(settingKey.includes('ekit_we_')){
                if(settingKey.includes('_on')){
                    this.deactivate(false);
                }
                if(settingKey.includes('we_scroll_')){
                    this.deactivate(true);
                }
                this.active();
            }
		},

		onInit: function onInit() {
			ElementsKitModule.prototype.onInit.apply(this, arguments);
			this.active();
		},

		onDestroy: function onDestroy() {
			ElementsKitModule.prototype.onDestroy.apply(this, arguments);
			this.deactivate(true);
        },
        

		// animation
        tilt: function tilt(){
            var content = this.$element.find('.elementor-widget-container');;
            content.tilt({
                disableAxis: this.getElementSettings('ekit_we_tilt_disableaxis'),
                scale: this.getElementSettings('ekit_we_tilt_scale'),
                speed: this.getElementSettings('ekit_we_tilt_parallax_speed'),
                maxTilt: this.getElementSettings('ekit_we_tilt_maxtilt'),
                glare: true,
                maxGlare: .5
            });
		},
		
        mousemove: function mousemove(){
            var content = this.$element.find('.elementor-widget-container');
            var container = this.$element.parents('.elementor-section').first();
			var speed = this.getElementSettings('ekit_we_mousemove_parallax_speed');
            container.on('mousemove.elementskitwidgethovereffect', function (e) {
				var relX = e.pageX - container.offset().left;
				var relY = e.pageY - container.offset().top;

				TweenMax.to(content, 1, {
					x: (relX - container.width() / 2)  / container.width() * (speed),
					y: (relY - container.height() / 2) / container.height() * (speed),
					ease: Power2.ease
				});
            });
		},
		
		onscroll: function onscroll(){
			var content = this.$element.find('.elementor-widget-container');

			content.magician({
				type: 'scroll',
				uniqueKey: this.getID(),
				offsetTop: parseInt(this.getElementSettings('ekit_we_scroll_offsettop')),
				offsetBottom: parseInt(this.getElementSettings('ekit_we_scroll_offsetbottom')),
				duration: parseInt(this.getElementSettings('ekit_we_scroll_smoothness')),
				animation: {
					[this.getElementSettings('ekit_we_scroll_animation')]: this.getElementSettings('ekit_we_scroll_animation_value')
				}
			});
		}
	});
}(jQuery, window.elementorFrontend));