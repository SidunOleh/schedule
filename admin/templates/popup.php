<div id="event-form-popup" style="display:none;">

    <div class="event-form">

        <div class="error d-none"></div>
        
        <div class="event-form__fields">
            <div class="event-form__input">
                <label for="event-date"><?php _e( 'Event Date' ) ?>: </label>
                <input type="text" name="type" id="event-date" disabled>
            </div>

            <div class="event-form__input">
                <label for="event-time"><?php _e( 'Event Time' ) ?>: </label>
                <input type="text" name="type" id="event-time" disabled>
            </div>

            <div class="event-form__input">
                <label for="event-type"><?php _e( 'Event Type' ) ?>: </label>
                <input type="text" name="type" id="event-type">
            </div>

            <div class="event-form__input">
                <label for="event-title"><?php _e( 'Event Title' ) ?>: </label>
                <input type="text" name="title" id="event-title">
            </div>
        </div>

        <button class="event-form__bnt button button-primary" id="event-add-btn">
            <?php _e( 'Add' ) ?>
        </button>

    </div>

</div>