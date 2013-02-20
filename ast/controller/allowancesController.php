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
    $title = 'Allowance';
    $allowanceDataTable = LookupBusinessLayer::getInstance()->getEmployees();
    if (LookupBusinessLayer::getInstance()->getSuccess()):
        $content = Helper::fill_datatable('allowances', 'allowances', array(), $allowanceDataTable, array('Employe ID', 'Employee Name', 'Max Debit'), array('employee_id', 'employee_name', 'employee_max_debit'), 'employee_id', array(), false,1, 0, 'allowances', 'employee_max_debit');
        unset($_SESSION['messages']);
    else:
        $div = Helper::set_message('<li>error Connection</li>', 'error');
        $_SESSION['messages'] = $div;
    endif;
elseif ($action == 'save'):
    $allowanceBusinessLayer = new AllowanceBusinessLayer();
    /* $xml = new SimpleXMLElement('<employee_debit></employee_debit>');
      Helper::array_to_xml($datatable, $xml);
      $xml = $xml->asXML(); */
    $MaxDebit = isset($data['max_debit']) & !Helper::is_empty_string($data['max_debit']) ? $data['max_debit'] : 0;
    $check = isset($data['checkall']) ? $data['checkall'] : false;
    $EmployeeId = $check ? null : $data['employee_id'];
    $MaxDebit=round($MaxDebit,2);
    $success = $allowanceBusinessLayer->addAllowance($EmployeeId, $MaxDebit, $_SESSION['user_pos']);
    if ($success):
        if ($check):
            $message = Helper::set_message('Allowance saved succesfuly', 'status');
            $allowanceDataTable = LookupBusinessLayer::getInstance()->getEmployees();
            if (LookupBusinessLayer::getInstance()->getSuccess()):
                $container = Helper::fill_datatable('allowances', 'allowances', array(), $allowanceDataTable, array('Employe ID', 'Employee Name', 'Max Debit'), array('employee_id', 'employee_name', 'employee_max_debit'), 'employee_id', array(), false,1, 0, 'allowances', 'employee_max_debit');
                $content = $message . $container;
                include_once POS_ROOT . '/content/settings/allowance.php';
            else:
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'error connection'));
            endif;
        else:
            if (!is_numeric($MaxDebit)):
                print '0.00';
            else:
                print $MaxDebit;
            endif;
        endif;
    else:
        if ($check):
        print Helper::json_encode_array(array('status' => 'error', 'message' => 'Allowance not saved '));
        else:
            print '0.00'; 
        endif;
    endif;
endif;
?>
