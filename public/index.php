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
        $table = html::generateTable($records);

    }


}

class html{

    public static function generateTable($records){

           $count = 0;
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