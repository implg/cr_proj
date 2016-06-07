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
            $.material.init();
            setTimeout(function() {
                $('.datetimepicker3').datetimepicker();
                $('.datetimepicker3').datetimepicker('show');
                setTimeout(function() {
                    $('.datetimepicker3').datetimepicker('hide');
                },100)
            },700)
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
            taskComplete = $(this).find('.taskComplete').val(),
            date = $(this).find('.event_date').val(),
            status = $(this).find('.event_status').val(),
            reminder = $('.event_reminder').prop('checked') ? 1 : 0;
        $.ajax({
            url: '/events/' + event_id,
            type: 'put',
            data: {
                'responsible_id': responsible_id,
                'company_id': company_id,
                'type': type,
                'text': text,
                'taskComplete': taskComplete,
                'date': date,
                'reminder': reminder,
                'status': status
            },
            success: function (data) {
                $('.update_modal_event').modal('hide');
                // Get events for company
                if(company_id) {
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
                } else {
                    window.location.reload();
                }
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

    // Tasks

    $(document).on('change', '.change_task #status', function() {
        var status = $(this).val();
        if(status == 2) {
            $('.comment-task-complete').slideDown();
        }
    });

});