<?php
session_start();
require_once('../login/verifycation.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../src/styles/style.css">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- DevExtreme theme -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/21.2.8/css/dx.light.css">
    <!-- DevExtreme library -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/6.26.0/polyfill.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js" integrity="sha512-Qlv6VSKh1gDKGoJbnyA5RMXYcvnpIqhO++MhIM2fStMcGT9i2T//tSwYFlcyoRRDcDZ+TYHpH8azBBCyhpSeqw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/21.2.8/js/dx.all.js"></script>
    <style>
        .sidebar {
            position: relative!important;
        }
    </style>
</head>
<body class="dx-viewport">
<main id="content" class="content d-flex flex-nowrap">
    <?php
    include '../templates/system/sidebar.php';
    ?>
    <div class="container" style="padding-top: 2em">
        <div id="nav-btn" class="nav-btn">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <h2>Сохраненные отчёты</h2>
        <div id="dataGrid">
        </div>
    </div>
</main>
<script>
    <?php
    include '../apps/radaris/view.php';
    ?>
    fields = JSON.parse(fields);

    $(function() {
      $('#dataGrid').dxDataGrid({
        dataSource: fields,
        keyExpr: "id",
        columns: [{
          dataField: "id",
          caption: 'ID в БД',
        }, {
          dataField: "lead_id",
          caption: 'Отчёт radaris',
          cellTemplate(container, options) {
            const div = $("<div></div>");
            div.append($('<a>', {
              href: `https://radaris.com/report/i-${options.value}?first_time=1`,
              target: '_blank',
              style: "padding: 10px;",
            }).text(options.value));
            return div;
            },
        }, {
          dataField: "name",
          caption: 'Имя и фамилия',
        }, {
          dataField: "last_known_address",
          caption: "Последний упомянутый адрес",
        },{
          dataField: "date_of_birth",
          caption: "Дата рождения",
          dataType: 'date',
        },{
          dataField: "age",
          caption: "Возраст",
        },{
          dataField: "social_security_numbers",
          caption: "Номера",
        },],
        columnAutoWidth: true,
        searchPanel: {
          visible: true,
          highlightCaseSensitive: true,
        },
        groupPanel: { visible: true },
        grouping: {
          autoExpandAll: false,
        },
       // export: {
       //    enabled: true,
       //    allowExportSelectedData: true,
       //  },
        allowColumnReordering: true,
        rowAlternationEnabled: true,
        showBorders: true,
        filterRow: { visible: true },
        headerFilter: { visible: true },
        scrolling: {
          rowRenderingMode: 'virtual',
        },
        paging: {
          pageSize: 25,
        },
        pager: {
          visible: true,
          allowedPageSizes: [25, 50, 100, 'all'],
          showPageSizeSelector: true,
          showInfo: true,
          showNavigationButtons: true,
        },
      });
    });
</script>
<script src="../src/js/main.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
