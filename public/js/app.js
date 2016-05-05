$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.datetimepicker.setLocale('ru');
    $('.datetimepicker').datetimepicker();

    $('.datetimepicker2').datetimepicker({
        format:'Y-m-d H:i:s'
    });

    $.material.init();
});
$(document).ready(function() {
    $('#split').split({
        orientation: 'horizontal',
        limit: 10,
    });


    //clear modal form for event editing
    $('body').on('click', '.event_edit', function (e) {
        var eventId = $(this).data('event-id');
        $.get('/events/' + eventId + '/edit', function (data) {
            $('.update_modal_event .modal-content').html(data);
            $('.update_modal_event').modal('show');
            $('.datetimepicker2').datetimepicker();
        })
    });

    // Update event
    $('body').on('submit', '.events_update', function (e) {
        e.preventDefault();
        var event_id = $(this).find('input[type=submit]').data('event-id'),
            responsible_id = $(this).find('.responsible_id').val(),
            company_id = $('.add_event').data('company-id'),
            type = $(this).find('.event_type').val(),
            text = $(this).find('.event_text').val(),
            date = $(this).find('.event_date').val(),
            reminder = $('.event_reminder').prop('checked') ? 1 : 0;

        $.ajax({
            url: '/events/' + event_id,
            type: 'put',
            data: {
                'responsible_id': responsible_id,
                'company_id': company_id,
                'type': type,
                'text': text,
                'date': date,
                'reminder': reminder
            },
            success: function (data) {
                $('.update_modal_event').modal('hide');
                console.log(text);
                // Get events for company
                $.ajax({
                    url: 'events-company/' + company_id,
                    type: 'get',
                    data: {
                        'companyId': company_id
                    },
                    success: function (data) {
                        $('#events').html(data);
                    }
                });
            }
        });
    });

    // Delete event
    $('body').on('click', '.event-destroy', function () {
        var eventId = $(this).data('event-id');
        var tr = $(this).closest('tr');

        $.confirm({
            title: 'Удалить предприятие',
            theme: 'black',
            confirmButton: 'Удалить',
            cancelButton: 'Отмена',
            content: 'Вы уверены, что хотите удалить это событие?<br>Эта операция не восстановима.',
            confirm: function () {
                $.ajax({
                    url: 'events/' + eventId,
                    type: 'delete',
                    success: function (data) {
                        tr.fadeOut(400, function () {
                            tr.remove();
                        });
                    }
                });
            }
        });

    });

});
/*!
 * JQuery Spliter Plugin version 0.20.1
 * Copyright (C) 2010-2016 Jakub Jankiewicz <http://jcubic.pl>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
(function($, undefined) {
    var count = 0;
    var splitter_id = null;
    var splitters = [];
    var current_splitter = null;
    $.fn.split = function(options) {
        var data = this.data('splitter');
        if (data) {
            return data;
        }
        var panel_1;
        var panel_2;
        var settings = $.extend({
            limit: 100,
            orientation: 'horizontal',
            position: '50%',
            invisible: false,
            onDragStart: $.noop,
            onDragEnd: $.noop,
            onDrag: $.noop
        }, options || {});
        this.settings = settings;
        var cls;
        var children = this.children();
        if (settings.orientation == 'vertical') {
            panel_1 = children.first().addClass('left_panel');
            panel_2 = panel_1.next().addClass('right_panel');
            cls = 'vsplitter';
        } else if (settings.orientation == 'horizontal') {
            panel_1 = children.first().addClass('top_panel');
            panel_2 = panel_1.next().addClass('bottom_panel');
            cls = 'hsplitter';
        }
        if (settings.invisible) {
            cls += ' splitter-invisible';
        }
        var width = this.width();
        var height = this.height();
        var id = count++;
        this.addClass('splitter_panel');
        var splitter = $('<div/>').addClass(cls).bind('mouseenter touchstart', function() {
            splitter_id = id;
        }).bind('mouseleave touchend', function() {
            splitter_id = null;
        }).insertAfter(panel_1);
        var position;

        function get_position(position) {
            if (typeof position === 'number') {
                return position;
            } else if (typeof position === 'string') {
                var match = position.match(/^([0-9\.]+)(px|%)$/);
                if (match) {
                    if (match[2] == 'px') {
                        return +match[1];
                    } else {
                        if (settings.orientation == 'vertical') {
                            return (width * +match[1]) / 100;
                        } else if (settings.orientation == 'horizontal') {
                            return (height * +match[1]) / 100;
                        }
                    }
                } else {
                    //throw position + ' is invalid value';
                }
            } else {
                //throw 'position have invalid type';
            }
        }

        var self = $.extend(this, {
            refresh: function() {
                var new_width = this.width();
                var new_height = this.height();
                if (width != new_width || height != new_height) {
                    width = this.width();
                    height = this.height();
                    self.position(position);
                }
            },
            position: (function() {
                if (settings.orientation == 'vertical') {
                    return function(n, silent) {
                        if (n === undefined) {
                            return position;
                        } else {
                            position = get_position(n);
                            var sw = splitter.width();
                            var sw2 = sw/2, pw;
                            if (settings.invisible) {
                                pw = panel_1.width(position).outerWidth();
                                panel_2.width(self.width()-pw);
                                splitter.css('left', pw-sw2);
                            } else {
                                pw = panel_1.width(position-sw2).outerWidth();
                                panel_2.width(self.width()-pw-sw);
                                splitter.css('left', pw);
                            }
                        }
                        if (!silent) {
                            self.trigger('splitter.resize');
                            self.find('.splitter_panel').trigger('splitter.resize');
                        }
                        return self;
                    };
                } else if (settings.orientation == 'horizontal') {
                    return function(n, silent) {
                        if (n === undefined) {
                            return position;
                        } else {
                            position = get_position(n);
                            var sw = splitter.height();
                            var sw2 = sw/2, pw;
                            if (settings.invisible) {
                                pw = panel_1.height(position).outerHeight();
                                panel_2.height(self.height()-pw);
                                splitter.css('top', pw-sw2);
                            } else {
                                pw = panel_1.height(position-sw2).outerHeight();
                                panel_2.height(self.height()-pw-sw);
                                splitter.css('top', pw);
                            }
                        }
                        if (!silent) {
                            self.trigger('splitter.resize');
                            self.find('.splitter_panel').trigger('splitter.resize');
                        }
                        return self;
                    };
                } else {
                    return $.noop;
                }
            })(),
            orientation: settings.orientation,
            limit: settings.limit,
            isActive: function() {
                return splitter_id === id;
            },
            destroy: function() {
                self.removeClass('splitter_panel');
                splitter.unbind('mouseenter');
                splitter.unbind('mouseleave');
                splitter.unbind('touchstart');
                splitter.unbind('touchmove');
                splitter.unbind('touchend');
                splitter.unbind('touchleave');
                splitter.unbind('touchcancel');
                if (settings.orientation == 'vertical') {
                    panel_1.removeClass('left_panel');
                    panel_2.removeClass('right_panel');
                } else if (settings.orientation == 'horizontal') {
                    panel_1.removeClass('top_panel');
                    panel_2.removeClass('bottom_panel');
                }
                self.unbind('splitter.resize');
                self.trigger('splitter.resize');
                self.find('.splitter_panel').trigger('splitter.resize');
                splitters[i] = null;
                count--;
                splitter.remove();
                self.removeData('splitter');
                var not_null = false;
                for (var i=splitters.length; i--;) {
                    if (splitters[i] !== null) {
                        not_null = true;
                        break;
                    }
                }
                //remove document events when no splitters
                if (!not_null) {
                    $(document.documentElement).unbind('.splitter');
                    $(window).unbind('resize.splitter');
                    splitters = [];
                    count = 0;
                }
            }
        });
        self.bind('splitter.resize', function(e) {
            var pos = self.position();
            if (self.orientation == 'vertical' &&
                pos > self.width()) {
                pos = self.width() - self.limit-1;
            } else if (self.orientation == 'horizontal' &&
                pos > self.height()) {
                pos = self.height() - self.limit-1;
            }
            if (pos < self.limit) {
                pos = self.limit + 1;
            }
            e.stopPropagation();
            self.position(pos, true);
        });
        //inital position of splitter
        var pos;
        if (settings.orientation == 'vertical') {
            if (pos > width-settings.limit) {
                pos = width-settings.limit;
            } else {
                pos = get_position(settings.position);
            }
        } else if (settings.orientation == 'horizontal') {
            //position = height/2;
            if (pos > height-settings.limit) {
                pos = height-settings.limit;
            } else {
                pos = get_position(settings.position);
            }
        }
        if (pos < settings.limit) {
            pos = settings.limit;
        }
        self.position(pos, true);
        if (splitters.length === 0) { // first time bind events to document
            $(window).bind('resize.splitter', function() {
                $.each(splitters, function(i, splitter) {
                    if (splitter) {
                        splitter.refresh();
                    }
                });
            });
            $(document.documentElement).on('mousedown.splitter touchstart.splitter', function(e) {
                if (splitter_id !== null) {
                    current_splitter = splitters[splitter_id];
                    setTimeout(function() {
                        $('<div class="splitterMask"></div>').
                        css('cursor', current_splitter.children().eq(1).css('cursor')).
                        insertAfter(current_splitter);
                    });
                    current_splitter.settings.onDragStart(e);
                }
            }).bind('mouseup.splitter touchend.splitter touchleave.splitter touchcancel.splitter', function(e) {
                if (current_splitter) {
                    setTimeout(function() {
                        $('.splitterMask').remove();
                    });
                    current_splitter.settings.onDragEnd(e);
                    current_splitter = null;
                }
            }).bind('mousemove.splitter touchmove.splitter', function(e) {
                if (current_splitter !== null) {
                    var limit = current_splitter.limit;
                    var offset = current_splitter.offset();
                    if (current_splitter.orientation == 'vertical') {
                        var pageX = e.pageX;
                        if(e.originalEvent && e.originalEvent.changedTouches){
                            pageX = e.originalEvent.changedTouches[0].pageX;
                        }
                        var x = pageX - offset.left;
                        if (x <= current_splitter.limit) {
                            x = current_splitter.limit + 1;
                        } else if (x >= current_splitter.width() - limit) {
                            x = current_splitter.width() - limit - 1;
                        }
                        if (x > current_splitter.limit &&
                            x < current_splitter.width()-limit) {
                            current_splitter.position(x, true);
                            current_splitter.trigger('splitter.resize');
                            current_splitter.find('.splitter_panel').
                            trigger('splitter.resize');
                            //e.preventDefault();
                        }
                    } else if (current_splitter.orientation == 'horizontal') {
                        var pageY = e.pageY;
                        if(e.originalEvent && e.originalEvent.changedTouches){
                            pageY = e.originalEvent.changedTouches[0].pageY;
                        }
                        var y = pageY-offset.top;
                        if (y <= current_splitter.limit) {
                            y = current_splitter.limit + 1;
                        } else if (y >= current_splitter.height() - limit) {
                            y = current_splitter.height() - limit - 1;
                        }
                        if (y > current_splitter.limit &&
                            y < current_splitter.height()-limit) {
                            current_splitter.position(y, true);
                            current_splitter.trigger('splitter.resize');
                            current_splitter.find('.splitter_panel').
                            trigger('splitter.resize');
                            //e.preventDefault();
                        }
                    }
                    current_splitter.settings.onDrag(e);
                }
            });//*/
        }
        splitters[id] = self;
        self.data('splitter', self);
        return self;
    };
})(jQuery);
(function () {

    if(!$('.full-access').prop('checked')) {
        $('.not-full-access').show();
    }

    $('.full-access').on('click', function() {
        if(!$('.full-access').prop('checked')) {
            $('.not-full-access').show();
        } else {
            $('.not-full-access').hide();
        }
    });

})();
(function ($, DataTable) {
    "use strict";

    var _buildUrl = function(dt, action) {
        var url = dt.ajax.url() || '';
        var params = dt.ajax.params();
        params.action = action;

        return url + '?' + $.param(params);
    };

    DataTable.ext.buttons.excel = {
        className: 'buttons-excel',

        text: function (dt) {
            return '<i class="fa fa-file-excel-o"></i> ' + dt.i18n('buttons.excel', 'Excel');
        },

        action: function (e, dt, button, config) {
            var url = _buildUrl(dt, 'excel');
            window.location = url;
        }
    };

    DataTable.ext.buttons.csv = {
        className: 'buttons-csv',

        text: function (dt) {
            return '<i class="fa fa-file-excel-o"></i> ' + dt.i18n('buttons.csv', 'CSV');
        },

        action: function (e, dt, button, config) {
            var url = _buildUrl(dt, 'csv');
            window.location = url;
        }
    };

    DataTable.ext.buttons.pdf = {
        className: 'buttons-pdf',

        text: function (dt) {
            return '<i class="fa fa-file-pdf-o"></i> ' + dt.i18n('buttons.pdf', 'PDF');
        },

        action: function (e, dt, button, config) {
            var url = _buildUrl(dt, 'pdf');
            window.location = url;
        }
    };

    DataTable.ext.buttons.print = {
        className: 'buttons-print',

        text: function (dt) {
            return  '<i class="fa fa-print"></i> ' + dt.i18n('buttons.print', 'Print');
        },

        action: function (e, dt, button, config) {
            var url = _buildUrl(dt, 'print');
            window.location = url;
        }
    };

    DataTable.ext.buttons.reset = {
        className: 'buttons-reset',

        text: function (dt) {
            return '<i class="fa fa-undo"></i> ' + dt.i18n('buttons.reset', 'Reset');
        },

        action: function (e, dt, button, config) {
            dt.search('').draw();
        }
    };

    DataTable.ext.buttons.reload = {
        className: 'buttons-reload',

        text: function (dt) {
            return '<i class="fa fa-refresh"></i> ' + dt.i18n('buttons.reload', 'Reload');
        },

        action: function (e, dt, button, config) {
            dt.draw(false);
        }
    };

    DataTable.ext.buttons.create = {
        className: 'buttons-create',

        text: function (dt) {
            return '<i class="fa fa-plus"></i> ' + dt.i18n('buttons.create', 'Create');
        },

        action: function (e, dt, button, config) {
            window.location = window.location.href.replace(/\/+$/, "") + '/create';
        }
    };
})(jQuery, jQuery.fn.dataTable);

//# sourceMappingURL=app.js.map
