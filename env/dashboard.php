<form method='POST' action='/pages/home.php' style='margin-top:10px'>

    <!-- CLEAR ALL THE LOG FILES -->
    <label for='clear_all_logs' style='display:block;'>
        <input type='checkbox' id='clear_all_logs' name='dashboard[]' value='clear_all_logs'/>
        Clear Logs
    </label>

    <!-- CONFIGURE THE APPLICATION FROM SCRATCH -->
    <label for='configure_from_scratch' style='display:block;'>
        <input disabled type='checkbox' id='configure_from_scratch' name='dashboard[]' value='configure_from_scratch'/>
        Configure From Scratch
    </label>

    <!-- SHOW CONFIGURATION OF THE APPLICATION -->
    <label for='show_config' style='display:block;'>
        <input disabled type='checkbox' id='show_config' name='dashboard[]' value='show_config'/>
        Show Configuration
    </label>   
    
    <!-- SHOW GLOBAL ARRAYS (AKA SHOW GLOBAL STATE) -->
    <label for='show_global_arrays' style='display:block;'>
        <input type='checkbox' id='show_global_arrays' name='dashboard[]' value='show_global_arrays'/>
        Show Global Arrays
    </label>

    <!-- RESET THE SESSION -->
    <label for='reset_session' style='display:block;'>
        <input type='checkbox' id='reset_session' name='dashboard[]' value='reset_session'/>
        Reset Session
    </label>

    <!-- CHECK THE CONNECTION TO THE DATABASE -->
    <label for='check_db_connection' style='display:block;'>
        <input type='checkbox' id='check_db_connection' name='dashboard[]' value='check_db_connection'/>
        Check Database Connection
    </label>

    <!-- SUMBIT BUTTON -->
    <input type='submit' value='Submit' name='dashboard_submit' style='margin-top:10px'/>
</form>