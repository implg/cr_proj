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