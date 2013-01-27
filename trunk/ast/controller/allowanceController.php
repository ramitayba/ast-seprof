<?php

/**
 * This is the allowance
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 *
 */
include_once POS_ROOT . '/businessLayer/AllowanceBusinessLayer.php';
if ($action == 'allowance'):
    $allowanceDataTable = LookupBusinessLayer::getInstance()->getEmployees();
    if (LookupBusinessLayer::getInstance()->getSuccess()):
        $content = Helper::fill_datatable('employee', array(), $allowanceDataTable, array('Employe ID', 'Employee Name', 'Max Debit'), array('employee_id', 'employee_name', 'employee_max_debit'), 'employee_id', array(), false, 0);
        unset($_SESSION['messages']);
    else:
        $div = Helper::set_message('<li>error Connection</li>', 'error');
        $_SESSION['messages'] = $div;
    endif;
elseif ($action == 'save'):
    $allowanceBusinessLayer = new AllowanceBusinessLayer();
    $xml = new SimpleXMLElement('<employee_debit></employee_debit>');
    Helper::array_to_xml($datatable, $xml);
    $xml = $xml->asXML();
    $success = $allowanceBusinessLayer->addAllowance($xml, $_SESSION['user_pos']);
    if ($success):
        $message = Helper::set_message('Allowance saved succesfuly', 'status');
        print json_encode(array('status' => 'success', 'message' => $message));
    else:
        print json_encode(array('status' => 'error', 'message' => 'Allowance not saved '));
    endif;
endif;
?>
