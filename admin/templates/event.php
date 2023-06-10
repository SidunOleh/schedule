<div class="timetable__event event"
    data-id="<?php echo $event->id ?>"
    data-timestamp="<?php echo $event->event_timestamp ?>">
    
    <div class="event__type">
        <?php echo $event->event_type ?>
    </div>
    
    <div class="event__name">
        <?php echo $event->event_title ?>
    </div>

</div>