<?php

date_default_timezone_set('America/Vancouver');


require_once("inc/Utilities/RestAPI.class.php");

require_once("inc/Utilities/Reports/OrderReport.class.php");
require_once("inc/Utilities/FilesHandler/FileAgent.class.php");

require_once("inc/Utilities/Page.class.php");
require_once("inc/Utilities/Html/DashboardPage.class.php");
require_once("inc/Utilities/Html/TablePage.class.php");
require_once("inc/Utilities/Html/FormHtml.class.php");
require_once("inc/Utilities/Html/ChartPage.class.php");

Page::pageHeader();

if( date("H") == "02") {

    FileAgent::createFile(
        RestAPI::getData("productInventory",0)
    );
}

if(!empty($_GET)){

    if($_GET["page"] == "dashboard"){

        Page::pageLeftMenu();
        Page::pageContentTop();
        
        TablePage::employeeTableContent(
            RestAPI::getData("employee")
        );

        DashboardPage::divGraphs();
        DashboardPage::pieChart(
            OrderReport::getProductsFromOrder()
        );

    } else if($_GET["page"] == "tables") {

        if(empty($_POST)){
            
            TablePage::pageLeftMenu();
            Page::pageContentTop();
            TablePage::tabs();

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

            TablePage::pageLeftMenu();
            Page::pageContentTop();
            
            $action = $_POST["form"];

            if( strpos($action, "add") !== false ){
                RestAPI::postData($_POST);
                Page::toastAdded();

            } else if( strpos($action, "edit") !== false ){
                RestAPI::updateData($_POST);
                Page::toastUpdate();
            }
            
            TablePage::tabs();
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
        
    } else if($_GET["page"] == "charts"){

        ChartPage::pageLeftMenu();
        Page::pageContentTop();

        ChartPage::divGraphs();

        DashboardPage::divGraphs();
        DashboardPage::pieChart(
            OrderReport::getProductsFromOrder()
        );

        
     
    }

} else {
    header("Location: ".$_SERVER['PHP_SELF']."?page=dashboard");

}

Page::pageContentBottom();
Page::pageFooter();