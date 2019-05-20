<?php
require_once('db.php');
require_once(__DIR__.'/../Views/DailyTimetablePrinter.php');
require_once(__DIR__.'/../Views/TimetablePrinter.php' );


class DailyShortCode extends TimetablePrinter
{
    /** @var boolean */
    private $isJamahOnly = false;

    /** @var boolean */
    private $isAzanOnly = false;

    /** @var boolean */
    private $isHanafiAsr = false;

    /** @var array */
    private $row = array();

    /** @var  DailyTimetablePrinter */
    private $timetablePrinter;

    /** @var  string */
    private $title;

    /** @var  bool */
    private $hideRamadan = false;

    /** @var bool  */
    private $hideTimeRemaining = false;

    /** @var bool  */
    private $displayHijriDate = false;

    /** $var db */
    private $db;

    public function __construct()
    {
        $this->db = new DatabaseConnection();
        $this->row = $this->db->getPrayerTimeForToday();
        $this->timetablePrinter = new DailyTimetablePrinter();
        parent::__construct();
    }

    public function setAnnouncement($text, $day)
    {
        $this->row['announcement'] =  $this->getAnnouncement( $text, $day);

    }

    public function setJamahOnly()
    {
        $this->isJamahOnly = true;
    }

    public function setAzanOnly()
    {
        $this->isAzanOnly = true;
    }

    public function setHanafiAsr()
    {
        $this->isHanafiAsr = true;
    }

    public function hideRamadan()
    {
        $this->hideRamadan = true;
    }

    public function hideTimeRemaining()
    {
        $this->hideTimeRemaining = true;
    }

    public function displayHijriDate()
    {
        $this->displayHijriDate = true;
    }

    /**
     * @param  array  $attr
     * @return string
     */
    public function verticalTime($attr=array())
    {
        $this->timetablePrinter->setVertical(true);

        $row = $this->getRow($attr);

        if ($this->isJamahOnly) {
            return $this->timetablePrinter->verticalTimeJamahOnly($row);
        }

        if ($this->isAzanOnly) {
            return $this->timetablePrinter->verticalTimeAzanOnly($row);
        }

        return $this->timetablePrinter->printVerticalTime($row);
    }

    /**
     * @param  array  $attr
     * @return string
     */
    public function horizontalTime($attr=array())
    {
        $this->timetablePrinter->setHorizontal(true);

        $row = $this->getRow($attr);

        if ($this->isJamahOnly) {
            return $this->timetablePrinter->horizontalTimeJamahOnly($row);
        }

        if ($this->isAzanOnly) {
            return $this->timetablePrinter->horizontalTimeAzanOnly($row);
        }

        if (isset($attr['use_div_layout'])) {
            return $this->timetablePrinter->horizontalTimeDiv($row);
        }

        return $this->timetablePrinter->printHorizontalTime($row);
    }

        /**
     * @param  string $widgetNotice
     * @return string
     */
    public function getAnnouncement($widgetNotice="", $day)
    {
        $widgetNotice = trim( $widgetNotice );
        $day = trim($day);

        if (empty($widgetNotice)) {
            return "";
        }

        $today = date('l');
        $announcement = "";
        $exploded = explode(PHP_EOL, $widgetNotice);
        foreach($exploded as $line) {
            $announcement .= $line . "</br>";
        }
        if ( $today == ucfirst( $day ) || $day == 'everyday' ) {
            return trim($announcement);
        }
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function scNextPrayer($attr)
    {
        $row = $this->getRow($attr);
        $nextFajr = $this->db->getFajrJamahForTomorrow();
        $row['displayHijriDate'] = $this->displayHijriDate;
        return $this->timetablePrinter->displayNextPrayer($row, $nextFajr);
    }


    public function scRamadanTime($attr)
    {
        $row = $this->getRow($attr);

        return $this->timetablePrinter->displayRamadanTime($row);
    }

    public function scFajr($attr)
    {
        $result = "<span class='dpt_jamah'>" . $this->formatDateForPrayer($this->row['fajr_jamah']) . "</span>";
        if ( isset($attr['start_time']) ) {
            $result = "<span class='dpt_start'>" . $this->formatDateForPrayer($this->row['fajr_begins']) . "</span>" . $result;
        }
        return $result;
    }

    public function scFajrStart($attr)
    {
            return "<span class='dpt_start'>" . $this->formatDateForPrayer($this->row['fajr_begins']) . "</span>";
    }

    public function scSunrise($attr)
    {
        return "<span class='dpt_sunrise'>" . $this->formatDateForPrayer($this->row['sunrise']) . "</span>";
    }

    public function scZuhr($attr)
    {
        $result = "<span class='dpt_jamah'>" . $this->formatDateForPrayer($this->row['zuhr_jamah']) . "</span>";
        if ( isset($attr['start_time']) ) {
            $result = "<span class='dpt_start'>" . $this->formatDateForPrayer($this->row['zuhr_begins']) . "</span>" . $result;
        }
        return $result;
    }

    public function scZuhrStart($attr)
    {
            return "<span class='dpt_start'>" . $this->formatDateForPrayer($this->row['zuhr_begins']) . "</span>";
    }

    public function scAsr($attr)
    {
        $result = "<span class='dpt_jamah'>" . $this->formatDateForPrayer($this->row['asr_jamah']) . "</span>";
        if ( isset($attr['start_time']) ) {
            $result = "<span class='dpt_start'>" . $this->formatDateForPrayer($this->row['asr_mithl_1']) . "</span>" . $result;
        }
        return $result;
    }

    public function scAsrStart($attr)
    {
            return "<span class='dpt_start'>" . $this->formatDateForPrayer($this->row['asr_mithl_1']) . "</span>";
    }

    public function scMaghrib($attr)
    {
        $result = "<span class='dpt_jamah'>" . $this->formatDateForPrayer($this->row['maghrib_jamah']) . "</span>";
        if ( isset($attr['start_time']) ) {
            $result = "<span class='dpt_start'>" . $this->formatDateForPrayer($this->row['maghrib_begins']) . "</span>" . $result;
        }
        return $result;
    }

    public function scMaghribStart($attr)
    {
            return "<span class='dpt_start'>" . $this->formatDateForPrayer($this->row['maghrib_begins']) . "</span>";
    }

    public function scIsha($attr)
    {
        $result = "<span class='dpt_jamah'>" . $this->formatDateForPrayer($this->row['isha_jamah']) . "</span>";
        if ( isset($attr['start_time']) ) {
            $result = "<span class='dpt_start'>" . $this->formatDateForPrayer($this->row['isha_begins']) . "</span>" . $result;
        }
        return $result;
    }

    public function scIshaStart($attr)
    {
            return "<span class='dpt_start'>" . $this->formatDateForPrayer($this->row['isha_begins']) . "</span>";
    }

    public function scIqamahUpdate($attr)
    {
        $row['jamah_changes'] = $this->db->getJamahChanges(1);
        if (empty($row['jamah_changes'])) { return; }

        return $this->getJamahChange($row, true, $attr['orientation']);
    }

    public function scDigitalScreen($attr)
    {
        $ds =  new DigitalScreen($attr);

        return $ds->displayDigitalScreen();
    }

    protected function getRow($attr=array())
    {

        $this->setDisplayForShortCode($attr);

        if (isset($attr['asr'])) {
            $this->setHanafiAsr();
        }

        if (isset($attr['heading'])) {
            $this->setTitle($attr['heading']);
        }

        $row = $this->row;

        if (isset($attr['announcement'])) {
            $day = isset($attr['day']) ? $attr['day'] : 'everyday';
            $row['announcement'] = $this->getAnnouncement($attr['announcement'], $day);
        }

        if ( $row['jamah_changes']) {
            $row['announcement'] .= $this->timetablePrinter->getJamahChange($this->row);
        }

        $row['widgetTitle'] = $this->title;
        $row['asr_begins'] = $this->isHanafiAsr ? $this->row['asr_mithl_2'] : $this->row['asr_mithl_1'];

        $row['hideRamadan'] = $this->hideRamadan;
        $row['hideTimeRemaining'] = $this->hideTimeRemaining;
        $row['displayHijriDate'] = $this->displayHijriDate;

        return $row;
    }

    /**
     * @param array $attr
     */
    private function setDisplayForShortCode($attr)
    {
        if (isset($attr['display'])) {
            if ( $attr['display'] === 'iqamah_only' ) {
                $this->setJamahOnly();
            } elseif ( $attr['display'] === 'azan_only' ) {
                $this->setAzanOnly();
            }
        }

        if (isset($attr['hide_time_remaining'])) {
            $this->hideTimeRemaining();
        }

        if (isset($attr['hide_ramadan'])) {
            $this->hideRamadan();
        }

        $hijriCheckbox = get_option('hijri-chbox');
        if (! empty($hijriCheckbox)) {
            $this->displayHijriDate();
        }
    }
}