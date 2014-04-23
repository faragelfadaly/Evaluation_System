(function($) {
                $.widget("ui.combobox", {
                    _create: function() {
                        var input,
                                that = this,
                                wasOpen = false,
                                select = this.element.hide(),
                                selected = select.children(":selected"),
                                value = selected.val() ? selected.text() : "",
                                wrapper = this.wrapper = $("<span>")
                                .addClass("ui-combobox")
                                .insertAfter(select);

                        input = $("<input>")
                                .appendTo(wrapper)
                                .val(value)
                                .attr("id", select.attr("id") + '1')
                                .attr("name", select.val())
                                .addClass("ui-state-default ui-combobox-input")
                                .autocomplete({
                            delay: 0,
                            minLength: 0,
                            source: function(request, response) {
                                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                                response(select.children("option").map(function() {

                                    var text = $(this).text();

                                    if (this.value && (!request.term || matcher.test(text)))
                                    {
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

                                    }
                                }));

                            },
                            select: function(event, ui) {

                                ui.item.option.selected = true;
                                input.attr("name", select.val());

                                if (select.attr("id") == "track_name" && select.val() == -2)
                                {
                                    $("#hidinstructor_name").show();
                                }
                                else
                                {
                                    $("#hidinstructor_name").hide();
                                }

                                var fn = window[select.attr("id")];
                                fn.apply(window);

                                that._trigger("selected", event, {
                                    item: ui.item.option

                                });

                            },
                            change: function(event, ui) {
                                if (!ui.item) {
                                    input.attr("name", "-1");
                                    if (select.attr("id") == "track_name")
                                        $("#hidinstructor_name").show();
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