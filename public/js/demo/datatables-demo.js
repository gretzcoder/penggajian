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


});
