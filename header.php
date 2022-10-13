<?php
session_start();
set_time_limit(0);

ini_set('session.bug_compat_warn', 0);
ini_set('session.bug_compat_42', 0);

extract($_REQUEST);
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
    ob_start("ob_gzhandler");
else
    ob_start();

$currentUrl = new redirectPage($urlpath);
$urlpath = $urlpath;

include('config.php');

$global_company_code = 'iMocha Company';

?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<script type="text/javascript">
    function openScript(url, width, height) {
        var left = (screen.width / 2) - (width / 2);
        var top = (screen.height / 2) - (height / 2);
        var Win = window.open(url, "openScript", 'width=' + width + ',height=' + height + ', top=' + top + ', left=' + left + ', resizable=no,scrollbars=yes,menubar=no,status=no');
    }

    function doPrintMe() {
        var mysave = $('#tobeprint').html();
        $("#formprint input[name=hiddenvalue]").val(mysave);
        $("#formprint input[name=printtype]").val("A4");
        $("#formprint").submit();
    }

    function doPrintMeLandscape() {
        var mysave = $('#tobeprint').html();
        $("#formprint input[name=hiddenvalue]").val(mysave);
        $("#formprint input[name=printtype]").val("A4-L");
        $("#formprint").submit();
    }
</script>
<style type="text/css">
    @media print {
        .no-print, .no-print * {
            display: none !important;
        }
        .to-print, .to-print * {
            display: table-row !important;
        }
    }
    -->
</style>
<style type="text/css" media="print">
    @page {
        size: auto;   /* auto is the initial value */
        margin: 5mm;  /* this affects the margin in the printer settings */
    }
    body {
        background-color:#FFFFFF;
        border: solid 0px black;
        margin: 5mm;  /* this affects the margin on the content before sending to printer */
    }
</style>

<link rel="stylesheet" href="jquery/jquery-ui.css">
<script src="jquery/external/jquery/jquery.js"></script>
<script src="jquery/jquery-ui.js"></script>
<style>
    .custom-combobox {
        position: relative;
        display: inline-block;
    }
    input {
        position: relative;
        display: inline-block;
        margin: 0;
        padding: 5px 10px;
    }
    .custom-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
    }
    .custom-combobox-input {
        margin: 0;
        padding: 5px 10px;
        width:500px; 
    }
</style>
<script>
    jQuery.fn.popupwindow = function (p) {
        var profiles = p || {};
        return this.each(function (index) {
            var settings, parameters, mysettings, b, a, winObj;

            // for overrideing the default settings
            mysettings = (jQuery(this).attr("rel") || "").split(",");

            settings = {
                height: 600, // sets the height in pixels of the window.
                width: 600, // sets the width in pixels of the window.
                toolbar: 0, // determines whether a toolbar (includes the forward and back buttons) is displayed {1 (YES) or 0 (NO)}.
                scrollbars: 0, // determines whether scrollbars appear on the window {1 (YES) or 0 (NO)}.
                status: 0, // whether a status line appears at the bottom of the window {1 (YES) or 0 (NO)}.
                resizable: 1, // whether the window can be resized {1 (YES) or 0 (NO)}. Can also be overloaded using resizable.
                left: 0, // left position when the window appears.
                top: 0, // top position when the window appears.
                center: 0, // should we center the window? {1 (YES) or 0 (NO)}. overrides top and left
                createnew: 1, // should we create a new window for each occurance {1 (YES) or 0 (NO)}.
                location: 0, // determines whether the address bar is displayed {1 (YES) or 0 (NO)}.
                menubar: 0, // determines whether the menu bar is displayed {1 (YES) or 0 (NO)}.
                onUnload: null // function to call when the window is closed
            };

            // if mysettings length is 1 and not a value pair then assume it is a profile declaration
            // and see if the profile settings exists

            if (mysettings.length == 1 && mysettings[0].split(":").length == 1) {
                a = mysettings[0];
                // see if a profile has been defined
                if (typeof profiles[a] != "undefined") {
                    settings = jQuery.extend(settings, profiles[a]);
                }
            } else {
                // overrides the settings with parameter passed in using the rel tag.
                for (var i = 0; i < mysettings.length; i++) {
                    b = mysettings[i].split(":");
                    if (typeof settings[b[0]] != "undefined" && b.length == 2) {
                        settings[b[0]] = b[1];
                    }
                }
            }

            // center the window
            if (settings.center == 1) {
                settings.top = (screen.height - (settings.height + 110)) / 2;
                settings.left = (screen.width - settings.width) / 2;
            }

            parameters = "location=" + settings.location + ",menubar=" + settings.menubar + ",height=" + settings.height + ",width=" + settings.width + ",toolbar=" + settings.toolbar + ",scrollbars=" + settings.scrollbars + ",status=" + settings.status + ",resizable=" + settings.resizable + ",left=" + settings.left + ",screenX=" + settings.left + ",top=" + settings.top + ",screenY=" + settings.top;

            jQuery(this).bind("click", function () {
                var name = settings.createnew ? "PopUpWindow" + index : "PopUpWindow";
                winObj = window.open(this.href, name, parameters);

                if (settings.onUnload) {
                    // Incremental check for window status
                    // Attaching directly to window.onunlaod event causes invoke when document within window is reloaded
                    // (i.e. an inner refresh)
                    unloadInterval = setInterval(function () {
                        if (!winObj || winObj.closed) {
                            clearInterval(unloadInterval);
                            settings.onUnload.call($(this));
                        }
                    }, 500);
                }
                winObj.focus();
                return false;
            });
        });
    };
    
    var profiles = {windowCenter: { height: screen.height, width: screen.width, center: 1 }};

    function unloadcallback() {
        alert("unloaded");
    };

    $(function () {
        $(".popupwindow").popupwindow(profiles);
    });

    (function ($) {
        $.widget("custom.combobox", {
            _create: function () {
                this.wrapper = $("<span>")
                        .addClass("custom-combobox")
                        .insertAfter(this.element);
                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
            },
            _createAutocomplete: function () {
                var selected = this.element.children(":selected"), value = selected.val() ? selected.text() : "";

                this.input = $("<input>")
                        .appendTo(this.wrapper)
                        .val(value)
                        .attr("title", "")
                        .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                        .autocomplete({
                            delay: 0,
                            minLength: 0,
                            source: $.proxy(this, "_source")
                        })
                        .tooltip({
                            tooltipClass: "ui-state-highlight"
                        });

                this._on(this.input, {
                    autocompleteselect: function (event, ui) {
                        ui.item.option.selected = true;
                        this._trigger("select", event, {
                            item: ui.item.option
                        });
                    },
                    autocompletechange: "_removeIfInvalid"
                });
            },
            _createShowAllButton: function () {
                var input = this.input,
                        wasOpen = false;

                $("<a>")
                        .attr("tabIndex", -1)
                        .attr("title", "Show All Items")
                        .tooltip()
                        .appendTo(this.wrapper)
                        .button({
                            icons: {
                                primary: "ui-icon-triangle-1-s"
                            },
                            text: true
                        })
                        .removeClass("ui-corner-all")
                        .addClass("custom-combobox-toggle ui-corner-right")
                        .mousedown(function () {
                            wasOpen = input.autocomplete("widget").is(":visible");
                        })
                        .click(function () {
                            input.focus();

                            // Close if already visible
                            if (wasOpen) {
                                return;
                            }

                            // Pass empty string as value to search for, displaying all results
                            input.autocomplete("search", "");
                        });
            },
            _source: function (request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function () {
                    var text = $(this).text();
                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }));
            },
            _removeIfInvalid: function (event, ui) {

                // Selected an item, nothing to do
                if (ui.item) {
                    //  this.form.submit();
                    $("#form1").submit();
                    //return;
                }

                // Search for a match (case-insensitive)
                var value = this.input.val(),
                        valueLowerCase = value.toLowerCase(),
                        valid = false;
                this.element.children("option").each(function () {
                    if ($(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });

                // Found a match, nothing to do
                if (valid) {
                    return;
                }

                // Remove invalid value
                this.input
                        .val("")
                        .attr("title", value + " didn't match any item")
                        .tooltip("open");
                this.element.val("");
                this._delay(function () {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.autocomplete("instance").term = "";
            },
            _destroy: function () {
                this.wrapper.remove();
                this.element.show();
            }
        });
    })(jQuery);

</script>
<script src="js/jquery.alerts.js" type="text/javascript"></script>
<link href="css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />

<?php require_once('datatable.php'); ?>