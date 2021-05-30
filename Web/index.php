<?php
require_once("inc/config.inc.php");
require_once("inc/Database/MongoConnection.class.php");
require_once("inc/Database/Database.class.php");

require_once("inc/Entities/Employee.class.php");
require_once("inc/Entities/Supplier.class.php");
require_once("inc/Entities/Products/ProductSupplier.class.php");

require_once("inc/Utilities/Converters/EmloyeeConverter.class.php");
require_once("inc/Utilities/Converters/SupplierConverter.class.php");

require_once("inc/Utilities/Dao/EmployeeDAO.class.php");

require_once("inc/Utilities/Page.class.php");
require_once("inc/Utilities/Html/TableHtml.class.php");

use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Command;
use MongoDB\Driver\BulkWrite;


$nDb = new Database();
$nDb->setMongo();

Page::pageHeader();
Page::pageLeftMenu();


Page::pageContent(
    
    TableHtml::employeeTableContent(
        $nDb->execute()::findData(
            ["employeeId","firstName","lastName","userCategory","username"],//Array of fields from collection
            5,//The number of results
            "employeeId"//Order by
        )
    )
    
);

Page::pageFooter();


/*
$manager = new Manager(DEFAULT_URL);

$manager = new Manager(DEFAULT_URL);
$query = new Query([]);
$cursor = $manager->executeQuery("mock_restaurant.employee",$query);
//$result = $cursor->toArray();

$filter = [];
$options = ['sort'=>array('employeeId'=>1),'limit'=>3,'projection' => ["username"=>1,"firstName"=>1]];
//$options2 = ['sort'=>array('employeeId'=>1),'limit'=>1,'projection' => []];
$query = new Query([]);

*/

/*
MongoConnection::executeQuery(
    "employee",["employeeId","firstName","lastName","username"],2
);
*/
/*
$employee = new Employee(
    222,
    "Gustavo",
    "Freitas",
    "1987-02-22",
    "3 Loftsgordon Crossing",
    "Ambato Boeny",
    "373-712-4612",
    "ldegiorgis0@dell.com",
    "https://robohash.org/expeditaaspernaturnon.png?size=50x50&set=set1",
    "Aliquam non mauris. Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis. Fusce posuere felis sed lacus. Morbi sem mauris, laoreet ut, rhoncus aliquet, pulvinar sed, nisl. Nunc rhoncus dui vel sem. Sed sagittis.",
    4,
    "ldegiorgis0",
    "7z7x55DxOV"
);


MongoConnection::insertData(
    EmployeeConverter::convertToStdClass($employee)
);

$gustavo = $result[count($result)-1];
$gustavoObj = EmployeeConverter::convertFromStdClass($gustavo);
$gustavoObj->setUsername("gbpf");

MongoConnection::updateData(
    EmployeeConverter::convertToStdClass($gustavoObj)
);


$gustavo = $result[count($result)-1];
$gustavoObj = EmployeeConverter::convertFromStdClass($gustavo);
MongoConnection::insertData(
    EmployeeConverter::convertToStdClass($gustavoObj)
);

var_dump("Updated");


$listDb = new Command(["ping" => 1]);

//DB is the selected database and the $listDb runs the Atlas mongoDB command
$result = $manager->executeCommand(DB,$listDb);

var_dump($result->toArray()[0]->ok);
*/