<?php
include './config.php';
// Get all tracks from database
$tracks_query = executeQuery("select id,name from track");

$tracks = array();
while ($row = mysqli_fetch_assoc($tracks_query)) {
    $tracks[] = array(
        'id' => $row['id'],
        'name' => $row['name']
    );
}
?>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>jQuery UI Autocomplete - Combobox</title>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="/resources/demos/style.css" />
        <style>
            .ui-combobox {
                position: relative;
                display: inline-block;
            }
            .ui-combobox-toggle {
                position: absolute;
                top: 0;
                bottom: 0;
                margin-left: -1px;
                padding: 0;
                /* support: IE7 */
                *height: 1.7em;
                *top: 0.1em;
            }
            .ui-combobox-input {
                margin: 0;
                padding: 0.3em;
            }
        </style>
        <script>
            (function($) {
                $.widget("ui.combobox", {
                    _create: function() {
                        alert($("select").val());
                        var input,
                                that = this,
                                wasOpen = false,
                                select = this.element.hide(),
                                selected = select.children(":selected"),
                                value = selected.val() ? selected.text() : "",
                                wrapper = this.wrapper = $("<span>")
                                .addClass("ui-combobox")
                                .insertAfter(select);
                        function removeIfInvalid(element) {
                            var value = $(element).val(),
                                    matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(value) + "$", "i"),
                                    valid = false;
                            select.children("option").each(function() {
                                if ($(this).text().match(matcher)) {
                                    this.selected = valid = true;
                                    return false;
                                }
                            });
                            if (!valid) {
                                // remove invalid value, as it didn't match anything
                                $(element)
                                        .val("")
                                        .attr("title", value + " didn't match any item")
                                        .tooltip("open");
                                select.val("");
                                setTimeout(function() {
                                    input.tooltip("close").attr("title", "");
                                }, 2500);
                                input.data("ui-autocomplete").term = "";
                            }
                        }
                        input = $("<input>")
                                .appendTo(wrapper)
                                .val(value)
                                .attr("title", "")
                                .addClass("ui-state-default ui-combobox-input")
                                .autocomplete({
                            delay: 0,
                            minLength: 0,
                            source: function(request, response) {
                                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                                response(select.children("option").map(function() {
                                    var text = $(this).text();
                                    if (this.value && (!request.term || matcher.test(text)))
                                        return {
                                            label: text.replace(
                                                    new RegExp(
                                                    "(?![^&;]+;)(?!<[^<>]*)(" +
                                                    $.ui.autocomplete.escapeRegex(request.term) +
                                                    ")(?![^<>]*>)(?![^&;]+;)", "gi"
                                                    ), "<strong>$1</strong>"),
                                            value: text,
                                            option: this
                                        };
                                }));
                            },
                            select: function(event, ui) {
                                ui.item.option.selected = true;
                                that._trigger("selected", event, {
                                    item: ui.item.option
                                });
                            },
                            change: function(event, ui) {
                                if (!ui.item) {
                                    removeIfInvalid(this);
                                }
                            }
                        })
                                .addClass("ui-widget ui-widget-content ui-corner-left");
                        input.data("ui-autocomplete")._renderItem = function(ul, item) {
                            return $("<li>")
                                    .append("<a>" + item.label + "</a>")
                                    .appendTo(ul);
                        };
                        $("<a>")
                                .attr("tabIndex", -1)
                                .attr("title", "Show All Items")
                                .tooltip()
                                .appendTo(wrapper)
                                .button({
                            icons: {
                                primary: "ui-icon-triangle-1-s"
                            },
                            text: false
                        })
                                .removeClass("ui-corner-all")
                                .addClass("ui-corner-right ui-combobox-toggle")
                                .mousedown(function() {
                            wasOpen = input.autocomplete("widget").is(":visible");
                        })
                                .click(function() {
                            input.focus();
                            // close if already visible
                            if (wasOpen) {
                                return;
                            }
                            // pass empty string as value to search for, displaying all results
                            input.autocomplete("search", "");
                        });
                        input.tooltip({
                            tooltipClass: "ui-state-highlight"
                        });
                    },
                    _destroy: function() {
                        this.wrapper.remove();
                        this.element.show();
                    }
                });
            })(jQuery);
            $(function() {
                $("#combobox").combobox();

                $("#toggle").click(function() {
                    // $("#combobox").toggle();
                    alert($("#combobox").val());
                });

            });
        </script>
    </head>
    <body>
        <div class="ui-widget">
            <label>Your preferred programming language: </label>
            <select id="combobox">
                <option></option>
                <?php
                foreach ($tracks as $track) {
                    ?>
                    <option ><?php echo "{$track['name']}"; ?></option>
                    <?php
                }
                ?>

            </select>
            <br><br>
            
            <select id="combobox1">
                <option value="Hello">Hello</option>
                <option value="Good">Good</option>
            </select>
        
        </div>
        <button id="toggle">Add/Edit</button>
    </body>
</html>
