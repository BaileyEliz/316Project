<?php

function print_day($number) {
  if ($number == 1) {
    return 'Monday';
  }
  else if ($number == 2) {
    return 'Tuesday';
  }
  else if ($number == 3) {
    return 'Wednesday';
  }
  else if ($number == 4) {
    return 'Thursday';
  }
  else if ($number == 5) {
    return 'Friday';
  }
}

function max_overlap($times_array, $start_time, $end_time) {
  $array_unique = array();
  $start_hour = intval(substr($start_time, 0, 2));
  $start_minute = intval(substr($start_time, 3, 5));
  $end_hour = intval(substr($end_time, 0, 2));
  $end_minute = intval(substr($end_time, 3, 5));
  $temp_minute = $start_minute;
  for ($i = $start_hour; $i <= $end_hour; $i++) {
    for ($j = $temp_minute; (($j < $end_minute and $i == $end_hour) or ($j < 60 and $i < $end_hour)); $j = $j + 5) {
      foreach ($times_array[$i][$j] as $a_session){
        $array_unique[] = $a_session;
      }
      if (count($times_array[$i][$j]) > $maximum) {
        $maximum = count($times_array[$i][$j]);
      }
    } 
    $temp_minute = 0;
  }
  return count(array_unique($array_unique));
}

function time_print($time) {
  $h = intval(substr($time, 0, 2));
  $m = intval(substr($time, 3, 5));
  if ($m == 0) {
    $m = "00";
  }

  if ($h < 12) {
    return $h . ":" . $m . " AM";
  }
  else if ($h < 13) {
    return $h . ":" . $m . " PM";
  }
  else {
    return ($h - 12) . ":" . $m . " PM";
  }
}

function minutes_different($start_time, $end_time) {
  $start_hour = intval(substr($start_time, 0, 2));
  $start_minute = intval(substr($start_time, 3, 5));
  $end_hour = intval(substr($end_time, 0, 2));
  $end_minute = intval(substr($end_time, 3, 5));

  $temp_hour = $start_hour;
  $minutes = 0;

  if ($start_minute > 0) {
    $minutes += (60 - $start_minute);
    $temp_hour += 1;
  }

  $minutes += 60 * ($end_hour - $temp_hour);
  $minutes += $end_minute;
  return $minutes;

}

function top_margin($time) {
  $time_hour = intval(substr($time, 0, 2));
  if ($time_hour >= 8) {
    return minutes_different("08:00:00", $time);
  }
  return minutes_different("08:00:00", "08:00:00");
}

function wordless_html_print($index, $array) {
  if (count($array) == 0) {
    return "there's nothing here!";
  }
  $request_id = $array['request_id'];
  $build = "<div id ='option_" . $index . "'/>";
  return $build;
}

function html_print($index, $array) {
  if (count($array) == 0) {
    return "there's nothing here!";
  }
  $request_id = $array['request_id'];
  $build = "<div class='parent' id ='option_" . $index . "'>";
  $build .= "<form method=\"post\" action=\"student_matches_request_details.php\">";
  $build .= "<input type=\"hidden\" name=\"request_id\" value=\"" . $request_id . "\">";
  $build .= "<div class='clickme' onclick='this.parentNode.submit();'></div>";
  $build .= "<div class='popup' onclick='this.parentNode.submit();'>Teacher: " . $array['name'] . "</br>Site: " . $array['site_name'] . "</br>" . "</div>";
  $build .= "</form>";
  $build .= "</div>";
  return $build;
}

function simple_html_print($index, $array) {
  if (count($array) == 0) {
    return "there's nothing here!";
  }
  $request_id = $array['request_id'];
  $build = "<div id ='option_" . $index . "'></div>";
  return $build;
}

function daily_maximum($times, $array) {
  $maximum = 0;
  for ($i = 0; $i < count($array); $i++){
    $overlap = max_overlap($times, $array[$i]['start_time'], $array[$i]['end_time']);
    if ($overlap > $maximum) {
      $maximum = $overlap;
    }
  }
  return $maximum;
}

function blank_layout($maximum) {
  $layout = array();
  for ($x = 8; $x < 22; $x++) {
    for ($m = 0; $m < 60; $m += 5) {
      for ($y = 0; $y < $maximum; $y++) {
        $layout[$x][$m][] = false;
      }
    }
  }
  return $layout;
}

function all_times($array) {
  $times = array();
  for ($x = 0; $x < count($array); $x++) {
    $session = $array[$x];
    $start_hour = intval(substr($session['start_time'], 0, 2));
    $start_minute = intval(substr($session['start_time'], 3, 5));
    $end_hour = intval(substr($session['end_time'], 0, 2));
    $end_minute = intval(substr($session['end_time'], 3, 5));
    $temp_minute = $start_minute;
    for ($i = $start_hour; $i <= $end_hour; $i++) {
      for ($j = $temp_minute; (($j < $end_minute and $i == $end_hour) or ($j < 60 and $i < $end_hour)); $j = $j + 5) {
        $times[$i][$j][] = $x;
      }
      $temp_minute = 0;
    }
  }
  return $times;
}

function simple_css_print($index, $array, $day) {
  
  $d = $array['day'];

  $build = "<script type='text/javascript'>";
  $build .= "var styles = {
    'background-color': 'aquamarine',
    'border-color': '" . "black" . "',
    'position': 'absolute',
    'top':'" . (top_margin($array['start_time'])) . "px', 
    'height':'" . (minutes_different($array['start_time'], $array['end_time'])) ."px',
    'width':'100%',
    'border-style':'solid',
    'border-width':'1px'};";
    $build .= "$('#option_" . $index . "').css(styles);";
    $build .= "$('." . $day . "-contents').append($('#option_" . $index . "'));";
    $build .= "</script>";
    return $build;
  }

  function css_print($number_of_overlaps, $layout_array, $times_array, $index, $array, $day) {
    
    $d = $array['day'];
      // this makes all of the sessions in one day the same width
      // maybe make this dynamic later if there's time
      //$overlapping = max_overlap($times_array, $array['start_time'], $array['end_time']);
    $overlapping = $number_of_overlaps;
    $percent = ((1 / $overlapping) * 100);

    $start_hour = intval(substr($array['start_time'], 0, 2));
    $start_minute = intval(substr($array['start_time'], 3, 5));
    $end_hour = intval(substr($array['end_time'], 0, 2));
    $end_minute = intval(substr($array['end_time'], 3, 5));
    $temp_minute = $start_minute;

    $insert_spot = 0;
    $accurate = false;

    for ($placeholder = 0; (($placeholder < $number_of_overlaps) and (!$accurate)); $placeholder++) {
      $accurate = true;
      $insert_spot = $placeholder;
      for ($i = $start_hour; $i <= $end_hour; $i++) {
        for ($j = $temp_minute; (($j < $end_minute and $i == $end_hour) or ($j < 60 and $i < $end_hour)); $j = $j + 5) {
          if ($layout_array[$i][$j][$insert_spot] == true) {
            $accurate = false;
          }
        }
        $temp_minute = 0;
      }
    }

    $temp_minute = $start_minute;
    for ($i = $start_hour; $i <= $end_hour; $i++) {
      for ($j = $temp_minute; (($j < $end_minute and $i == $end_hour) or ($j < 60 and $i < $end_hour)); $j = $j + 5) {
        $layout_array[$i][$j][$insert_spot] = true;
      }
      $temp_minute = 0;
    }

    $build = "<script type='text/javascript'>";
    $build .= "var styles = {
      'background-color': 'aquamarine',
      'border-color': '" . "black" . "', 
      'position': 'absolute', 
      'top':'" . (6 * top_margin($array['start_time'])) . "px', 
      'left':'" . ($percent * $insert_spot) . "%',
      'height':'" . (6 * minutes_different($array['start_time'], $array['end_time'])) ."px',
      'width':'" . $percent . "%',
      'border-style':'solid',
      'border-width':'1px'};";
      $build .= "$('#option_" . $index . "').css(styles);";
      $build .= "$('." . $day . "-contents').append($('#option_" . $index . "'));";
      $build .= "</script>";
      return array($build, $layout_array);
    }

    ?>