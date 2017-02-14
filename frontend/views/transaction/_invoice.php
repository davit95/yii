<?php

use frontend\helpers\InvoiceHelper;

?>
<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            /* Body */
            .invoice-body {
                margin: 0px;
                padding: 0px;
            }

            /* Block */
            .block {
                display: block;
                padding: 0px;
                margin: 0px;
                border: 0;
            }

            /* Header */
            .header {
                padding: 10px 5px;
                margin-bottom: 10px;
                background: #092e72;
                background: -moz-linear-gradient(left, #092e72 0%, #1d55a2 41%, #1d55a2 62%, #093075 100%);
                background: -webkit-linear-gradient(left, #092e72 0%,#1d55a2 41%,#1d55a2 62%,#093075 100%);
                background: linear-gradient(to right, #092e72 0%,#1d55a2 41%,#1d55a2 62%,#093075 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#092e72', endColorstr='#093075',GradientType=1 );
                display: table;
                width: 100%;
            }
            .header .table td {
                width: 50%;
            }
            .header .logo {
                height: 50px;
            }

            /* List */
            .list {
                list-style: none;
            }
            .list.address {
                padding: 0px;
                margin: 0px;
            }

            /* Table */
            .table {
                width: 100%;
                border-collapse: collapse;
            }

            /* Invoice */
            .invoice-to {
                padding: 10px 5px;
            }
            .invoice-details {
                padding: 10px 5px;
            }
            .invoice-details .table {
                border: 1px solid #ddd;
            }
            .invoice-details .table thead th {
                background-color: #eee;
                border-bottom: 1px solid #ddd;
                font-weight: normal;
            }
            .invoice-details .table tbody td {
                background-color: #fff;
                border-bottom: 1px solid #ddd;
                padding: 3px 3px;
            }
            .invoice-details .table tfoot td {
                background-color: #eee;
                border-bottom: 1px solid #ddd;
                padding: 5px 5px;
            }
            .invoice-info {
                padding: 10px 5px;
            }

            /* Colors */
            .cl-white {
                color: #fff;
            }

            /* Backgrounds */
            .bg-gray {
                background-color: #eee;
            }

            /* Misc */
            .left {
                float: left;
            }
            .right {
                float: right;
            }
            .text-align-right {
                text-align: right;
            }
            .text-align-left {
                text-align: left;
            }
            .text-align-center {
                text-align: center;
            }
            .doc-info {
                text-align: center;
                font-size: 9px;
            }
            .clear-fix:after {
               content: " ";
               visibility: hidden;
               display: block;
               height: 0;
               clear: both;
            }
        </style>
    </head>
    <body class="invoice-body">
        <header class="header clear-fix">
            <table class="table">
                <tr>
                    <td>
                        <img class="logo" src="/images/logo.png" height="50"/>
                    </td>
                    <td>
                        <div class="address cl-white">
                            <?= InvoiceHelper::getFormattedAddress(); ?>
                        </div>
                    </td>
                </tr>
            </table>
        </header>

        <main>
            <div class="block invoice-info bg-gray">
                <ul class="list">
                    <li>Invoice #<?= $id ?></li>
                    <li>Invoice Date: <?= $transaction->getFormattedTimestamp(); ?></li>
                </ul>
            </div>
            <div class="block invoice-to">
                <ul class="list">
                    <li>Invoiced To</li>
                    <?= InvoiceHelper::getFormattedCustomerInfo($transaction, true); ?>
                </ul>
            </div>
            <div class="block invoice-details">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-align-center">Description</th>
                            <th class="text-align-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2" class="text-align-left"><?= $transaction->getTransactionData('product', '-') ?></td>
                            <td class="text-align-right"><?= $transaction->getAmountWithCurrencySym(); ?></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td class="text-align-right">Sub Total</td>
                            <td class="text-align-right"><?= $transaction->getAmountWithCurrencySym(); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-align-right">Total</td>
                            <td class="text-align-right"><?= $transaction->getAmountWithCurrencySym(); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </main>

        <footer>
            <p class="doc-info">PDF generated <?= InvoiceHelper::getGenerationDate() ?></p>
        </footer>
    </body>
</html>
