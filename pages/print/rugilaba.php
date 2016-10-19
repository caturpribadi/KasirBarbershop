<?php

    ob_start();
    include(dirname(__FILE__).'/rugilabaprint.php');
    $content = ob_get_clean();

    // convert in PDF
    require_once(dirname(__FILE__).'/../../dist/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', array(15, 10, 5, 5));
        $html2pdf->setTestTdInOnePage(false);
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('rugilaba.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }