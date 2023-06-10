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
 * Time progress
 */
function timeProgress() {
    const hour = currentHour(),
        mitune = currentMinute()

    if (hour < 9) {
        progress = 0
    } else if (hour > 23) {
        progress = 100
    } else {
        progress = ((hour - 9) * 60 + mitune) * 100 / (15 * 60)
    }

    const progressBar = $('.timeprogress')
    progressBar.css('top', progress + '%')
}

function currentHour() {
    const formatter = new Intl.DateTimeFormat([], {
        timeZone: timezone(),
        hour12: false,
        hour: 'numeric',
    })

    const hour = formatter.format(new Date())

    return parseInt(hour)
}

function currentMinute() {
    const formatter = new Intl.DateTimeFormat([], {
        timeZone: timezone(),
        minute: 'numeric',
    })

    const minute = formatter.format(new Date())

    return parseInt(minute)
}

function timezone() {
    return 'America/New_York'
}

timeProgress()
setInterval(timeProgress, 60 * 1000)