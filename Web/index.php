<?php

date_default_timezone_set('America/Vancouver');

require_once("inc/Utilities/LoginManager.class.php");
require_once("inc/Utilities/RestAPI.class.php");

require_once("inc/Utilities/Reports/OrderReport.class.php");
require_once("inc/Utilities/FilesHandler/FileAgent.class.php");

require_once("inc/Utilities/Page.class.php");
require_once("inc/Utilities/Html/DashboardPage.class.php");
require_once("inc/Utilities/Html/TablePage.class.php");
require_once("inc/Utilities/Html/FormHtml.class.php");
require_once("inc/Utilities/Html/ChartPage.class.php");



Page::pageHeader();

if(!empty($_GET["page"])){

    LoginManager::checkLogin();

    if($_GET["page"] == "dashboard"){

        Page::pageLeftMenu();
        Page::pageContentTop();
        
        TablePage::employeeTableContent(
            RestAPI::getData("employee")
        );

        /*The graphs have to be always in the bottom*/
        DashboardPage::divGraphs();

        DashboardPage::pieChart(
            OrderReport::getProductsFromOrder()
        );

        DashboardPage::barChart(
            OrderReport::getProductsFromOrder()
        );


    } else if($_GET["page"] == "tables") {

        TablePage::pageLeftMenu();
        Page::pageContentTop();
        TablePage::tabs();

        if(empty($_POST)){
            
            switch($_GET["tab"]){

                case "employee":
                    TablePage::employeeTableContent(
                        RestAPI::getData("employee")
                    );
                break;

                case "order":
                    TablePage::orderTableContent(
                        RestAPI::getData("order")
                    );
                break;

                case "product":
                    TablePage::productsTableContent(
                        RestAPI::getData("ProductInventory")
                    );
                break;

                case "supplier":
                    TablePage::supplierTableContent(
                        RestAPI::getData("supplier")
                    );
                break;

                case "shipper":
                    TablePage::shipperTableContent(
                        RestAPI::getData("shipper")
                    );
                break;

                default:
                    TablePage::employeeTableContent(
                        RestAPI::getData("employee")
                    );
                break;
            }

        } else {

            $action = $_POST["form"];

            if( strpos($action, "add") !== false ){
                RestAPI::postData($_POST);
                Page::toastAdded();

            } else if( strpos($action, "edit") !== false ){
                RestAPI::updateData($_POST);
                Page::toastUpdate();
            }

            if(isset($_GET["tab"])){
                
                switch($_GET["tab"]){
                    case "employee":
                        TablePage::employeeTableContent(
                            RestAPI::getData("employee")
                        );
                    break;
    
                    case "order":
                        TablePage::orderTableContent(
                            RestAPI::getData("order")
                        );
                    break;
    
                    case "product":
                        TablePage::productsTableContent(
                            RestAPI::getData("ProductInventory")
                        );
                    break;
    
                    case "supplier":
                        TablePage::supplierTableContent(
                            RestAPI::getData("supplier")
                        );
                    break;
    
                    case "shipper":
                        TablePage::shipperTableContent(
                            RestAPI::getData("shipper")
                        );
                    break;
                }

            } else {
                TablePage::employeeTableContent(
                    RestAPI::getData("employee")
                );
            }
            

        }

        ChartPage::inventoryReport();
        
    } else if($_GET["page"] == "charts"){

        ChartPage::pageLeftMenu();
        Page::pageContentTop();
        ChartPage::weekReport();
        
        $orderReport = OrderReport::getProductsFromOrder();

        ChartPage::pieChartProduct($orderReport);

        if(!empty($_POST)){

            $recipt_1 = RestAPI::getReciptReport($_POST,"date");
            $recipt_2 = RestAPI::getReciptReport($_POST,"server");
            $recipt_3 = RestAPI::getReciptReport($_POST,"paymentType");
            
            $goal = RestAPI::getGoal($_POST);
            if(!empty($recipt_1)){

                ChartPage::divGraphs();
                #2
                ChartPage::areaChartGoals(
                    $recipt_1,$goal
                );

                ChartPage::barChartEmployee(
                    $recipt_2
                );

                ChartPage::pieChartPaymentType(
                    $recipt_3
                );
                
            } else {
                ChartPage::resultNotFound($_POST);
            }
            
        }
        
    }

} else {
    header("Location: login.php");
}

Page::pageContentBottom();
Page::pageFooter();

/*

(Kinda hard one)
Qty of dishes sold:
1 line per dish
date x aggregate qty for dish

(even harder)
qty of ingredients sold:
1 line per ingredient
date x aggregate qty for ingredient
*/