<?php
/**
 * Created by PhpStorm.
 * User: nisha
 * Date: 2/20/19
 * Time: 6:26 PM
 */
main::start("realestatetransactions.csv");
class main {

    static public function start($filename){

       $records = csv::getRecordsFromFile($filename);
       $nav= html::navBar();
       $table = html::buildTable($records);

       print_r($nav);
       print_r($table);

    }

}

class html{

    Public static function navBar(){

        // navigation bar
        $html = '<head><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"></head>';
        $html .= '<nav class="navbar navbar-default sticky-top navbar-inverse" style="background-color: skyblue">';
        //$html .= '<nav class="navbar navbar-default fixed-top" style="background-color: dimgray">';
        $html .= '<div class="navbar-header">';
        $html .=  '<a class="navbar-brand" href="#" style="font-size:35px;color: black; font-family: Kalapi; font-style: italic; font-weight: bold">Records from CSV File</a>';
        $html .='</div></nav></body>';
        return $html;
    }

    public static function buildTable($records){
        // start table
        $html = '<head><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"></head><body><table class="table table-striped">';

        // header row
        $html .= '<thead class="thead-dark" style="margin-top: 100px"><tr>';
        foreach($records[0] as $key=>$value){
            $html .= '<th scope="col">' . htmlspecialchars($key) . '</th>';
        }
        $html .= '</tr></thead>';

        // data rows
        $html .= '<tbody>';
        foreach( $records as $key=>$value){
            $html .= '<tr scope="row">';
            foreach($value as $key2=>$value2){
                $html .= '<td>' . htmlspecialchars($value2) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';

        // finish table and return it

        $html .= '</table></body>';
        return $html;
    }

}
class csv{

    static public function getRecordsFromFile($filename) {

        $file = fopen($filename, "r");

        $fieldNames = array();

        $count = 0;


        while (! feof($file))
        {
            $record = fgetcsv($file);
            if($count == 0) {
                $fieldNames = $record;
            } else {
                $records[] = recordFactory::createRecord($fieldNames, $record);
            }
            $count++;
        }

        fclose($file);
        return $records;
    }

}
class record{

    public function __construct(Array $fieldNames = null, $values = null){


        $record = array_combine($fieldNames, $values);

        Foreach($record as $property => $value) {
            $this->createProperty($property, $value);
        }

    }

    public function returnArray(){

        $array = (array) $this;

        return $array;

    }

    public function createProperty($name = 'first', $value = 'Nisha') {

        $this->{$name} = $value;

    }

}
class recordFactory{

    static public function createRecord (Array $fieldNames = null, Array $values = null){

        $record = new record($fieldNames, $values);

        return $record;
    }

}