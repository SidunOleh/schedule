/**
 * Get schedule
 */
$(document).on('click', '.timetable__arrow', getSchedule)

function getSchedule(e) {
    let start = $('.timetable__day')
        .first()
        .attr('data-timestamp')
    let end = $('.timetable__day')
        .last()
        .attr('data-timestamp')

    const dayInSeconds = 24 * 60 * 60

    const arrow = $(e.currentTarget)
    if (arrow.hasClass('prev')) {
        start = parseInt(start) - dayInSeconds
        end = parseInt(end) - dayInSeconds
    }
    if (arrow.hasClass('next')) {
        start = parseInt(start) + dayInSeconds
        end = parseInt(end) + dayInSeconds
    }

    $('.schedule').addClass('loading')

    $.ajax('/wp-admin/admin-ajax.php', {
        type: 'GET',
        data: {
            action: 'get_schedule',
            start,
            end,
        },
        success: data =>
            $('.schedule').replaceWith(data.schedule_html),
        error: res =>
            $('.schedule').removeClass('loading'),
    })
}

/**
 * Show event form
 */
$(document).on('click', '.timetable__event.empty', showEventForm)

// selected date
let selectedDateTime = null

function showEventForm(e) {
    tb_show(
        'Add Event',
        '/?TB_inline&inlineId=event-form-popup&width=310&height=300'
    );

    selectedDateTime = $(e.currentTarget)

    const timestamp = selectedDateTime.attr('data-timestamp') * 1000

    $('#event-date').val(formatDate(timestamp))
    $('#event-time').val(formatTime(timestamp))
    $('#event-type').val('')
    $('#event-title').val('')
    const errorElem = $('.event-form .error')
    errorElem.addClass('d-none')
}

// get date from timestamp
function formatDate(timestamp) {
    const formatter = new Intl.DateTimeFormat([], {
        timeZone: timezone(),
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    })

    const date = formatter.format(new Date(timestamp))

    return date
}

// get time from timestamp
function formatTime(timestamp) {
    const formatter = new Intl.DateTimeFormat([], {
        timeZone: timezone(),
        hour12: false,
        hour: 'numeric',
        minute: 'numeric',
    })

    const time = formatter.format(new Date(timestamp))

    return time
}

// get timezone
function timezone() {
    return 'America/New_York'
}

/**
 * Add new event
 */
$('#event-add-btn').click(addEvent)

function addEvent(e) {
    const type = $('#event-type').val(),
        title = $('#event-title').val(),
        timestamp = selectedDateTime.attr('data-timestamp')

    $.ajax('/wp-admin/admin-ajax.php', {
        type: 'POST',
        data: {
            action: 'create_event',
            type,
            title,
            timestamp,
        },
        success: data => {
            selectedDateTime.replaceWith(data.event_html)
            tb_remove()
        },
        error: res => {
            const errorMsg = res.responseJSON.data.message

            const errorElem = $('.event-form .error')
            errorElem.removeClass('d-none')
            errorElem.text(errorMsg)
        }
    })
}

/**
 * Delete event
 */
$(document).on('click', '.timetable__event.event', deleteEvent)

function deleteEvent(e) {
    if (! confirm('Are you sure?')) {
        return
    }

    const event = $(e.currentTarget)
    const eventId = event.attr('data-id')

    $.ajax('/wp-admin/admin-ajax.php', {
        type: 'POST',
        data: {
            action: 'delete_event',
            id: eventId,
        },
        success: data => {
            if (! data.status) return

            event.html('')
            event.removeClass('event')
            event.addClass('empty')
            event.removeAttr('data-id')
        }
    })
}