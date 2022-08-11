jQuery(document).ready(function ($) {
    'use strict';

    var container = $('.etn-countdown-wrap');
    if (container.length > 0) {
        $.each(container, function (key, item) {
            var current_countdown_wrap = this;

            // countdown
            let etn_event_start_date = '';
            etn_event_start_date = $(item).data('start-date');

            var countDownDate = new Date(etn_event_start_date).getTime();

            let etn_timer_x = setInterval(function () {
                var now = new Date().getTime();
                var distance = countDownDate - now;

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                $(item).find('.day-count').html(days);
                $(item).find('.hr-count').html(hours);
                $(item).find('.min-count').html(minutes);
                $(item).find('.sec-count').html(seconds);
                if (distance < 0) {
                    clearInterval(etn_timer_x);
                    $(current_countdown_wrap).html(localized_data_obj.expired);
                }
            }, 1000);
        });

    }

    //cart attendee 

    $(".etn-extra-attendee-form").on('blur change click', function () {
        $('.wc-proceed-to-checkout').css({
            'cursor': "default",
            'pointer-events': 'none'
        });
        $.ajax({
            url: etn_localize_event.rest_root + 'etn-events/v1/cart/attendee',
            type: 'GET',
            data: $('.woocommerce-cart-form').serialize(),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', etn_localize_event.nonce);
            },
            success: function (data) {
                $('.wc-proceed-to-checkout').css({
                    'cursor': "default",
                    'pointer-events': 'auto'
                });
            },

        });
    });


    $('.schedule-tab').on('click', openScheduleTab);

    function openScheduleTab() {
        var title = $(this).data('title');
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(title).style.display = "block";
    }

    $('.schedule-tab-shortcode').on('click', openScheduleTabShortCode);

    function openScheduleTabShortCode() {
        var title = $(this).data('title');
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent-shortcode");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks-shortcode");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        let single_title = "shortcode_" + title;
        document.getElementById(single_title).style.display = "block";
    }

    $('.attr-nav-pills>li>a').first().trigger('click');


    //   custom tabs
    $(document).on('click', '.etn-tab-a', function (event) {
        event.preventDefault();

        $(this).parents(".etn-tab-wrapper").find(".etn-tab").removeClass('tab-active');
        $(this).parents(".etn-tab-wrapper").find(".etn-tab[data-id='" + $(this).attr('data-id') + "']").addClass("tab-active");
        $(this).parents(".etn-tab-wrapper").find(".etn-tab-a").removeClass('etn-active');
        $(this).parent().find(".etn-tab-a").addClass('etn-active');
    });

    //======================== Attendee form validation start ================================= //

    /**
     * Get form value and send for validation
     */
    $(".attendee_sumbit").prop('disabled', true).addClass('attendee_sumbit_disable');

    function button_disable(button_class) {
        var length = $(".attendee_error").length;
        var attendee_submit = $(button_class);

        if (length == 0) {
            attendee_submit.prop('disabled', false).removeClass('attendee_sumbit_disable');
        } else {
            attendee_submit.prop('disabled', true).addClass('attendee_sumbit_disable');
        }
    }
    // if update form exist check validation

    if ($(".attendee_update_sumbit").length > 0) {
        var attendee_update_field = [
            "input[name='name']",
        ];

        if ($(".etn-attendee-extra-fields").length > 0) {
            var form_data = []; var attendee_update_field = [];
            $("input:not(:submit,:hidden)").each(function () {
                form_data.push({ name: this.name, value: this.value });
            });
            if (form_data.length > 0) {
                form_data.map(function (obj) {
                    if ($("input[name='" + obj.name + "']").attr('type') !== "hidden") {
                        attendee_update_field.push("input[name='" + obj.name + "']")
                    }
                });
            }
        }

        validation_checking(attendee_update_field, ".attendee_update_sumbit");
    }

    if ($(".attendee_sumbit").length > 0) {

        var attendee_field = [
            "input[name='attendee_name[]']",
        ];

        if ($(".etn-attendee-extra-fields").length > 0) {
            var form_data = []; var attendee_field = [];
            $("input:not(:submit,:hidden)").each(function () {
                form_data.push({ name: this.name, value: this.value });
            });
            if (form_data.length > 0) {
                form_data.map(function (obj) {
                    if ($("input[name='" + obj.name + "']").attr('type') !== "hidden") {
                        attendee_field.push("input[name='" + obj.name + "']")
                    }
                });
            }
        }

        validation_checking(attendee_field, ".attendee_sumbit");
    }

    function validation_checking(input_arr, button_class) {
        var in_valid = [];
        $.each(input_arr, function (index, value) {
            // check if value already exist in input
            switch ($(value).attr('type')) {
                case "text":
                    if (typeof $(this).val() === "undefined" || $(this).val() == "") {
                        $(this).addClass("attendee_error");
                        in_valid.push(value);
                    }
                    break;

                case "number":
                    if (typeof $(this).val() === "undefined" || $(this).val() == "") {
                        $(this).addClass("attendee_error");
                        in_valid.push(value);
                    }
                    break;

                case "date":
                    if (typeof $(this).val() === "undefined" || $(this).val() == "") {
                        $(this).addClass("attendee_error");
                        in_valid.push(value);
                    }
                    break;

                case "radio":
                    if (typeof $(value + ":checked").val() === "undefined") {
                        $(this).addClass("attendee_error");
                        in_valid.push(value);
                    }
                    break;

                default:
                    break;
            }

            // if no value exist check input on key change
            $(".attende_form").on("keyup change", value, function () {
                var response = get_error_message($(this).attr('type'), $(this).val(), value);
                var id = $(this).attr("id");
                if ($(this).attr('type') === 'radio') {
                    id = id.split("_radio_")[0];
                }

                $("." + id).html("");
                if (typeof response !== "undefined" && response.message !== 'success') {
                    $("." + id).html(response.message);
                    $(this).addClass("attendee_error");
                } else {
                    $(this).removeClass("attendee_error");

                    // for removing 'attendee_error' class from all radio label
                    if ($(this).attr('type') == 'radio') {
                        $(this).parents('.etn-radio-field-wrap')
                            .find('.etn-attendee-extra-fields').removeClass("attendee_error");
                    }
                }
                button_disable(button_class);

            });

        });

        // check if value already exist in input
        if (in_valid.length > 0) {
            $(button_class).prop('disabled', true).addClass('attendee_sumbit_disable');
        } else {
            $(button_class).prop('disabled', false).removeClass('attendee_sumbit_disable');
        }
    }

    /**
     * Check type and input validation
     * @param {*} type 
     * @param {*} value 
     */
    function get_error_message(type, value, input_name = '') {
        var response = {
            error_type: "no_error",
            message: "success"
        };

        if (type !== 'radio') {
            (value.length == 0) ? $(this).addClass("attendee_error") : $(this).removeClass("attendee_error");
        } else {
            if ($(input_name).is(':checked')) {
                // for removing 'attendee_error' class from all radio label
                $(this).parents('.etn-radio-field-wrap')
                    .find('.etn-attendee-extra-fields').removeClass("attendee_error");
            } else {
                $(this).addClass("attendee_error");
            }
        }

        switch (type) {
            case 'email':
                const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (value.length !== 0) {
                    if (re.test(String(value).toLowerCase()) == false) {
                        response.error_type = "not-valid";
                        response.message = localized_data_obj.attendee_form_validation_msg.email.invalid;
                    }
                } else {
                    response.error_type = "empty";
                    response.message = localized_data_obj.attendee_form_validation_msg.email.empty;
                }
                break;
            case 'tel':

                if (value.length === 0) {
                    response.error_type = "empty";
                    response.message = localized_data_obj.attendee_form_validation_msg.tel.empty;
                } else if (value.length > 15) {
                    response.error_type = "not-valid";
                    response.message = localized_data_obj.attendee_form_validation_msg.tel.invalid;
                } else if (!value.match(/^\d+/) == true) {
                    response.error_type = "not-valid";
                    response.message = localized_data_obj.attendee_form_validation_msg.tel.only_number;
                }
                break;
            case 'text':
                if (value.length === 0) {
                    response.error_type = "empty";
                    response.message = localized_data_obj.attendee_form_validation_msg.text;
                }
                break;
            case 'number':
                if (value.length === 0) {
                    response.error_type = "empty";
                    response.message = localized_data_obj.attendee_form_validation_msg.number;
                }
                break;
            case 'date':
                if (value.length === 0) {
                    response.error_type = "empty";
                    response.message = localized_data_obj.attendee_form_validation_msg.date;
                }
                break;
            case 'radio':
                if (!$(input_name).is(':checked')) {
                    response.error_type = "not-selected";
                    response.message = localized_data_obj.attendee_form_validation_msg.radio;
                }
                break;

            default:
                break;
        }

        return response;
    }

    //====================== Attendee form validation end ================================= //

    //===================================
    //  advanced ajax search
    //================================= //

    if ($('.etn_event_inline_form').length) {
        if ($(".etn-event-archive-wrap").length === 0) {
            $(".etn-event-wrapper").before('<div class="etn_event_ajax_preloader"><div class="lds-dual-ring"></div></div>');
        }

        function ajax_load(current, search_params) {
            let ajax_wraper = $(".etn-event-archive-wrap");
            // let data_params = ajax_wraper.attr("data-json");
            // let data_parse = JSON.parse(data_params);
            // let loading_btn = $('.etn_load_more_button');

            const queryString = new URL(window.location);
            queryString.searchParams.set(search_params, current.value);
            window.history.pushState({}, '', queryString);

            const queryValue = new URLSearchParams(window.location.search);

            let etn_categorys = queryValue.get("etn_categorys"),
                etn_event_location = queryValue.get("etn_event_location"),
                etn_event_date_range = queryValue.get("etn_event_date_range"),
                etn_event_will_happen = queryValue.get("etn_event_will_happen"),
                keyword = queryValue.get("s");

            if ((keyword !== null && keyword.length) || (etn_event_location !== null && etn_event_location.length) || (etn_categorys !== null && etn_categorys.length) || (etn_event_date_range !== null && etn_event_date_range.length) || (etn_event_will_happen !== null && etn_event_will_happen.length)) {
                ajax_wraper.parents('.etn_search_item_container').find('.etn_event_ajax_preloader').addClass('loading');
                let data = {
                    'action': 'etn_event_ajax_get_data',
                    etn_categorys,
                    etn_event_location,
                    etn_event_date_range,
                    etn_event_will_happen,
                    's': keyword,
                };
                let i = 0;
                jQuery.ajax({
                    url: localized_data_obj.ajax_url,
                    data,
                    method: 'POST',
                    beforeSend: function () {
                        ajax_wraper.parents('.etn_search_item_container').find('.etn_event_ajax_preloader').addClass('loading');
                        i++;
                    },
                    success: function (content) {
                        ajax_wraper.parents('.etn_search_item_container').find('.etn_event_ajax_preloader').removeClass('loading');
                        $('.etn_search_item_container').find('.etn-event-wrapper').html(content);
                    },
                    complete: function () {
                        i--;
                        if (i <= 0) {
                            ajax_wraper.parents('.etn_search_item_container').find('.etn_event_ajax_preloader').removeClass('loading');
                        }
                    },
                })
            }
        }
        if ($('[name="etn_event_location"]').length) {
            $('[name="etn_event_location"]').on("change", function (e) {
                ajax_load(this, 'etn_event_location');
            });
        }

        if ($('[name="etn_categorys"]').length) {
            $('[name="etn_categorys"]').on("change", function (e) {
                ajax_load(this, 'etn_categorys');
            });
        }
        if ($('.etn_event_inline_form').find('[name="s"]').length) {
            $('.etn_event_inline_form').find('[name="s"]').on("keyup", function (e) {
                ajax_load(this, 's');
            })
        }
        if ($('[name="etn_event_date_range"]').length) {
            $('[name="etn_event_date_range"]').on("change", function (e) {
                ajax_load(this, 'etn_event_date_range');
            })
        }
        if ($('[name="etn_event_will_happen"]').length) {
            $('[name="etn_event_will_happen"]').on("change", function (e) {
                ajax_load(this, 'etn_event_will_happen');
            })
        }

    }
    //===================================
    //  meta tag added in attendee registration page
    //================================= //

    $('.etn-attendee-registration-page').before('<meta name="viewport" content="width=device-width, initial-scale=1.0"/>');

    /*================================
    Event accordion
   ===================================*/

    $('.etn-recurring-widget .etn-recurring-header').click(function () {

        $(".etn-recurring-widget").removeClass("active").addClass("no-active").find(".etn-zoom-event-notice").slideUp();
        if ($(this).parents(".recurring-content").hasClass("active")) {
            $(this).parents(".recurring-content").removeClass("active").find(".etn-form-wrap").slideUp();

        } else {
            $(".etn-recurring-widget .recurring-content.active .etn-form-wrap").slideUp();
            $(".etn-recurring-widget .recurring-content.active").removeClass("active");
            $(this).parents(".recurring-content").addClass("active").find(".etn-form-wrap").slideDown();
            $(this).parents(".etn-recurring-widget").addClass("active").removeClass("no-active").find(".etn-zoom-event-notice").slideDown();
        }

    });


    $(document).mouseup(function (e) {
        var container = $(".etn-recurring-widget");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.removeClass("no-active");
        }
    });

    // recurring event load more
    $(document).ready(function () {
        var count = $(".etn-recurring-widget").length;
        var limit = 3;
        $(".etn-recurring-widget").slice(0, limit).show();
        if (count <= limit) {
            $("#seeMore").fadeOut();
        }
        $("body").on('click touchstart', '#seeMore', function (e) {
            e.preventDefault();
            $(".etn-recurring-widget:hidden").slice(0, limit).slideDown();
            if ($(".etn-recurring-widget:hidden").length == 0) {
                $("#seeMore").fadeOut();
            }
        });
    });

    // quantity add/ sub in event ticket 
    var $scope = $('.etn-single-event-ticket-wrap');
    if ($scope.length > 0) {
        etn_ticket_quantity_update($, $scope);
    }

});

/*
* Event ticket quantity addition/sublimation 
*/
function etn_ticket_quantity_update($, $scope) {
    // quantity add/ sub in event ticket 
    let parent_ticket = $scope.find('.etn-event-form-parent');

    if (typeof parent_ticket !== "undefined") {

        parent_ticket.each(function (idx) {
            let unique_id = $(this).data('etn_uid');
            var $this = $(this).data('etn_uid', unique_id);
            let index = 0;

            var variations = $this.find(".variations_" + index);
            var single_ticket = variations.find(".etn-single-ticket-item");
            var ticket_length = single_ticket.length;

            // default check , if it has only one variation
            // show min ticket size

            if (typeof ticket_length !== "undefined" && ticket_length == 1) {
                var min_ticket = parseInt($this.find(".ticket_0").data("etn_min_ticket"));

                if (typeof min_ticket !== "undefined" && min_ticket !== null) {
                    $this.find(".ticket_0").val(min_ticket);
                    ticket_price_cal($this, single_ticket, variations);
                }
            }

            single_ticket.each(function (idx) {
                var ticket_wrap = $this.find(".etn_ticket_variation");

                $this.find(".etn_ticket_variation").on('keyup', function () {
                    multiPricing(ticket_wrap, idx, ticket_length);
                    ticket_price_cal($this, single_ticket, variations);
                });
            });

            single_ticket.find('.qt-btn').on('click', function () {

                var $button = $(this);
                var ticket_wrap = $(this).siblings(".etn_ticket_variation");

                var $input = $button.closest('.etn-quantity').find("input.etn_ticket_variation");
                $input.val((i, v) => Math.max(0, +v + 1 * $button.data('multi')));
                multiPricing(ticket_wrap, $button.data('key'), ticket_length);
                ticket_price_cal($this, single_ticket, variations);
            });
            index++;
        });
    }

    function multiPricing($this, key, ticket_length) {
        // min max quantity checking
        var etn_min_ticket = parseInt($this.data("etn_min_ticket"));
        var etn_max_ticket = parseInt($this.data("etn_max_ticket"));
        var etn_current_stock = parseInt($this.data("etn_current_stock"));
        var etn_cart_limit = parseInt($this.data("etn_cart_limit"));
        var etn_cart_limit_message = $this.data("etn_cart_limit_message");
        var message_div = $this.parents(".etn-single-ticket-item").next(".show_message_" + key);
        var current_input = $this.val();

        $this.parents(".etn-single-ticket-item").next(".show_message").html("");

        // checking cart limit (if already added to cart few tickets)

        if (etn_cart_limit !== 0 && (etn_cart_limit > etn_max_ticket)) {
            $this.addClass("stock_out");
            message_div.html("").html(etn_cart_limit_message);
            $this.parents('.etn-ticket-price-body').addClass("stock_out");
            $this.parents('.etn-ticket-price-body').addClass("stock_out");
            return;
        } else {
            $this.parent().removeClass("stock_out");
        }


        // current stock 0 disable ticket option

        if (etn_current_stock == 0) {
            $this.addClass("stock_out");
            message_div.html("").html($this.data("stock_out"));
            $this.parents('.etn-ticket-price-body').addClass("stock_out");
            $this.parents('.etn-ticket-price-body').addClass("stock_out");
            return;
        } else {
            $this.parent().removeClass("stock_out");
        }


        // check stock value
        if (parseInt($this.val()) > etn_current_stock) {
            $this.val("").val(etn_current_stock);
            message_div.html("").html($this.data("stock_limit"));
            return;
        } else {
            message_div.html("");
        }

        if (etn_max_ticket == 0 || (etn_min_ticket == 0 && etn_max_ticket == 0)) {
            return;
        }

        var qty_message = $this.data("qty_message");

        // checking min,max validation 
        if (current_input == 0 || ((current_input >= etn_min_ticket) && (current_input <= etn_max_ticket))) {
            message_div.html("");
        } else {

            message_div.html(qty_message);
            // force input qty field

            // max
            if ($this.val() > etn_max_ticket) {
                $this.val(etn_max_ticket);
            }
            // min
            if ($this.val() < etn_min_ticket) {
                $this.val(etn_min_ticket);
            }
        }
    }

    function ticket_price_cal($this, single_ticket, variations) {

        var decimal_number_points = $('.etn-event-form-parent').data('decimal-number-points');
        if (typeof decimal_number_points === "undefined" || decimal_number_points === null) {
            decimal_number_points = 2;
        }

        var total_price = 0;
        var total_qty = 0;
        // calculating total qty,price
        var form_length = single_ticket.length;
        var cart_button = "etn-add-to-cart-block";

        for (let index = 0; index < form_length; index++) {

            var quantity = parseInt($this.find('.ticket_' + index).val());
            var price = parseFloat($this.find('.ticket_' + index).data("price"));
            var ticket_price = price * quantity;

            var sub_total_price_format = ticket_price;
            if (!Number.isInteger(ticket_price)) {
                sub_total_price_format = Number(ticket_price).toFixed(decimal_number_points);
            }
            // subtotal display
            single_ticket.find('._sub_total_' + index).text(sub_total_price_format);

            // calculating total qty,price
            total_price += ticket_price;
            total_qty += quantity;

        }

        var total_total_price_format = total_price;
        if (!Number.isInteger(total_price)) {
            total_total_price_format = Number(total_price).toFixed(decimal_number_points);
        }

        variations.find(".variation_total_price").html("").html(total_total_price_format);
        variations.find(".variation_total_qty").html("").html(total_qty);
        variations.find(".variation_picked_total_qty").val("").val(total_qty);

        // disable button
        if (total_qty > 0) {
            $this.find("." + cart_button).removeAttr("disabled").removeClass('disabled');
            single_ticket.find(".etn_ticket_variation").removeClass("variation_qty_error")
        }
        else {
            $this.find("." + cart_button).attr("disabled", "disabled").addClass('disabled');
            single_ticket.find(".etn_ticket_variation").addClass("variation_qty_error")
        }
    }
}