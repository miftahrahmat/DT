<?php
/** no direct access **/
defined('MECEXEC') or die();

if($this->style == 'clean') include MEC::import('app.skins.timetable.clean', true, true);
else include MEC::import('app.skins.timetable.modern', true, true);