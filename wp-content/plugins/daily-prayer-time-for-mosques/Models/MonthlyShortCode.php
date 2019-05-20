<?php
require_once('MonthlyTimeTable.php');
require_once(__DIR__.'/../Views/MonthlyTimetablePrinter.php');

class MonthlyShortCode
{
    /** @var MonthlyTimetablePrinter */
    private $printer;

    public function __construct()
    {
        $this->printer = new MonthlyTimetablePrinter();
    }

    public function printMonthlyTimeTable($attr)
    {
        $data = $this->getTimeTableHeading($attr);
        ob_start();
        return $data;
        return ob_get_clean();
    }

    /**
     * @return string
     */
    private function getTimeTableHeading($attr)
    {
        $heading = "Select other month";

        if (isset($attr['heading'])) {
            $heading = $attr['heading'];
        }

        if (isset($attr['display'])) {
            $hiddenInput = "<input type='hidden' name='display' id='display' value=".$attr['display']." />";
        }
        $month = date("m");
        $path = plugin_dir_url( __FILE__ ); // I am in Models
        $path .= '../';

        $siteName = get_bloginfo( 'name' );

        return $introText = "
        <div class='container-fluid'>
            <div class='row'>
            <div id='printAndMonth'>
                <div id='monthContainer'>
                <h3 class='printSiteName'>".$siteName."</h3>
                    <p class='monthHeading'> ".$heading ."</p>
                    <span class='monthSelector'>
                        <form id='monthAjax'>" .$hiddenInput. "
                            <select class='otherMonth' id='month' name='month'>" .$this->getMonths($month). "</select>
                        </form>
                    </span>
                    <span class='printIcon'>
                        <a title='click to print' onclick='DPT.printDiv(\"printAndMonth\")'>
                            <img src=".$path. 'Assets/images/print_icon.png'." alt='click to print'>
                        </a>
                    </span>
                </div>
                <div class='clear'></div>
                <div class='monthlyTimetable' id='monthlyTimetable'></div>
            </div>
            </div>
        </div>
        ";
    }

    /**
     * @param $month
     * @return string#
     */
    private function getMonths($month){
        $months = $this->printer->getLocalMonths();

        $i = 1;
        $options = "";
        foreach($months as $month_name){
            $selected = "";

            if ( $month_name == 'Ramadan' ) {
                $selected = " selected='selected'";
            } else if($i == intval($month)){
                $selected = " selected='selected'";
            }
            $options .= "<option value='{$i}' {$selected}>{$month_name}</option>";
            $i++;
        }

        return $options;
    }
}

add_action( 'wp_ajax_get_monthly_timetable', 'get_monthly_timetable' );
add_action( 'wp_ajax_nopriv_get_monthly_timetable', 'get_monthly_timetable' );

function get_monthly_timetable()
{
    $month = $_REQUEST["month"];
    $display = $_REQUEST["display"];
    $timetable = new MonthlyTimeTable($month);

    $options = array();
    if ($month == 13) {
        $options['isRamadan'] = true;
    }

    if ($display === 'iqamah_only') {
        $data = $timetable->displayTableJamahOnly($options);
    } elseif ($display === 'azan_only') {
        $data = $timetable->displayTableAzanOnly($options);
    } else {
        $data = $timetable->displayTable($options);
    }

    echo $data;
    die();
}
