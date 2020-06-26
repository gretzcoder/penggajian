// Call the dataTables jQuery plugin
$(document).ready(function () {
    $('#dataTable').DataTable({
        "columns": [{
            "width": "15%"
        }, {
            "width": "20%"
        }, {
            "width": "30%"
        }, {
            "width": "15%"
        }, {
            "width": "20%"
        }, ]
    });
    $('#dataKaryawan').DataTable({
        "aaSorting": [
            [1, 'asc']
        ],
        "columns": [{
                "width": "10%"
            }, {
                "width": "10%"
            },
            null, {
                "width": "15%"
            }, {
                "width": "25%"
            }, {
                "width": "10%"
            }, {
                "width": "5%"
            },
        ]
    });
    $('#dataTablePosition').DataTable({
        "columns": [{
            "width": "35%"
        }, {
            "width": "20%"
        }, {
            "width": "20%"
        }, {
            "width": "15%"
        }, {
            "width": "10%"
        }, ]
    });
    $('#dataPositionPegawai').DataTable({
        "columns": [{
            "width": "20%"
        }, {
            "width": "40%"
        }, {
            "width": "40%"
        }, ]
    });

    $('#dataTableAbsensi').DataTable({
        "pageLength": 50,
        "aaSorting": [
            [1, 'asc']
        ]
    });

    $('#dataTableAbsensiUser').DataTable({
        "pageLength": 50,
        "aaSorting": [
            [1, 'desc']
        ],
        "columns": [{
            "width": "25%"
        }, {
            "width": "25%"
        }, {
            "width": "25%"
        }, {
            "width": "25%"
        }, ]
    });

    $('#dataComplaint').DataTable({
        "pageLength": 50,
        "aaSorting": [
            [4, 'desc']
        ],
        "columns": [{
            "width": "8%"
        }, {
            "width": "18%"
        }, {
            "width": "12%"
        }, {
            "width": "40%"
        }, {
            "width": "12%"
        }, {
            "width": "10%"
        }, ]
    });
});
