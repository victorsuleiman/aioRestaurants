<?php
require_once("inc/Utilities/RestAPI.class.php");
require_once("inc/Utilities/ParsePostForm.class.php");

require_once("inc/Utilities/Reports/OrderReport.class.php");

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
        
        TablePage::employeeTableContent(
            RestAPI::getData("employee")
        );

        DashboardPage::divGraphs();
        DashboardPage::pieChart(
            OrderReport::getProductsFromOrder()
        );

        Page::pageContentBottom();
        Page::pageFooter();

    } else if($_GET["page"] == "tables") {

        if(empty($_POST)){
            
            Page::pageHeader();
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

            Page::pageContentBottom();
            Page::pageFooter();

        } else {

            Page::pageHeader();
            TablePage::pageLeftMenu();
            Page::pageContentTop();
            
            $action = $_POST["form"];

            if( strpos($action, "add") !== false ){
                RestAPI::postData(
                    ParsePostForm::parsePost($_POST)
                );
                Page::toastAdded();
            } else if( strpos($action, "edit") !== false ){
                RestAPI::updateData(
                    ParsePostForm::parsePost($_POST)
                );
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
    header("Location: ".$_SERVER['PHP_SELF']."?page=dashboard");
}