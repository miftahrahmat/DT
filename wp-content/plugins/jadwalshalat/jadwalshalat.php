<?php
/*
Plugin Name: Jadwal Shalat YS.1
Plugin URI: http://yohansalman.com/wp/plugin-waktu-shalat/
Description: Jadwal Waktu Shalat dengan perhitungan waktu di Indonesia 
Author: Yohan Salman
Version: 1.0
Author URI: http://yohansalman.com/
*/
 
function samplejadwal()
{
 $jadwal = 'http://www.republika.co.id/jadwal_sholat/';
	echo "<object width=\"300\" height=\"160\">
<iframe src=\"$jadwal\" width=\"300\" height=\"160\">
</iframe>
</object>";

}
 
function widget_salmani($args) {
  extract($args);
  echo $before_widget;
  echo $before_title;?>Jadwal Shalat<?php echo $after_title;
  samplejadwal();
  echo $after_widget;
}
 
function salmani_init()
{
  register_sidebar_widget(__('Jadwal Shalat YS.1'), 'widget_salmani');
}
add_action("plugins_loaded", "salmani_init");
?>