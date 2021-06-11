<?php
require_once("inc/Utilities/ParsePostForm.class.php");
require_once("inc/RestAPI.class.php");

require_once("inc/Utilities/Page.class.php");
require_once("inc/Utilities/Html/DashboardPage.class.php");
require_once("inc/Utilities/Html/TablePage.class.php");
require_once("inc/Utilities/Html/FormHtml.class.php");
require_once("inc/Utilities/Html/ChartPage.class.php");

if(!empty($_GET)){

    if($_GET["page"] == "dashboard"){

        Page::pageHeader();
        Page::pageLeftMenu();
        Page::pageContentTop();
        
        DashboardPage::divGraphs();
        DashboardPage::pieChart(OrderReport::getProductsFromOrder());

        Page::pageContentBottom();
        Page::pageFooter();

    } else if($_GET["page"] == "tables") {

        if(empty($_POST)){
            
            Page::pageHeader();
            TablePage::pageLeftMenu();
            Page::pageContentTop();
            
            TablePage::employeeTableContent(
                RestAPI::getData("employee")
            );
            
            TablePage::orderTableContent(
                RestAPI::getData("order")
            );
            
            TablePage::productsTableContent(
                RestAPI::getData("productinventory")
            );

            Page::pageContentBottom();
            Page::pageFooter();
        } else {
            Page::pageHeader();
            TablePage::pageLeftMenu();
            Page::pageContentTop();

            $action = $_POST["form"];

            if( str_contains($action,"add") ){

                RestAPI::postData(
                    ParsePostForm::parsePost($_POST)
                );
                Page::toastAdded();
            } else if( str_contains($action,"edit") ){

                RestAPI::updateData(
                    ParsePostForm::parsePost($_POST)
                );
                Page::toastUpdate();
            }
        
            TablePage::employeeTableContent(
                RestAPI::getData("employee")
            );
            
            TablePage::orderTableContent(
                RestAPI::getData("order")
            );
            
            TablePage::productsTableContent(
                RestAPI::getData("productinventory")
            );
        
            Page::pageContentBottom();
            Page::pageFooter();
        }
        
    } else if($_GET["page"] == "charts"){

        Page::pageHeader();
        ChartPage::pageLeftMenu();
        Page::pageContentTop();
    
        DashboardPage::divGraphs();
        DashboardPage::pieChart(
            OrderReport::getProductsFromOrder()
        );
    
        Page::pageContentBottom();
        Page::pageFooter();
    }

} else {
    Page::pageHeader();
    Page::pageLeftMenu();
    Page::pageContentTop();  

    EmployeeDAO::startDb();

    TablePage::employeeTableContent(
        EmployeeDAO::getMultipleEmployee(5)
    );

    Page::pageContentBottom();
    Page::pageFooter();
}



/*
$con = new PDOMongo("shipper");
  
    //Back to stdClass
    var_dump(
        json_decode(
            json_encode(
                $con->getCounter()
            )
        )
    );


Page::pageHeader();
Page::pageLeftMenu();

Page::pageContentTop();

//var_dump(Test::getProductsFromOrder($productsArray));
TableHtml::orderTableContent(
    OrderConverter::convertFromStdClass(
        $nDb2->getDataBase()->findData(
            [],
            5,
            "orderId"
        )
    )
);

OrderReport::getOrderFromDb();
//var_dump();

Page::pageContentBottom();
Page::pageFooter();

$manager = new Manager(DEFAULT_URL);

$manager = new Manager(DEFAULT_URL);
$query = new Query([]);
$cursor = $manager->executeQuery("mock_restaurant.employee",$query);
//$result = $cursor->toArray();

$filter = [];
$options = [
    'sort'=>array('employeeId'=>1),
    'limit'=>3,
    'projection' => [
        "username"=>1,
        "firstName"=>1
        ]
];
//$options2 = ['sort'=>array('employeeId'=>1),'limit'=>1,'projection' => []];
$query = new Query([]);


MongoConnection::executeQuery(
    "employee",["employeeId","firstName","lastName","username"],2
);

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