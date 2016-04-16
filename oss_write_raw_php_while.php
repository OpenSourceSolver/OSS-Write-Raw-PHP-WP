<?php

/*
  Plugin Name: OSS Write Raw PHP [WP Plugin]
  Plugin URI: http://www.facebook.com/OpenSourceSolver
  Description about: Write your PHP code in WordPress Post & Pages
  Version: 1.0
  Date: 14 April 2016
  Author: Open Source Solver # OpenSourceSolver@gmail.com
  Developer: M. Hassan Zaman @ engr.hassan.bd@gmail.com
  Author URI: http://www.facebook.com/OpenSourceSolver
  LICENSE: GNU GENERAL PUBLIC LICENSE, Version 3, 29 June 2007, http://www.gnu.org/licenses/gpl-3.0.html
 */
/*
The MIT License (MIT)

Copyright (c) 2016 Open Source Solver

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

if (!function_exists('f_oss_write_raw_php')) {

    function f_oss_write_raw_php($content) {

        //Get Content of WP Post OR Page
        $osswrphp_content = $content;

        //Preg Match Content
        preg_match_all("!\[raw_php[^\]]*\](.*?)\[/raw_php[^\]]*\]!is", $osswrphp_content, $osswrphp_rawcode_areas);

        //Count Raw Code Areas
        $osswrphp_rawcode_count_areas = count($osswrphp_rawcode_areas[0]);

        //Value Intialize for Run multiple Raw Code Area
        $osswrphp_rawcode_areas_start = 0;

        //Run While Loop to execute multiple area of PHP Code
        while ($osswrphp_rawcode_areas_start < $osswrphp_rawcode_count_areas) {

            ob_start();
            eval($osswrphp_rawcode_areas[1][$osswrphp_rawcode_areas_start]);
            $raw_replacement = ob_get_contents();
            ob_clean();
            ob_end_flush();
            //Raw Replacement
            $osswrphp_content = preg_replace('/' . preg_quote($osswrphp_rawcode_areas[0][$osswrphp_rawcode_areas_start], '/') . '/', $raw_replacement, $osswrphp_content, 1);
            //Initial value incriment
            $osswrphp_rawcode_areas_start++;
        }
        //Return PHP output with others text
        return $osswrphp_content;
    }

    // Content Filter Action Set 10.
    add_filter('the_content', 'f_oss_write_raw_php', 10);
} else {
    //Exception, When Function Duplicate...
    //echo "<script>alert('Sorry! OSS Write Raw PHP Plugin Function is exist!');</script>"
}
?>
