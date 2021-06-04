<?php
require_once("inc/config.inc.php");
require_once("inc/Database/Database.class.php");

require_once("inc/Entities/Employee.class.php");
require_once("inc/Entities/Supplier.class.php");
require_once("inc/Entities/Order.class.php");

require_once("inc/Utilities/Converters/EmloyeeConverter.class.php");
require_once("inc/Utilities/Converters/SupplierConverter.class.php");
require_once("inc/Utilities/Converters/OrderConverter.class.php");


require_once("inc/Utilities/Dao/EmployeeDAO.class.php");

require_once("inc/Utilities/Reports/OrderReport.class.php");
require_once("inc/Utilities/Reports/EmployeeReport.class.php");
require_once("inc/Utilities/Reports/SupplierReport.class.php");

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
        DashboardPage::pageFooter();
    } else if($_GET["page"] == "tables") {
        Page::pageHeader();
        TablePage::pageLeftMenu();
        Page::pageContentTop();
    
        TablePage::employeeTableContent(EmployeeReport::getEmployees());
        TablePage::orderTableContent(OrderReport::getOrderFromDb());
        TablePage::supplierTableContent(SupplierReport::getOrderFromDb());
    
        Page::pageContentBottom();
        Page::pageFooter();
    } else if($_GET["page"] == "charts"){

        Page::pageHeader();
        ChartPage::pageLeftMenu();
        Page::pageContentTop();
    
        DashboardPage::divGraphs();
        DashboardPage::pieChart(OrderReport::getProductsFromOrder());
    
    
        Page::pageContentBottom();
        DashboardPage::pageFooter();
    }
} else {
    Page::pageHeader();
    Page::pageLeftMenu();
    Page::pageContentTop();
    
    DashboardPage::divGraphs();
    DashboardPage::pieChart(OrderReport::getProductsFromOrder());

    Page::pageContentBottom();
    DashboardPage::pageFooter();
}