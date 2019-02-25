<?php
/**
 * Created by PhpStorm.
 * User: nisha
 * Date: 2/20/19
 * Time: 6:26 PM
 */
main::start("example.csv");
class main {
    static public function start($filename){

        $records = csv::getRecords($filename);
        //   $table = html::generateTable($records);
        $table = html::build_table($records);
        print_r($table);

    }


}

class html{

    public static function generateTable($records){

        $count = 0;
        echo '<table>';
        Foreach($records as $record) {
            if ($count == 0){
                $array = $record -> returnArray();

                $fields = array_keys($array);
                $values = array_values($array);
                print_r($fields);
                print_r($values);


            } else {
                $array = $record -> returnArray();
                $values = array_values($array);
                print_r($values);
            }
            $count++;

        }

    }
    public static function build_table($array){
        // start table
        $html = '<head><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"></head><table class="table table-striped">';
        // header row
        $html .= '<tr>';
        foreach($array[0] as $key=>$value){
            $html .= '<th scope="col">' . htmlspecialchars($key) . '</th>';
        }
        $html .= '</tr>';

        // data rows
        foreach( $array as $key=>$value){
            $html .= '<tr scope="row">';
            foreach($value as $key2=>$value2){
                $html .= '<td>' . htmlspecialchars($value2) . '</td>';
            }
            $html .= '</tr>';
        }

        // finish table and return it

        $html .= '</table>';
        return $html;
    }

}
class csv{

    static public function getRecords($filename) {

        $file = fopen($filename, "r");

        $fieldNames = array();

        $count = 0;


        while (! feof($file))
        {
            $record = fgetcsv($file);
            if($count == 0) {
                $fieldNames = $record;
            } else {
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;
        }

        fclose($file);
        return $records;
    }
}
class record{

    public function __construct(Array $fieldNames = null, $values = null)
    {


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
    static public function create (Array $fieldNames = null, Array $values = null){


        $record = new record($fieldNames, $values);

        return $record;
    }
}