<?php

class DevTool {
   
    public $object_properties_table = '';

    function __construct() {

    }

    function get_object_properties($obj = false) {

        /* Notes about this function below ->

            - If you want to see what a table would look like for a hypothetical an object
              called Music_Ballers, pass false as the argument into this function.

            - Notice it's not possible for a value to be displayed as "unset". If a class property
              has been declared but it's value has not been assigned, the resultant value will be null.
              This is in spite of the fact that calling isset on that property either within the class or
              wherever the object was instantiated would return false, just like it would if the property
              were never even declared in the first place.

            - This function will not work if the visibility of class properties are set to private
        
        */

        if($obj == false) {
            // Create an object for example value reference
            $entity_obj = new Entity();
            $ex = array(
                'value_references' => array(
                    'true' => true,
                    'false' => false,
                    '! true' => ! true,
                    '! false' => ! false,
                    'null' => null,
                    'empty_string' => '',
                    'not_empty_string' => 'this string is not empty',
                    'empty_array' => array(),
                    'not_empty_array' => array(
                        'this',
                        'array',
                        'is',
                        'not',
                        'empty'
                    ),
                    'object' => $entity_obj,
                ),
                'first_name' => 'Shaquille',
                'last_name' => "O'Neal",
                'shoe_size' => 22,
                'discography' => array(
                    'studio_albums' => array(
                        'Shaq Diesel' => array(
                            "Intro",
                            "(I Know I Got) Skillz",
                            "I'm Outstanding",
                            "Where Ya At?",
                            "I Hate 2 Brag",
                            "Let Me In, Let Me In",
                            "Shoot Pass Slam",
                            "Boom!",
                            "Are You a Roughneck?",
                            "Giggin' on 'Em",
                            "What's Up Doc? (Can We Rock)",
                            "Game Over",
                        ),
                        'Shaq Fu: Da Return' => array(
                            "No Hook",
                            "Newark to C.I.",
                            "Biological Didn't Bother (G-Funk Version)",
                            "My Dear",
                            "Shaq's Got It Made",
                            "Mic Check 1-2",
                            "My Style, My Stelo",
                            "(So U Wanna Be) Hardcore",
                            "Nobody",
                            "Freaky Flow",
                            "Biological Didn't Bother (Original Flow)",
                        ),
                        "You Can't Stop the Reign" => array(
                            "Shaquille (Interlude)",
                            "You Can't Stop the Reign",
                            "D.I.V.A. Radio (Interlude)",
                            "It Was All a Dream",
                            "No Love Lost",
                            "Strait Playin'",
                            "Best to Worst",
                            "Legal Money",
                            "Edge of Night",
                            "S.H.E. (Interlude)",
                            "Let's Wait a While",
                            "Can I Play",
                            "Just Be Good to Me",
                            "More to Life",
                            "Big Dog Stomp",
                            "Game of Death",
                            "Outtro (Interlude)",
                            "Player",
                            "Don't Wanna Be Alone",
                        ),
                        'Respect' => array(
                            "Intro",
                            "Fiend '98",
                            "The Way It's Goin' Down (T.W.Is.M. For Life)",
                            "Voices",
                            "Fly Like an Eagle",
                            "The Light of Mine (Interlude)",
                            "Go to Let Me Know",
                            "River (Interlude) (Performed by 1 Accord)",
                            "Heat It Up",
                            "Pool Jam",
                            "Make This a Night to Remember",
                            "Blaq Supaman",
                            "Psycho Rap (Interlude)",
                            "Deeper",
                            "The Bomb Baby",
                            "3 X's Dope",
                            "Like What",
                            "48 @ the Buzzer",
                        ),
                        "Shaquille O'Neal Presents His Superfriends, Vol. 1" => array(
                            "That's Me",
                            "Connected",
                            "Bounce",
                            "Make It Hot",
                            "Strawberry Letter",
                            "I Don't Care",
                            "Do It Faster",
                            "Atomic Dog",
                            "In the Sun",
                            "Y'all Don't Really Want It",
                            "The One",
                            "Big Hat Club",
                            "Psycho",
                            "All in a Day",
                            "No Words",
                        ),
                    ),
                    'music_singles' => array(
                        '(I Know I Got) Skillz',
                        "I'm Outstanding",
                        'Shoot Pass Slam',
                        "Biological Didn't Bother",
                        'No Hook',
                        "You Can't Stop the Reign",
                        "Strait Playin'",
                        "Men of Steel",
                        "The Way It's Goin' Down",
                    ),
                ),

            );

            // Cast the Shaq sized array to an object and assign it to the same namespace as the object passed in when not showing example
            $obj = (object) $ex;
        }
        $this->object_properties_table .= '
            <style>
                table, th, td {
                    border: 1px solid black;
                }
                thead {
                    width: 100%;
                }
                th {
                    background-color: black;
                    color: white;
                    border-center: white;
                }
                th:first-child {
                    border-right: 1px solid white;
                }
                tr:hover {
                    background-color:#A7A7A7;
                }
                .value_references {
                    font-weight: lighter;
                    font-style:italic;
                    color:#bf5c5c;
                }
            </style>
            <table class="table table-sm" style="padding: 1em;">
                <thead>
                    <th>KEY</th>
                    <th>VAL</th>
                </thead>
                <tbody>
        ';
        $arr = get_object_vars($obj);
        foreach($arr as $key => $val) {
            if(!is_array($val)) {
                if(!is_object($val)) {
                    $this->object_properties_table .= "<tr>";
                    $this->object_properties_table .= "<td>$key</td>";
                    if($val === true) {
                        $this->object_properties_table .= "<td class='value_references''>true</td>";
                    }
                    else if($val === false) {
                        $this->object_properties_table .= "<td class='value_references''>false</td>";
                    }
                    elseif($val === null) {
                        $this->object_properties_table .= "<td class='value_references''>null</td>";
                    }
                    elseif($val === '') {
                        $this->object_properties_table .= "<td class='value_references''>empty string</td>";
                    }
                    else {
                        $this->object_properties_table .= "<td>$val</td>";
                    }
                    $this->object_properties_table .= "</tr>";
                }
                else {
                    $val = (object) $val;
                    $this->object_properties_table .= "<tr>";
                    $this->object_properties_table .= "<td>$key</td>";
                    $this->object_properties_table .= "<td>";
                    $this->get_object_properties($val);
                    $this->object_properties_table .= "</td>";
                    $this->object_properties_table .= "</tr>";
                }
            }
            else {
                if(sizeof($val) == 0) {
                    $val = (object) $val;
                    $this->object_properties_table .= "<tr>";
                    $this->object_properties_table .= "<td>$key</td>";
                    $this->object_properties_table .= "<td class='value_references''>";
                    $this->object_properties_table .= "empty array";
                    $this->object_properties_table .= "</td>";
                    $this->object_properties_table .= "</tr>";
                }
                else {
                    $val = (object) $val;
                    $this->object_properties_table .= "<tr>";
                    $this->object_properties_table .= "<td>$key</td>";
                    $this->object_properties_table .= "<td>";
                    $this->get_object_properties($val);
                    $this->object_properties_table .= "</td>";
                    $this->object_properties_table .= "</tr>";
                }
            }
        }
        $this->object_properties_table .= '</tbody></table>';
        return $this->object_properties_table;
    }

    function test_instance() {
        return '<div class="jumbotron">object is instantiated!</div>';
    }

    function print_array($array) {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }

    function console_log($message) {
        $log = "<script>console.log('$message')</script>";
        echo $log;
    }

    function display_error($message) {
        $see_admin_string = '<br><br>Please see the administrator';
        $this->js_alert($message . $see_admin_string);
        
        $this->kill(false);
    }

    function js_alert($message) {
        $log = "<script>alert('$message')</script>";
        echo $log;
    }

    function kill($msg, $debug_backtrace = false) {
        // $this->print_array(debug_backtrace());
        $bt = debug_backtrace();
        $debug_arr = end($bt);
        $path_arr = explode('\\', $debug_arr['file']);
        $file = end($path_arr);
        $line = $debug_arr['line'];
        echo nl2br("\r\n -----| Message: $msg \r\n -----| File: $file \r\n -----| Line: $line \r\n\r\n ");
        if($debug_backtrace) {
            echo $this->get_object_properties((object) $bt);
        }
        die;
    }
    
}

?>