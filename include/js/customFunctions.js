let table_option_backlog;
let table_option_v2;

function setTable_DataTable(tablename) {
    $(`#table-${tablename} thead tr`).clone(true).addClass('filters').appendTo(`#table-${tablename} thead`);
    table_option_backlog = $(`#table-${tablename}`).DataTable({
        dom: 'Bfrtip',
        searching: true,
        buttons: [
            'excel'
        ],
        responsive: true,
        // "scrollY": "500px",
        // "scrollCollapse": true,
        order: [
            [0, 'asc']
        ],
        "paging": true,
        "scrollX": true,
        "pageLength": 15,
        "lengthMenu": [
            [15, 25, 50, -1],
            [15, 25, 50, "All"]
        ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function() {
            table_api = this.api();
            table_api
                .columns()
                .eq(0)
                .each(function(colIdx) {
                    var cell = $('.filters th').eq(
                        $(table_api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="' + title + '" />');
                    $(
                            'input',
                            $('.filters th').eq($(table_api.column(colIdx).header()).index())
                        )
                        .off('keyup change')
                        .on('change', function(e) {
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
                            var cursorPosition = this.selectionStart;
                            table_api
                                .column(colIdx)
                                .search(
                                    this.value != '' ?
                                    regexr.replace('{search}', '(((' + this.value + ')))') :
                                    '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
                        })
                        .on('keyup', function(e) {
                            e.stopPropagation();
                            $(this).trigger('change');
                            // $(this)
                            //     .focus()[0]
                            //     .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        },
        select: true,
    });

    // Find(`.sorting.sorting_asc`)
    // console.log($(`.sorting.sorting_asc`))
    $(`.sorting.sorting_asc`).click()
}
function setTable_DataTableNofilter(tablename) {
    // $(`#table-${tablename} thead tr`).clone(true).addClass('filters').appendTo(`#table-${tablename} thead`);
    table_option_backlog = $(`#table-${tablename}`).DataTable({
        dom: 'Bfrtip',
        searching: true,
        buttons: [
             'excel'
        ],
        responsive: true,
        // "scrollY": "500px",
        // "scrollCollapse": true,
        order: [
            [0, 'asc']
        ],
        "paging": true,
        "scrollX": true,
        "pageLength": 15,
        "lengthMenu": [
            [15, 25, 50, -1],
            [15, 25, 50, "All"]
        ],
        orderCellsTop: true,
        fixedHeader: true,
       
        select: true,
    });

    // Find(`.sorting.sorting_asc`)
    // console.log($(`.sorting.sorting_asc`))
    $(`.sorting.sorting_asc`).click()
}


function setTable_DataTableV2(tablename) {
    $(`#table-${tablename} thead tr`).clone(true).addClass('filters').appendTo(`#table-${tablename} thead`);
    table_option_v2 = $(`#table-${tablename}`).DataTable({
        dom: 'Bfrtip',
        searching: true,
        buttons: [
            'excel'
        ],
        responsive: true,
        // "scrollY": "500px",
        // "scrollCollapse": true,
        order: [
            [0, 'asc']
        ],
        "paging": true,
        "scrollX": true,
        "pageLength": 15,
        "lengthMenu": [
            [15, 25, 50, -1],
            [15, 25, 50, "All"]
        ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function() {
            table_api = this.api();
            table_api
                .columns()
                .eq(0)
                .each(function(colIdx) {
                    var cell = $('.filters th').eq(
                        $(table_api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="' + title + '" />');
                    $(
                            'input',
                            $('.filters th').eq($(table_api.column(colIdx).header()).index())
                        )
                        .off('keyup change')
                        .on('change', function(e) {
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
                            var cursorPosition = this.selectionStart;
                            table_api
                                .column(colIdx)
                                .search(
                                    this.value != '' ?
                                    regexr.replace('{search}', '(((' + this.value + ')))') :
                                    '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
                        })
                        .on('keyup', function(e) {
                            e.stopPropagation();
                            $(this).trigger('change');
                            // $(this)
                            //     .focus()[0]
                            //     .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        },
        select: false,
        // select: {
        //     toggleable: false
        // }
        select: {
            items: 'rows',
            info: false
        }
    });

    // Find(`.sorting.sorting_asc`)
    // console.log($(`.sorting.sorting_asc`))
    $(`.sorting.sorting_asc`).click()
}
let table_option_table;

function setTable_DataTableNoFilterNoExport(tablename) {
    // $(`#table-${tablename} thead tr`).clone(true).addClass('filters').appendTo(`#table-${tablename} thead`);
    table_option_table = $(`#table-${tablename}`).DataTable({
        dom: 'Bfrtip',
        searching: true,
        buttons: [],
        responsive: true,
        // "scrollY": "500px",
        // "scrollCollapse": true,
        order: [
            [0, 'asc']
        ],
        "paging": true,
        "scrollX": true,
        "pageLength": 15,
        "lengthMenu": [
            [15, 25, 50, -1],
            [15, 25, 50, "All"]
        ],
        orderCellsTop: true,
        fixedHeader: true,
        select: {
            items: 'rows',
            info: false
        }
        // select: false,
    });

    // Find(`.sorting.sorting_asc`)
    // console.log($(`.sorting.sorting_asc`))
    $(`.sorting.sorting_asc`).click()
}



function createTextareaEditor(token) {
    let set__toolbar = [
        'title',
        'bold',
        'italic',
        'underline',
        'strikethrough',
        'fontScale',
        'color',
        'ol',
        'ul',
        'blockquote',
        // 'code',
        'table',
        'link',
        'image',
        'hr',
        'indent',
        'outdent',
        'alignment',
        'html'
    ]
    let set__upload = {
        url: `../../include/php/upload_ontextEditor.php`,
        params: 1,
        fileKey: 'upload_file',
        connectionCount: 1,
        leaveConfirm: 'Uploading is in progress, are you sure to leave this page?',
        pasteImage: true,
    }
    let set__defaultImage = `../../include/img/image128.png`
    editorTextArea = new Simditor({
        textarea: $(`#textarea-${token}`),
        defaultImage: set__defaultImage,
        upload: set__upload,
        toolbarFloat: true,
        toolbar: set__toolbar,
        allowedStyles: {
            td: ['text-align', 'padding', 'font-family', 'font-size', 'line-height', 'color'],
            th: ['text-align', 'padding', 'font-family', 'font-size', 'line-height', 'color'],
            span: ['color', 'font-size'],
            b: ['color'],
            i: ['color'],
            strong: ['color'],
            strike: ['color'],
            u: ['color'],
            p: ['margin-left', 'text-align'],
            h1: ['margin-left', 'text-align'],
            h2: ['margin-left', 'text-align'],
            h3: ['margin-left', 'text-align'],
            h4: ['margin-left', 'text-align']

        },
        allowedAttributes: {
            img: ['src', 'alt', 'width', 'height', 'data-non-image'],
            a: ['href', 'target'],
            font: ['color'],
            code: ['class'],
            body: ['style']
        },
        allowedTags: ['br', 'body', 'meta', 'span', 'a', 'img', 'b', 'strong', 'i', 'strike', 'u', 'font', 'p', 'ul', 'ol', 'li', 'blockquote', 'pre', 'code', 'h1', 'h2', 'h3', 'h4', 'hr'],


    });
}

function createGraphQuestionInSurvey(data, showInId) {
    let arrLast6Month = [];
    let arrInprocess = [];
    let arrCompleted = [];

    var options = {
        series: [{
            name: `จำนวน`,
            type: 'column',
            data: data.data
        }],
        chart: {
            height: 350,
            type: 'bar', // bar line 
            stacked: true,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: true
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 10,
                dataLabels: {
                    position: 'top', // top, center, bottom
                },
            },
            line: {
                borderRadius: 10,
                dataLabels: {
                    position: 'top', // top, center, bottom
                },
            }
        },
        stroke: {
            // width: [0,4],
            // colors:['#bd2300']
        },
        dataLabels: {

            enabled: true,
            enabledOnSeries: [0, 1],
            formatter: function(val) {
                return `${addCommas(parseFloat(val).toFixed(0))} (${addCommas(parseFloat(val*100/data.countReply).toFixed(0))}%)`;
            },
            offsetY: 0,
            style: {
                fontSize: '10px',
                colors: ["#ffffff", "#ffffff"]
            }
        },
        xaxis: {
            categories: data.Labels,
            position: 'bottom',
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                    }
                }
            },
            tooltip: {
                enabled: false,
            },
            labels: {
                // formatter: function(value, timestamp, opts) {
                    
                //     // return value.length > 20 ? `${value.slice(0, 20)}...` : `${value}`;
                // }
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: true,
                formatter: function(val) {
                    return `${addCommas(parseFloat(val).toFixed(0))}`;
                }
            }
        },
        title: {
            text: data.txt,
            floating: false,
            offsetY: 0,
            align: 'left',
            style: {
                fontFamily: 'Noto Sans Thai',
                fontWeight: '600',
                color: '#444'
            }
        },
        opposite: true,
        subtitle: {
            text: data.subtext,
            align: 'left',
            margin: 10,
            offsetX: 0,
            offsetY: 20,
            floating: false,
            style: {
                fontSize: '12px',
                fontWeight: 'normal',
                fontFamily: 'Noto Sans Thai',
                color: '#9699a2'
            },
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        fill: {
            opacity: 1
        }
        //   ,colors:[ '#26a0fc','#e63710', '#3591D0','#BCBCBC']
        ,
        colors: ['#e63710', '#26a0fc', '#3591D0', '#BCBCBC']
    };
    let chartMyJobInThisYear = new ApexCharts(Find(`#${showInId}`), options);
    chartMyJobInThisYear.render();


}