<div class="schedule">
        
    <div class="schedule__body timetable">
        
        <div class="timetable__top">
            <div class="timetable__arrow prev">
                <img src="<?php echo plugin_dir_url( SCHEDULE_ROOT . '/schedule.php' ) ?>admin/img/prev.svg" alt="">
            </div>

            <div class="timetable__days">

                <?php foreach ( $daterange as $date ) : ?>
                    
                    <div class="timetable__day <?php echo is_current_date( $date ) ? 'current' : '' ?>" 
                        data-timestamp="<?php echo $date->getTimestamp() ?>">
                    
                        <div class="timetable__dayname">
                            <?php echo $date->format( 'l' ) ?>
                        </div>
                        
                        <div class="timetable__date">
                            <?php echo $date->format( 'M d, Y' ) ?>
                        </div>
                    
                    </div>
            
                <?php endforeach ?>

            </div>

            <div class="timetable__arrow next">
                <img src="<?php echo plugin_dir_url( SCHEDULE_ROOT . '/schedule.php' ) ?>admin/img/next.svg" alt="">
            </div>
        </div>

        <div class="timetable__body">
                
            <?php for( $hour = 9; $hour <= 23; $hour++ ) : ?>
            
                <div class="timetable__row">
                    
                    <div class="timetable__time">
                        <?php echo str_pad( $hour, 2, '0', STR_PAD_LEFT ) . ':00' ?>
                    </div>
                    
                    <div class="timetable__events">
                        
                        <?php foreach ( $daterange as $date ) : ?>

                                <?php $timestamp = $date->setTime( $hour, 0 )->getTimestamp() ?>

                                <?php if ( $event = find_event_by_timestamp( $timestamp, $events ) ) : ?>
                        
                                    <div class="timetable__event event"
                                        data-id="<?php echo $event->id ?>"
                                        data-timestamp="<?php echo $timestamp ?>">
                                        
                                        <div class="event__type">
                                            <?php echo $event->event_type ?>
                                        </div>
                                        
                                        <div class="event__name">
                                            <?php echo $event->event_title ?>
                                        </div>
                                    
                                    </div>

                                <?php else : ?>
                    
                                    <div class="timetable__event empty"
                                        data-timestamp="<?php echo $timestamp ?>">
                                    </div>

                                <?php endif ?>
                            
                        <?php endforeach ?>

                    </div>
                    
                </div>
                                
            <?php endfor ?>

        </div>

    </div>

</div>