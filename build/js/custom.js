/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var CURRENT_URL = window.location.href.split('?')[0],
    $BODY = $('body'),
    $MENU_TOGGLE = $('#menu_toggle'),
    $SIDEBAR_MENU = $('#sidebar-menu'),
    $SIDEBAR_FOOTER = $('.sidebar-footer'),
    $LEFT_COL = $('.left_col'),
    $RIGHT_COL = $('.right_col'),
    $NAV_MENU = $('.nav_menu'),
    $FOOTER = $('footer');

// Sidebar
$(document).ready(function() {
    // TODO: This is some kind of easy fix, maybe we can improve this
    var setContentHeight = function () {
        // reset height
        $RIGHT_COL.css('min-height', $(window).height());

        var bodyHeight = $BODY.outerHeight(),
            footerHeight = $BODY.hasClass('footer_fixed') ? 0 : $FOOTER.height(),
            leftColHeight = $LEFT_COL.eq(1).height() + $SIDEBAR_FOOTER.height(),
            contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;

        // normalize content
        contentHeight -= $NAV_MENU.height() + footerHeight;

        $RIGHT_COL.css('min-height', contentHeight);
    };

    $SIDEBAR_MENU.find('a').on('click', function(ev) {
        var $li = $(this).parent();

        if ($li.is('.active')) {
            $li.removeClass('active active-sm');
            $('ul:first', $li).slideUp(function() {
                setContentHeight();
            });
        } else {
            // prevent closing menu if we are on child menu
            if (!$li.parent().is('.child_menu')) {
                // AGGIUNGERE PER CHIUDERE LE SEZIONI DEL MENU (
                // PER AVERNE SOLO UNA ATTIVA )
                //$SIDEBAR_MENU.find('li').removeClass('active active-sm');
                //$SIDEBAR_MENU.find('li ul').slideUp();
            }
            
            $li.addClass('active');

            $('ul:first', $li).slideDown(function() {
                setContentHeight();
            });
        }
    });

    // toggle small or large menu
    $MENU_TOGGLE.on('click', function() {
        if ($BODY.hasClass('nav-md')) {
            $SIDEBAR_MENU.find('li.active ul').hide();
            $SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
        } else {
            $SIDEBAR_MENU.find('li.active-sm ul').show();
            $SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
        }

        $BODY.toggleClass('nav-md nav-sm');

        setContentHeight();
    });

    // check active menu
    $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('current-page');

    $SIDEBAR_MENU.find('a').filter(function () {
        return this.href == CURRENT_URL;
    }).parent('li').addClass('current-page').parents('ul').slideDown(function() {
        setContentHeight();
    }).parent().addClass('active');

    // recompute content when resizing
    $(window).smartresize(function(){  
        setContentHeight();
    });

    setContentHeight();

    // fixed sidebar
    if ($.fn.mCustomScrollbar) {
        $('.menu_fixed').mCustomScrollbar({
            autoHideScrollbar: true,
            theme: 'minimal',
            mouseWheel:{ preventDefault: true }
        });
    }
});
// /Sidebar

// Panel toolbox
$(document).ready(function() {
    $('.collapse-link').on('click', function() {
        var $BOX_PANEL = $(this).closest('.x_panel'),
            $ICON = $(this).find('i'),
            $BOX_CONTENT = $BOX_PANEL.find('.x_content');
        
        // fix for some div with hardcoded fix class
        if ($BOX_PANEL.attr('style')) {
            $BOX_CONTENT.slideToggle(200, function(){
                $BOX_PANEL.removeAttr('style');
            });
        } else {
            $BOX_CONTENT.slideToggle(200); 
            $BOX_PANEL.css('height', 'auto');  
        }

        $ICON.toggleClass('fa-chevron-up fa-chevron-down');
    });

    $('.close-link').click(function () {
        var $BOX_PANEL = $(this).closest('.x_panel');

        $BOX_PANEL.remove();
    });
});
// /Panel toolbox

// Tooltip
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });
});
// /Tooltip

// Progressbar
if ($(".progress .progress-bar")[0]) {
    $('.progress .progress-bar').progressbar();
}
// /Progressbar

// Switchery
$(document).ready(function() {
    if ($(".js-switch")[0]) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {
                color: '#26B99A'
            });
        });
    }
});
// /Switchery

// iCheck
$(document).ready(function() {
    if ($("input.flat")[0]) {
        $(document).ready(function () {
            $('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
        });
    }
});
// /iCheck

// Table
$('table input').on('ifChecked', function () {
    checkState = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('table input').on('ifUnchecked', function () {
    checkState = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});

var checkState = '';

$('.bulk_action input').on('ifChecked', function () {
    checkState = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('.bulk_action input').on('ifUnchecked', function () {
    checkState = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});
$('.bulk_action input#check-all').on('ifChecked', function () {
    checkState = 'all';
    countChecked();
});
$('.bulk_action input#check-all').on('ifUnchecked', function () {
    checkState = 'none';
    countChecked();
});

function countChecked() {
    if (checkState === 'all') {
        $(".bulk_action input[name='table_records']").iCheck('check');
    }
    if (checkState === 'none') {
        $(".bulk_action input[name='table_records']").iCheck('uncheck');
    }

    var checkCount = $(".bulk_action input[name='table_records']:checked").length;

    if (checkCount) {
        $('.column-title').hide();
        $('.bulk-actions').show();
        $('.action-cnt').html(checkCount + ' Records Selected');
    } else {
        $('.column-title').show();
        $('.bulk-actions').hide();
    }
}

// Accordion
$(document).ready(function() {
    $(".expand").on("click", function () {
        $(this).next().slideToggle(200);
        $expand = $(this).find(">:first-child");

        if ($expand.text() == "+") {
            $expand.text("-");
        } else {
            $expand.text("+");
        }
    });
});

// NProgress
if (typeof NProgress != 'undefined') {
    $(document).ready(function () {
        NProgress.start();
    });

    $(window).load(function () {
        NProgress.done();
    });
}
/**
 * Resize function without multiple trigger
 * 
 * Usage:
 * $(window).smartresize(function(){  
 *     // code here
 * });
 */
(function($,sr){
    // debouncing function from John Hann
    // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
    var debounce = function (func, threshold, execAsap) {
      var timeout;

        return function debounced () {
            var obj = this, args = arguments;
            function delayed () {
                if (!execAsap)
                    func.apply(obj, args);
                timeout = null; 
            }

            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);

            timeout = setTimeout(delayed, threshold || 100); 
        };
    };

    // smartresize 
    jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');


$(document).ready(function() {

        // validate signup form on keyup and submit
        $("#user_modification").validate({

            rules: {
                name: {
                    required: true,
                    maxlength: 50
                },
                add_password: {
                    required: true,
					minlength : 8,
                    maxlength: 16
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 64,
                },
                idente: {
                    required: true,   
                    maxlength: 35                 
                },
                dipartimento: {
                    required: true,   
                    maxlength: 64  
                },
                colore: {   
                    maxlength: 30                 
                },
                sconto: {
                    required: true,
                    digits: true
                },
                sconto_bonus: {
                    required: true,
                    digits: true
                },
                rendita: {
                    required: true,
                    digits: true
                },
                rendita_reseller: {
                    required: true,
                    digits: true
                },
                zone: {
                    required: true
                    
                }
            },
            messages: {
                name: {
                    required: "Please enter a name",
                    maxlength: "Name must be less than 50 charcters"
                },
                add_password: {
                    required: "Please enter a password",
					minlength : "Password must at least 6 characters long",
                    maxlength: "Password must be less than 16 characters"
                },
				email: {
                    required: "Please enter emaail address",
                    email: "Please enter valid email address",
                    maxlength: "Email character must be less than 64 characters",
                },
                idente: {
                    required: "Please enter a idente",
                    maxlength: "Your idente maximum length should be 35 characters"
                },
                dipartimento: {
                    required: "Please enter a dipartimento",
                    maxlength: "Your dipartimento maximum length should be 64 characters"
                },
                colore: {   
                    maxlength: "Your colore maximum length should be 30 characters"
                },
                sconto: {
                    required: "Please enter a sconto",
                    digits: "only digits allowed"
                },
                sconto_bonus: {
                    required: "Please enter a sconto_bonus",
                    digits: "only digits allowed"
                },
                rendita: {
                    required: "Please enter a rendita",
                    digits: "only digits allowed"
                },
                rendita_reseller: {
                    required: "Please enter a rendita_reseller",
                    digits: "only digits allowed"
                },
                zone: {
                   required: "Please enter a zone"
                }
            }

        });

        $.validator.setDefaults({
        ignore: []
    });
        


        // validate signup form on keyup and submit
        $("#addalert").validate({

            rules: {
                nome_alert: {
                    required: true,
                },
                tipo_alert: {
                    required: true,
                },
                ente: {
                    required: true,
                },
                ruolo: {
                    required: true,              
                }
            },
            messages: {
                nome_alert: {
                    required: "Please enter a alert name"
                },
                tipo_alert: {
                    required: "Please Select a alert type"
                },
                ente: {
                    required: "Please Select a ente"
                },
                ruolo: {
                    required: "Please Select a role"                    
                }
            }

        });


        // validate notification form on keyup and submit
        $("#addnotification").validate({

            rules: {
                type: {
                    required: true,
                },
                tempo_avviso: {
                    required: true
                },
                modulo: {
                    required: true,
                },
                ruolo: {
                    required: true,              
                }
            },
            messages: {
                type: {
                    required: "Please enter a notification type"
                },
                tempo_avviso: {
                    required: "Please enter a notification tempo di avviso"
                },
                modulo: {
                    required: "Please Select a modulo"
                },
                ruolo: {
                    required: "Please Select a role"                    
                }
            }

        });

        // validate taxation form on keyup and submit
        $("#taxation_form").validate({

            rules: {
                tassazione_nome: {
                    required: true,
					maxlength: 35
                },
                tassazione_percentuale: {
                    required: true,
                    digits: true
                }
            },
            messages: {
                tassazione_nome: {
                    required: "Please enter a Tassazione name",
					maxlength: "Please enter less than 35 charcters"
                },
                tassazione_percentuale: {
                    required: "Please enter Tassazione Percentuale",
                    digits: "only digits allowed"
                }
            }

        });

        // validate provincie form on keyup and submit
        $("#provincie_form").validate({
            
            rules: {
                stato: {
                    required: true,
                },
                citta: {
                    required: true,
                },
                provincie: {
                    required: true,
                    digits: true
                }
            },
            messages: {
                stato: {
                    required: "Please Select a state name"
                },
                citta: {
                    required: "Please enter a city name"
                },
                provincie: {
                    required: "Please enter a provincie",
                    digits: "only digits allowed"
                }
            }

        });

});

// Accordion
$(document).ready(function() {
    $("#languageSwicher").change(function () {
		var locale =$(this).val();
		var _token = $("input[name=_token]").val();
		var saveData = $.ajax({
		  type: "GET",
		  url: "./language",
		  data: {locale:locale, _token:_token},
		  dataType: "json",
		  success: function(resultData){
			  
		  },
		  complete: function(){
			  window.location.reload(true);
		  }
		});
    });
});
