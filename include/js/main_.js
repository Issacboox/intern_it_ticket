let URLAPI = '../api/master/';
const URLAPIBT2016 = '../api/bt2016/';
let byId = function(id) { return document.getElementById(id); };
let byClass = function(id) { return document.getElementsByClassName(id); }
let byTag = function(id) { return document.getElementsByTagName(id); }
let createE = function(id) { return document.createElement(id); };
let Find = function(tag) { return document.querySelector(tag); }
let FindAll = function(tag) { return document.querySelectorAll(tag); }
let btnUploadImgProfile = function(idInput) { byId(idInput).click() }
let openModal = function(id) { $('#modal-' + id).modal('show') }
let closeModal = function(id) { $('#modal-' + id).modal('hide') }
let configToTimeZone = 0
let configToTimeZoneNet = 0

let createTagE = function(nametag, arrClass) {
    let tag = createE(nametag)
    for (let i = 0; i < arrClass.length; i++) { tag.classList.add(arrClass[i]) }
    return tag
}

function setTitleBar(PageName) {
    document.title = `${PageName} - BT Midland Co.,Ltd.`
}
let DEFAULT_PROFILE = `./include/img/profile/defaultProfile.jpg`;
let BASEPATH;
// let URLAPI = '../../../api/master/';
function setPathURL_T(path) {
    console.log(path)
    BASEPATH = path;
    DEFAULT_PROFILE = `${BASEPATH}include/img/profile/defaultProfile.jpg`;
    URLAPI = `${path}api/master/`;
    // //console.log(path, URLAPI);
    // //console.log(YOURDOMAIN)
}



let createTd = function(num, tr) {
    let ArrReturn = []
    for (let i = 0; i < num; i++) {
        let cell = createTagE("td", ['td' + i]);
        tr.appendChild(cell);
        ArrReturn.push(cell)
    }
    ArrReturn[num - 1].classList.add('text-right');
    return ArrReturn
}
let arrWeek = ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."]
let arrMonthThaiFull = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"]
let ArrMonth = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม']
let ArrMonthShort = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.']
let ArrMonthEN = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
let ArrMonthENShort = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec']
let ArrMonthENShortV2 = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
let ArrDayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
let ArrDayNamesShort = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
let ArrDayInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]
let ArrDayNamesTH = ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"]
let ArrDayNamesTHShort = ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."]

// moment.tz.setDefault("Asia/Bangkok");
// moment.locale('th')
// moment.locale('TH');


// moment.lang('TH');
// moment.locale('TH', {
//     months: arrMonthThaiFull,
//     monthsShort: ArrMonthShort,
//     monthsParseExact: true,
//     // weekdays : 'dimanche_lundi_mardi_mercredi_jeudi_vendredi_samedi'.split('_'),
//     weekdays: ArrDayNamesTH,
//     weekdaysShort: ArrDayNamesTHShort,
//     weekdaysMin: ArrDayNamesTHShort,
//     weekdaysParseExact: true,


//     // longDateFormat : {
//     //     LT : 'HH:mm',
//     //     LTS : 'HH:mm:ss',
//     //     L : 'DD/MM/YYYY',
//     //     LL : 'D MMMM YYYY',
//     //     LLL : 'D MMMM YYYY HH:mm',
//     //     LLLL : 'dddd D MMMM YYYY HH:mm'
//     // },
//     // calendar : {
//     //     sameDay : '[Aujourd’hui à] LT',
//     //     nextDay : '[Demain à] LT',
//     //     nextWeek : 'dddd [à] LT',
//     //     lastDay : '[Hier à] LT',
//     //     lastWeek : 'dddd [dernier à] LT',
//     //     sameElse : 'L'
//     // },
//     // relativeTime : {
//     //     future : 'dans %s',
//     //     past : 'il y a %s',
//     //     s : 'quelques secondes',
//     //     m : 'une minute',
//     //     mm : '%d minutes',
//     //     h : 'une heure',
//     //     hh : '%d heures',
//     //     d : 'un jour',
//     //     dd : '%d jours',
//     //     M : 'un mois',
//     //     MM : '%d mois',
//     //     y : 'un an',
//     //     yy : '%d ans'
//     // },
//     // dayOfMonthOrdinalParse : /\d{1,2}(er|e)/,
//     // ordinal : function (number) {
//     //     return number + (number === 1 ? 'er' : 'e');
//     // },
//     // meridiemParse : /AM|PM/,
//     // isPM : function (input) {
//     //     return input.charAt(0) === 'M';
//     // },
//     // In case the meridiem units are not separated around 12, then implement
//     // this function (look at locale/id.js for an example).
//     // meridiemHour : function (hour, meridiem) {
//     //     return /* 0-23 hour, given meridiem token and hour 1-12 */ ;
//     // },
//     meridiem: function(hours, minutes, isLower) {
//         // console.log(hours, minutes, isLower)
//         return hours < 12 ? 'เช้า' : hours == 12 ? 'เที่ยง' : 'บ่าย';
//     },
//     week: {
//         dow: 1, // Monday is the first day of the week.
//         doy: 4 // Used to determine first week of the year.
//     },
//     months: arrMonthThaiFull,
//     days: ArrDayNamesTH
// });

// moment().add(543, 'year')



$(window).ready(() => {
    // console.log(moment.locale())
    // console.log(moment())



    // console.log(moment.locale('th'))
    // console.log(moment.locale())
    // if (moment.locale() != 'th') {
    //     // configToTimeZone = 25200
    //     // configToTimeZoneNet = 25200 * 1000
    // }
    // saveLogsFile('all', 'filename', 'ready')

    // // checkAlertNotofication()
    // $('.menu').click(function(e) {
    //     checkAlertNotofication()
    //     const active = document.querySelectorAll('.menu');
    //     for (let i = 0; i < active.length; i++) {
    //         active[i].classList.remove('active')
    //     }
    //     if (window.screen.width < 1200) {
    //         $('.navbar-toggler').click()
    //     }
    //     let menu = this.dataset.menu
    //     let title = 'Welfare request - BT Midland Co.,Ltd.'

    //     // console.log(menu)
    //     $(this).addClass('active');
    //     if (menu == 'emp') {
    //         createPageEmp('all', '')
    //         document.title = "จัดการข้อมูลพนักงาน - " + title;
    //     } else if (menu == 'setting') {
    //         createPageSetting('all', '')
    //         document.title = "จัดการข้อมูลวงเงิน/กลุ่มอาการ - " + title;
    //     } else if (menu == 'profile') {
    //         createPageProfile('profile', '')
    //         document.title = "ข้อมูลส่วนตัว - " + title;
    //     } else if (menu == 'child') {
    //         createPageChildEmp('all', '')
    //         document.title = "บุตรพนักงาน - " + title;
    //     } else if (menu == 'form') {
    //         createPageFormRequest('all', '')
    //         document.title = "ฟอร์มขอเบิก - " + title;
    //     } else if (menu == 'form-request') {
    //         createPageRequestHistory('all', '')
    //         document.title = "คำขอ - " + title;
    //     } else if (menu == 'home') {
    //         createPageHome()
    //     } else {
    //         document.title = title;
    //         byId('App').innerHTML = 'ไม่พบเมนูที่ต้องการ โปรดรอสักครู่และลองใหม่อีกครั้ง'
    //     }


    // })

    $('.btn-signout').click(function() {
        logout()
    })

});




// console.log(convertDate(1644498354))


function convertDate(milliseconds) {


    let myDate = new Date(milliseconds * 1000);

    let returnArr = {
        'data': milliseconds,
        'json': myDate.toJSON(),
        'd': myDate.getDate(),
        'h': myDate.getHours() >= 10 ? myDate.getHours() : `0${myDate.getHours()}`,
        'm': myDate.getMinutes() >= 10 ? myDate.getMinutes() : `0${myDate.getMinutes()}`,
        's': myDate.getSeconds(),
        'dateSQL': myDate.toJSON().slice(0, 10),
        'dateSQLFull':`${myDate.toJSON().slice(0, 10)} ${myDate.getHours() >= 10 ? myDate.getHours() : `0${myDate.getHours()}`}:${myDate.getMinutes() >= 10 ? myDate.getMinutes() : `0${myDate.getMinutes()}`}`,
        'd': myDate.getDate(),
        'h': myDate.getHours() >= 10 ? myDate.getHours() : `0${myDate.getHours()}`,
        'm': myDate.getMinutes() >= 10 ? myDate.getMinutes() : `0${myDate.getMinutes()}`,
        'timeHM':`${myDate.getHours() >= 10 ? myDate.getHours() : `0${myDate.getHours()}`}:${myDate.getMinutes() >= 10 ? myDate.getMinutes() : `0${myDate.getMinutes()}`} น.`,
        's': myDate.getSeconds(),
        'dayInMonth': ArrDayInMonth[myDate.getMonth()],
        'typeDMY_TH':`${myDate.getDate()} ${ArrMonth[myDate.getMonth()]} ${myDate.getFullYear()}`,
        'typeDMY_TH_short':`${myDate.getDate()} ${ArrMonthShort[myDate.getMonth()]} ${myDate.getFullYear()}`,
        'typeDMY_EN_short':`${myDate.getDate()} ${ArrMonthENShortV2[myDate.getMonth()]} ${myDate.getFullYear()}`,

        'full_1':`${myDate.getHours() >= 10 ? myDate.getHours() : `0${myDate.getHours()}`}:${myDate.getMinutes() >= 10 ? myDate.getMinutes() : `0${myDate.getMinutes()}`} น. ${myDate.getDate()} ${ArrMonthShort[myDate.getMonth()]} ${myDate.getFullYear()}`,
        'full_2':`${myDate.getHours() >= 10 ? myDate.getHours() : `0${myDate.getHours()}`}:${myDate.getMinutes() >= 10 ? myDate.getMinutes() : `0${myDate.getMinutes()}`} น.  วัน${ArrDayNamesTH[myDate.getDay()]} ${myDate.getDate()} ${ArrMonthShort[myDate.getMonth()]} ${myDate.getFullYear()}`,
        'full_3':`วัน${ArrDayNamesTH[myDate.getDay()]} ที่ ${myDate.getDate()} ${ArrMonth[myDate.getMonth()]} ${myDate.getFullYear()}`,

        'day': {
            // 'digit': myDate.getDay(),
            'digit': myDate.getDate(),
            'digit_': myDate.getDate() >= 10 ? myDate.getDate() : `0${myDate.getDate()}`,
            'en': {
                'full': ArrDayNames[myDate.getDay()],
                'short': ArrDayNamesShort[myDate.getDay()]
            },
            'th': {
                'full': ArrDayNamesTH[myDate.getDay()],
                'short': ArrDayNamesTHShort[myDate.getDay()]
            }
        },
        'month': {
            'digit': myDate.getMonth() + 1,
            'digit_': myDate.getMonth() + 1 >= 10 ? myDate.getMonth() + 1 : `0${myDate.getMonth()+1}`,
            'th': {
                'full': ArrMonth[myDate.getMonth()],
                'short': ArrMonthShort[myDate.getMonth()]
            },
            'en': {
                'full': ArrMonthEN[myDate.getMonth()],
                'short': ArrMonthENShort[myDate.getMonth()]
            }

        },
        'year': {
            'full': myDate.getFullYear(),
            'th': {
                'full': myDate.getFullYear() + 543,
                'short': myDate.getFullYear() - 1957,
            },
            'en': {
                'full': myDate.getFullYear(),
                'short': myDate.getFullYear() - 2000,
            }
        }
    }
    return returnArr
}


function connectApi(dataUrl, dataArray, loading, handleData) {
    let username = 'AdminBt'
    let password = 'btmidland@2022'
    console.log(URLAPI + dataUrl)
    $.ajax({
        type: 'post',
        url: URLAPI + dataUrl,
        data: JSON.stringify(dataArray),
        contentType: "application/json",
        dataType: "json",
        headers: { "Authorization": btoa(username + ":" + password) },
        success: function(result) {
            if (loading != '') {
                byId(loading).classList.remove('loading', 'ui', 'form')
            }
            handleData(result)
        },
        beforeSend: function() {
            if (loading != '') {
                byId(loading).classList.add('loading', 'ui', 'form')
            }
        },
        error: function(data, errorThrown) {
            console.log('request failed : ' + errorThrown);

            showErrorConnect('ตรวจสอบการเชื่อมต่อ หรือลองรีเฟรชหน้านี้ใหม่อีกครั้ง', dataUrl, JSON.stringify(dataArray).toString(), errorThrown)
        }
    });
}

function connectApiV2(dataUrl, dataArray, loading, handleData) {
    let username = 'AdminBt'
    let password = 'btmidland@2022'
    $.ajax({
        type: 'post',
        url: URLAPI + dataUrl,
        data: JSON.stringify(dataArray),
        contentType: "application/json",
        dataType: "json",
        headers: { "Authorization": btoa(username + ":" + password) },
        success: function(result) {
            if (loading != '') {
                byId(loading).classList.remove('loading', 'ui', 'form')
            }
            byId('LoadingFullPage').style.display = 'none'
                // byId('LoadingFullPage').style.animation = 'fadeinout01 .2s linear forwards';

            // byId('LoadingFullPage').style.animation = 'fadeinout .3s linear forwards';
            handleData(result)
        },
        beforeSend: function() {
            if (loading != '') {
                byId(loading).classList.add('loading', 'ui', 'form')
            }
            byId('LoadingFullPage').style.display = 'block';
            // byId('LoadingFullPage').style.animation = '';

        },
        error: function(data, errorThrown) {
            console.log('request failed : ' + errorThrown);

            showErrorConnect('ตรวจสอบการเชื่อมต่อ หรือลองรีเฟรชหน้านี้ใหม่อีกครั้ง', dataUrl, JSON.stringify(dataArray).toString(), errorThrown)
        }
    });
}



function connectApiBT2016(dataUrl, dataArray, loading, handleData) {
    let username = 'AdminBT-Midland'
    let password = 'btmidland@2022'
    $.ajax({
        type: 'post',
        url: URLAPIBT2016 + dataUrl,
        data: JSON.stringify(dataArray),
        contentType: "application/json",
        dataType: "json",
        headers: { "Authorization": btoa(username + ":" + password) },
        success: function(result) {
            if (loading != '') {
                byId(loading).classList.remove('loading', 'ui', 'form')
            }
            handleData(result)
        },
        beforeSend: function() {
            if (loading != '') {
                byId(loading).classList.add('loading', 'ui', 'form')
            }
        },
        error: function(data, errorThrown) {
            console.log('request failed : ' + errorThrown);

            showErrorConnect('ตรวจสอบการเชื่อมต่อ หรือลองรีเฟรชหน้านี้ใหม่อีกครั้ง', dataUrl, JSON.stringify(dataArray).toString(), errorThrown)
        }
    });
}



function InputSearchData(type, table) {
    // console.log(table)
    let search = byId(`search-${table}`).value;
    // let userId = DATA_USER_LOGIN.emp_id
    saveLogsFile('all', '', `Search Table : ${table}`)

    if (table == 'head-table-ApiReturnDate') {
        getDataPlanDate('plan-return-date', 'ApiReturnDate')
    } else if (table == 'head-table-employee') {
        getDataEmpAll('employee')
    } else if (table == 'delivery') {
        getDataDelivery('delivery')
    } else if (table == 'workType') {
        getDataWorkType('workType')
    } else if (table == 'historyAssign') {
        getDataHistoryAssign('historyAssign')
    } else if (table == 'ApiPlan') {
        getDataPlan('delivery-plan-manage', 'ApiPlan')
    } else if (table == 'EmailGroup') {
        getDataEmailGroup(table)
    } else if (table == 'EmailGroup-user') {
        getDataEmailUser(table, SELECT_TOKEN)
    } else if (table == 'historyAssign') {
        getDataHistoryAssign('historyAssign')
    }

}

let logout = function() {
    Swal.fire({
        icon: 'warning',
        title: 'ออกจากระบบ',
        showCancelButton: true,
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => { if (result.isConfirmed) { window.location = 'logout.php' } });
}
let logoutWork = function() {
    Swal.fire({
        icon: 'warning',
        title: 'ออกจากระบบ',
        showCancelButton: true,
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => { if (result.isConfirmed) { window.location = '../logout.php' } });
}

let deletePreview = function(id) {
    document.getElementById('btnUploadImg' + id).style.display = 'block'
    document.getElementById('divPreviewImg' + id).innerHTML = ''
    document.getElementById('inputUpload-' + id).value = ''
}

function readURLPreview(e, Imgid) {
    if (e.files && e.files[0]) {
        var reader = new FileReader();
        byId('divPreviewImg' + Imgid).classList.add('ui', 'loading', 'form')
        reader.onload = function(e) {
            if (Imgid == 'Profile') {
                let divPreviewProfile = byId('divPreviewImg' + Imgid)
                let previewProfile = createTagE('div', ['previewP' + Imgid])
                let btnOption = createTagE('div', ['btnOption'])
                let i = createTagE('i', ['fas', 'fa-trash-alt'])
                i.setAttribute('onclick', 'deletePreview(\'' + Imgid + '\')')
                byId('btnUploadImg' + Imgid).style.display = 'none'
                previewProfile.style.backgroundImage = "url('" + e.target.result + "')"
                btnOption.appendChild(i)
                divPreviewProfile.appendChild(previewProfile)
                divPreviewProfile.appendChild(btnOption)
            }
            byId('divPreviewImg' + Imgid).classList.remove('ui', 'loading', 'form')
        }

        reader.readAsDataURL(e.files[0]);
    }
}

function createDataTable(tablename, divname, arrayhead) {
    let t = byId(`table-${tablename}`);
    let boxbox = byId(`boxbox-table-${tablename}`);
    if (t) { t.remove(); }
    if (boxbox) { boxbox.remove(); }
    let table = createTagE("table", ['ui', 'very', 'compact', 'table', 'selectable']);
    byId(divname).innerHTML = ''
    byId(divname).appendChild(table);
    table.setAttribute("id", "table-" + tablename);
    let thead = createE('thead');
    let trHeader = createE('tr');
    for (let i = 0; i <= arrayhead.length - 1; i++) {
        let thHeader0 = createE('th');
        thHeader0.innerHTML = arrayhead[i];
        trHeader.appendChild(thHeader0);
        if (i === arrayhead.length - 1) {
            thHeader0.classList.add('text-right');
        }
    }
    thead.appendChild(trHeader);
    table.appendChild(thead);
}

function createDataTableV2(tablename, divname, arrayhead, title, btn) {
    let t = byId("table-" + tablename);
    let boxbox = byId("boxbox");
    if (t) { t.remove(); }
    if (boxbox) { boxbox.remove(); }
    let table = createTagE("table", ['ui', 'very', 'compact', 'table', 'selectable']);
    byId(divname).innerHTML = ''
    byId(divname).appendChild(table);
    table.setAttribute("id", "table-" + tablename);
    let thead = createE('thead');
    let trHeader = createE('tr');
    let trHeader0 = createE('tr');
    for (let i = 0; i <= arrayhead.length - 1; i++) {
        let thHeader1 = createE('th');
        thHeader1.innerHTML = arrayhead[i];
        trHeader.appendChild(thHeader1);
        if (i === arrayhead.length - 1) {
            thHeader1.classList.add('text-right');
        }
    }
    let thHeader0 = createTagE('th', []);
    thHeader0.setAttribute('colspan', arrayhead.length - 2)
    thHeader0.innerHTML = title
    let thHeader00 = createTagE('th', []);
    thHeader00.setAttribute('colspan', 2)

    let divBtn = createTagE('div', ['btnTitle-Header'])
    divBtn.innerHTML = btn
    thHeader00.appendChild(divBtn)
    trHeader0.appendChild(thHeader0);
    trHeader0.appendChild(thHeader00);
    // for (let i = 0; i <= arrayhead.length - 1; i++) {
    //     let thHeader0 = createE('th');
    //     thHeader0.innerHTML = arrayhead[i];
    //     trHeader.appendChild(thHeader0);
    //     if (i === arrayhead.length - 1) {
    //         thHeader0.classList.add('text-right');
    //     }
    // }
    thead.appendChild(trHeader0);
    thead.appendChild(trHeader);
    table.appendChild(thead);
}

function createInputByType(inputType, type, colSize, Textlabel, inputText, id, placeholder) {
    let re = ''
    let col = createE('div')
    col.setAttribute('id', `divformgroup-${id}`)
    if (type == 1) {
        col.classList.add('col-md-' + colSize, 'form-group')
        let label = createE('label')
        label.innerHTML = Textlabel
        label.setAttribute('for', id)
        let input = createTagE('div', ['input-group', 'mb-2'])
        input.innerHTML = '<div class="input-group-prepend"> <div class="input-group-text">' + inputText + '</div> </div> <input  type="' + inputType + '" id="' + id + '" class="form-control" placeholder="' + placeholder + '" >'
        col.appendChild(label)
        col.appendChild(input)
    } else if (type == 2) {
        col.classList.add('col-md-' + colSize, 'form-group')
        let label = createE('label')
        label.innerHTML = Textlabel
        label.setAttribute('for', id)
        let input = createTagE('input', ['form-control'])
        if (inputType == 'number') {
            input.setAttribute('min', '0')
        }
        input.setAttribute('id', id)
        input.setAttribute('type', inputType)
        input.setAttribute('placeholder', placeholder)
        col.appendChild(label)
        col.appendChild(input)
    } else if (type == 3) {
        col.classList.add('col-md-' + colSize, 'form-group')
        let label = createE('label')
        label.innerHTML = Textlabel
        label.setAttribute('for', id)
        let select = createTagE('select', ['form-control'])
        select.setAttribute('id', id)
        col.appendChild(label)
        col.appendChild(select)
    } else if (type == 4) {
        col.classList.add('col-md-' + colSize, 'form-group')
        let div = createTagE('div', ['form-check'])
        let label = createE('label')
        label.innerHTML = Textlabel
        label.setAttribute('for', id)
        label.classList.add('form-check-label')
        let input = createTagE('input', ['form-check-input'])
        input.setAttribute('id', id)
        input.setAttribute('type', inputType)
        div.appendChild(input)
        div.appendChild(label)
        col.appendChild(div)
    } else if (type == 5) {
        col.classList.add('col-md-' + colSize, 'form-group', 'switchFT')
        let label = createTagE('label', ['switch'])
        label.setAttribute('for', 'checkbox-' + id)
        let input = createE('input')
        input.setAttribute('id', 'checkbox-' + id)
        input.setAttribute('type', 'checkbox')
        let ndiv = createTagE('div', ['slider', 'round'])
        let labelText = createTagE('div', ['ml-1'])
        labelText.innerHTML = ' ' + Textlabel
        label.appendChild(input)
        label.appendChild(ndiv)
        col.appendChild(label)
        col.appendChild(labelText)
    } else if (type == 6) {
        col.classList.add('col-md-' + colSize, 'form-group', 'mb-0')
        let inputGroup = createTagE('div', ['input-group'])
        let input = createTagE('input', ['form-control', 'form-control-sm'])
        if (inputType == 'number') {
            input.setAttribute('min', '0')
        }
        input.setAttribute('id', id)
        input.setAttribute('type', inputType)
        input.setAttribute('placeholder', placeholder)
        let inputappend = createTagE('div', ['input-group-append'])
        inputappend.innerHTML = '<button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2">' + inputText + '</button>'

        inputGroup.appendChild(input)
        inputGroup.appendChild(inputappend)
            // col.appendChild(label)
            // col.appendChild(input)
        col.appendChild(inputGroup)
    } else if (type == 7) {
        col.classList.add('col-md-' + colSize, 'form-group')
        let label = createE('label')
        label.innerHTML = Textlabel
        label.setAttribute('for', id)
        let input = createTagE('textarea', ['form-control'])
        if (inputType == 'number') {
            input.setAttribute('min', '0')
        }
        input.setAttribute('id', id)
        input.setAttribute('rows', 2)
        input.setAttribute('placeholder', placeholder)

        col.appendChild(label)
        col.appendChild(input)
    } else if (type == 8) {
        // col.classList.add('col-md-' + colSize, 'form-group')
        // let label = createE('label')
        // label.innerHTML = Textlabel
        // label.setAttribute('for', id)
        let select = createTagE('select', ['form-control'])
        select.setAttribute('id', id)
            // col.appendChild(label)
        col.appendChild(select)
    } else if (type == 9) {

        col.classList.add(`col-md-${colSize}`, 'form-group')
        let customfile = createTagE('div', ['custom-file'])
        let labelShow = createE('label')
        labelShow.innerHTML = Textlabel
        labelShow.setAttribute('for', `label-show-${id}`)

        let label = createTagE('label', ['custom-file-label'])
        label.innerHTML = placeholder
        label.setAttribute('for', id)

        let input = createTagE('input', ['custom-file-input'])
        input.setAttribute('id', id)
        input.setAttribute('type', inputType)
        customfile.appendChild(input)
        customfile.appendChild(label)
        col.appendChild(labelShow)
        col.appendChild(customfile)
    }

    re = col
    return re
}

function setDefaultInput(ArrId) {
    for (let i = 0; i < ArrId.length; i++) {
        $(`#${ArrId[i]}`).change(function() {
            $(`[for=${ArrId[i]}]`).text(this.files[0].name);
        });
    }
}

function checkDataInputRequest(arrIdInput) {
    let noterr = true
    for (let i = 0; i < arrIdInput.length; i++) {
        let input = byId(arrIdInput[i])
        if (input.value == '') {
            input.classList.add('is-invalid')
            input.classList.remove('is-valid')
            noterr = false
        } else {
            input.classList.add('is-valid')
            input.classList.remove('is-invalid')
        }
    }
    return noterr
}

function checkDataCheckInputRequest(arrIdInput) {
    let noterr = true
    for (let i = 0; i < arrIdInput.length; i++) {
        let input = byId(arrIdInput[i])
        if (input.checked) {
            input.classList.add('is-valid')
            input.classList.remove('is-invalid')
        } else {
            input.classList.add('is-invalid')
            input.classList.remove('is-valid')
            noterr = false
        }
    }
    return noterr
}

function addOptionToSelect(id, arr) {
    let e = byId(id)
        // console.log(e, id)
    for (let i = 0; i < arr.length; i++) {
        let opt = createE('option');
        opt.value = i;
        opt.innerHTML = arr[i];
        e.appendChild(opt);
    }
}

function addOptionToSelectV1(e, arrValue, arrShow, selectedOption) {
    e.innerHTML = ''
    let opt = createE('option');
    // if()
    opt.value = '';
    opt.innerHTML = 'Select...';
    e.appendChild(opt);
    for (let i = 0; i < arrValue.length; i++) {
        let opt = createE('option');
        opt.value = arrValue[i];
        if (arrValue[i] == selectedOption) {
            opt.setAttribute('selected', true)
        }
        opt.innerHTML = arrShow[i];
        e.appendChild(opt);
    }
}

function addOptionToSelectV4(e, arrValue, arrShow, selectedOption, Datadefault) {
    e.innerHTML = ''
    let opt = createE('option');
    // if()
    opt.value = '';
    opt.innerHTML = Datadefault;
    e.appendChild(opt);
    for (let i = 0; i < arrValue.length; i++) {
        let opt = createE('option');
        opt.value = arrValue[i];
        if (arrValue[i] == selectedOption) {
            opt.setAttribute('selected', true)
        }
        opt.innerHTML = arrShow[i];
        e.appendChild(opt);
    }
}

function addOptionToSelectV2(e, arrValue, arrShow) {
    e.innerHTML = ''
    for (let i = 0; i < arrValue.length; i++) {
        let opt = createE('option');
        opt.value = arrValue[i];
        opt.innerHTML = arrShow[i];
        e.appendChild(opt);
    }
}

function addOptionToSelectV3(e, arrShow) {
    e.innerHTML = ''
    for (let i = 0; i < arrShow.length; i++) {
        let opt = createE('option');
        opt.value = i;
        opt.innerHTML = arrShow[i];
        e.appendChild(opt);
    }
}

function setInputEngOnly(id) {
    for (let i = 0; i < id.length; i++) {
        $("#" + id[i] + "").keypress(function(event) {
            var ew = event.which;
            if (ew == 32)
                return true;
            if (48 <= ew && ew <= 57)
                return true;
            if (65 <= ew && ew <= 90)
                return true;
            if (97 <= ew && ew <= 122)
                return true;
            return false;
        });
    }

}

function copyInputTo(e, toId) {
    if (toId === 'emp_email') {
        let emp_host = byId('emp_host')
        if (emp_host.value == 1) {
            byId(toId).value = e.value + '@tech.bt-midland.com'
        } else {
            byId(toId).value = e.value + '@bt-midland.com'
        }

    }
}

let createInputFile = function(textLabel, id) {
    let formGroup = createTagE('div', ['form-group', 'col-md-12'])
    let form = createTagE('div', ['ProfileEmployee'])
    let label = createE('label')
    label.innerHTML = textLabel
    form.innerHTML = `<div class="" id="divPreviewImg${id}"></div>`
    form.innerHTML += `<div onclick="btnUploadImgProfile('inputUpload-${id}')" id="btnUploadImgProfile" class="btn-${id}"> <img src="./include/img/add-img.png" width="100%" alt="" srcset=""> </div>`
    form.innerHTML += `<input style="display:none" onchange="readURLPreview(this,'${id}')" style="display: none1;" id="inputUpload-${id}" class="file-upload-${id}" type="file" accept="image/*"/>`
    formGroup.appendChild(label)
    formGroup.appendChild(form)

    return formGroup
}
let PAGE_NOW = 1;

let createParentNode = function(divname, tablename, rows_per_page) {
    if (byId('boxbox')) {
        byId('boxbox').remove()
    }
    let table = byId(`table-${tablename}`)
    let parentNode = byId(divname)
    if (parentNode) { parentNode.appendChild(table); }
    var box = paginator({
        table: parentNode.getElementsByTagName("table")[0],
        box_mode: "list",
        rows_per_page: rows_per_page,
        page: PAGE_NOW
    });
    box.className = "box";
    parentNode.appendChild(box);
}




function createBtnBadge(id, className, html) {
    let btnAdd = createTagE('span', ['badge', 'badge-pill', 'badge_btn', className])
    btnAdd.innerHTML = html
    btnAdd.setAttribute('id', id)

    return btnAdd
}

function createInputSearchUi(id, type, placeholder) {
    let div = createTagE('div', ['ui', 'icon', 'input', 'mini', 'ml-1'])
    let input = createE('input')
    input.setAttribute('id', `search-${id}`)
    input.setAttribute('autocomplete', 'off')
    input.setAttribute('type', type)
    input.setAttribute('placeholder', placeholder)
    let i = createTagE('i', ['search', 'circular', 'link', 'icon'])
    i.setAttribute('onclick', `InputSearchData('search','${id}')`)
    div.appendChild(input)
    div.appendChild(i)
    return div
}

function createInputDateTimeUi(id, type, placeholder) {
    let div = createTagE('div', ['ui', 'left', 'icon', 'input', 'mini', 'ml-1', 'DateTimeUi', 'ranges'])
    let input = createE('input')
    input.setAttribute('id', `DateTime-${id}`)
    input.setAttribute('autocomplete', 'off')
    input.setAttribute('type', type)
    input.setAttribute('placeholder', placeholder)
    let i = createTagE('i', ['calendar', 'alternate', 'icon'])
        // i.setAttribute('onclick', `InputSearchData('search','${id}')`)
    div.appendChild(input)
    div.appendChild(i)
    return div
}

function createSelectOptionUi(id, arrValue, arrOption) {
    let div = createTagE('div', ['ui', 'icon', 'input', 'mini', 'ml-1'])
    let select = createTagE('select', ['custom-select', 'custom-select-sm'])
    select.setAttribute('id', `select-${id}`)
    div.appendChild(select)
        // if (type == 1) {
        //     addOptionToSelectV3(select, arrOption)
        // } else {
    addOptionToSelectV2(select, arrOption, arrOption)
        // }

    // div.appendChild(i)
    return div
}


// function CheckDataUserLogin(token) {
//     let data = { type: 'tokenme', data: token }
//     connectApi('getdata/user', data, '', function(output) {
//         console.log(output)
//         if (output.status === 1) {
//             DATA_USER_LOGIN = output.data
//             let dataEmp = output.data
//             let show_menu_all = byId('show_menu_all')
//             let myroles = dataEmp.emp_walroles
//                 // let myroles = 2

//             // // console.log(show_menu_all)
//             // show_menu_all.innerHTML = '<div id="menu_home" data-menu="home" class="nav-item menu nav-link active"><i class="fas fa-home"></i><span>หน้าแรก</span></div>'
//             // show_menu_all.innerHTML += `<div id="menu_form" data-menu="form" class="nav-item menu nav-link"><i class="fas fa-file-medical"></i><span>ฟอร์มขอเบิก</span></div>`
//             // if (myroles == 1) {
//             //     // for Employee
//             //     show_menu_all.innerHTML += ``
//             //     show_menu_all.innerHTML += `<div id="menu_form_request" data-menu="form-request" class="nav-item menu nav-link"><i class="fas fa-history"></i><span>ประวัติ</span><span id="bagge-form-admin" class="badge"></span></div>`

//             // } else if (myroles == 2) {
//             //     // for HR Admin
//             //     show_menu_all.innerHTML += `<div id="menu_form_request" data-menu="form-request" class="nav-item menu nav-link"><i class="fas fa-hospital-user"></i><span>คำขอ</span><span id="bagge-form-admin" class="badge"></span></div>`
//             //     show_menu_all.innerHTML += `<div id="menu_emp" data-menu="emp" class="nav-item menu nav-link"><i class="fas fa-users"></i><span>พนักงาน</span></div>`
//             //     show_menu_all.innerHTML += `<div id="menu_setting" data-menu="setting" class="nav-item menu nav-link"><i class="fas fa-cogs"></i><span>จัดการ</span></div>`
//             //     show_menu_all.innerHTML += `<div id="menu_child" data-menu="child" class="nav-item menu nav-link"><i class="fas fa-child"></i><span>บุตรพนักงาน</span><span id="bagge-child-admin" class="badge"></span></div>`
//             // } else if (myroles == 3) {
//             //     // for Manager
//             //     show_menu_all.innerHTML += ``
//             //     show_menu_all.innerHTML += `<div id="menu_form_request" data-menu="form-request" class="nav-item menu nav-link"><i class="fas fa-hospital-user"></i><span>คำขอ</span><span id="bagge-form-admin" class="badge"></span></div>`

//             // } else if (myroles == 4) {
//             //     // for HR Manager
//             //     show_menu_all.innerHTML += ``
//             //     show_menu_all.innerHTML += `<div id="menu_form_request" data-menu="form-request" class="nav-item menu nav-link"><i class="fas fa-hospital-user"></i><span>คำขอ</span><span id="bagge-form-admin" class="badge"></span></div>`
//             //     show_menu_all.innerHTML += `<div id="menu_emp" data-menu="emp" class="nav-item menu nav-link"><i class="fas fa-users"></i><span>พนักงาน</span></div>`
//             //     show_menu_all.innerHTML += `<div id="menu_setting" data-menu="setting" class="nav-item menu nav-link"><i class="fas fa-cogs"></i><span>จัดการ</span></div>`
//             //     show_menu_all.innerHTML += `<div id="menu_child" data-menu="child" class="nav-item menu nav-link"><i class="fas fa-child"></i><span>บุตรพนักงาน</span><span id="bagge-child-admin" class="badge"></span></div>`

//             // } else if (myroles == 5) {
//             //     // for Director(K.Krisaruj)
//             //     show_menu_all.innerHTML += ``
//             //     show_menu_all.innerHTML += `<div id="menu_form_request" data-menu="form-request" class="nav-item menu nav-link"><i class="fas fa-hospital-user"></i><span>คำขอ</span><span id="bagge-form-admin" class="badge"></span></div>`

//             // }
//             // show_menu_all.innerHTML += `<div id="menu_profile" data-menu="profile" class="nav-item menu nav-link"><i class="fas fa-user"></i><span>ข้อมูลส่วนตัว</span></div>`
//             // show_menu_all.innerHTML += '<div class="nav-item nav-link btn-signout"><i class="fas fa-sign-in-alt"></i><span>ออกจากระบบ</span></div>'


//             // byId('nameAccountLogin').innerHTML = `<b>B${dataEmp.emp_code}</b>  ${dataEmp.emp_fname} ${dataEmp.emp_lname}`



//             // checkAlertNotofication()
//             // $('.menu').click(function(e) {
//             //     checkAlertNotofication()
//             //     const active = document.querySelectorAll('.menu');
//             //     for (let i = 0; i < active.length; i++) {
//             //         active[i].classList.remove('active')
//             //     }
//             //     if (window.screen.width < 1200) {
//             //         $('.navbar-toggler').click()
//             //     }
//             //     let menu = this.dataset.menu
//             //     let title = 'Welfare request - BT Midland Co.,Ltd.'
//             //         // console.log(menu)
//             //     $(this).addClass('active');
//             //     if (menu == 'emp') {
//             //         createPageEmp('all', '')
//             //         document.title = "จัดการข้อมูลพนักงาน - " + title;
//             //     } else if (menu == 'setting') {
//             //         createPageSetting('all', '')
//             //         document.title = "จัดการข้อมูลวงเงิน/กลุ่มอาการ - " + title;
//             //     } else if (menu == 'profile') {
//             //         createPageProfile('profile', '')
//             //         document.title = "ข้อมูลส่วนตัว - " + title;
//             //     } else if (menu == 'child') {
//             //         createPageChildEmp('all', '')
//             //         document.title = "บุตรพนักงาน - " + title;
//             //     } else if (menu == 'form') {
//             //         createPageFormRequest('all', '')
//             //         document.title = "ฟอร์มขอเบิก - " + title;
//             //     } else if (menu == 'form-request') {
//             //         createPageRequestHistory('all', '')
//             //         document.title = "คำขอ - " + title;
//             //     } else if (menu == 'home') {
//             //         createPageHome()
//             //     } else {
//             //         document.title = title;
//             //         byId('App').innerHTML = 'ไม่พบเมนูที่ต้องการ โปรดรอสักครู่และลองใหม่อีกครั้ง'
//             //     }
//             // })

//             // $('.btn-signout').click(function() {
//             //     logout()
//             // })















//         } else {
//             Swal.fire({
//                 icon: 'warning',
//                 title: 'ไม่สามารถทำรายการได้',
//                 html: output.msg,
//                 confirmButtonText: 'ตกลง',
//             })
//         }
//     })
// }

let addCommas = function(x) {
    if (x != null) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    } else {
        return x
    }

}

let CreateButtonInCellTable = function(text, color, onClick) {
    let r = '<div onclick="' + onClick + '" class=" badge  mobileMax badge-pill mr-1 px-2 py-1 upText badge-' + color + ' cursor-pointer">' + text + '</div>'
    return r
}

function editData(modal, i, type, search) {
    // $('#Modal' + modal).modal('show');
    openModal(`${modal}`)
        // console.log()
    if (modal == 'Credit') {
        let data = DATA_CREDIT_ALL[i]
        clearDataInputByArrId(['credit_id', 'credit_name', 'credit_pertime', 'credit_peryear', 'credit_deceased', 'credit_note'])
        byId('credit_name').setAttribute('disabled', true)
        byId('credit_id').value = data.credit_id
        byId('credit_name').value = data.lavel_name
        byId('credit_pertime').value = data.credit_pertime
        byId('credit_peryear').value = data.credit_peryear
        byId('credit_deceased').value = data.credit_deceased
        byId('credit_note').value = data.credit_note
        byId('btnsave').setAttribute('onclick', `CheckDataCreditFormInput(this,'${modal}','${type}','${search}')`)
            // document.getElementById('catId').value = data.catId
            // document.getElementById('catName').value = data.catName
            // document.getElementById('catDes').value = data.catDes
            // document.getElementById('btnsave').setAttribute('onclick', 'CheckDataFormInput(this,\'UpdateCategory\',[\'catName\',\'catDes\'])')
    } else if (modal == 'Symptom') {
        let data = DATA_SYMPTOM_ALL[i]
        clearDataInputByArrId(['symptom_id', 'symptom_name', 'symptom_description'])
        byId('symptom_id').value = data.symptom_id
        byId('symptom_name').value = data.symptom_name
        byId('symptom_description').value = data.symptom_description
            // console.log(data)
            // byId('btnsave').setAttribute('onclick', `CheckDataFormInput(this,'${modal}','${type}','${search}')`)
    } else if (modal == 'Child') {
        let data = DATA_CHILD_ALL[i]
        clearDataInputByArrId(['child_id', 'child_aname', 'child_fname', 'child_lname', 'child_birthday'])
        byId('child_id').value = data.child.child_id
        byId('child_aname').value = data.child.child_aname
        byId('child_fname').value = data.child.child_fname
        byId('child_lname').value = data.child.child_lname
            // byId('child_birthday').value = '21/12/1997';
            // new data.child_birthday
        SELECT_BIRTHDAY = data.child.child_birthday
        $('input[id="child_birthday"]').daterangepicker({
            opens: 'left',
            singleDatePicker: true,
            showDropdowns: true,
            startDate: new Date(data.child.child_birthday * 1000),
            maxDate: moment(),
            autoApply: true,
            "locale": {
                "format": "DD/MM/YYYY",
                "applyLabel": "ตกลง",
                "cancelLabel": "ยกเลิก",
                "daysOfWeek": arrWeek,
                "monthNames": arrMonthThaiFull,
                "firstDay": 0
            },
        }, selectBirthday);
    }

}

let clearDataInputByArrId = function(data) {
    for (let i = 0; i < data.length; i++) {
        let fatainput = byId(data[i]);
        fatainput.value = ''

        fatainput.classList.remove('is-valid', 'is-invalid')
    }
}

let clearCheckboxByArrId = function(data) {
    for (let i = 0; i < data.length; i++) {
        let fatainput = byId(data[i]);
        fatainput.checked = false
        fatainput.classList.remove('is-valid', 'is-invalid')
    }
}

function createToken(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
    }
    return result;
}

function selectBirthday(start, end) {
    let lstart = new Date(start).getTime() / 1000
        // var myDate = new Date((lstart + 7889229) * 1000);
    SELECT_BIRTHDAY = lstart
    console.log(lstart)
}

function selectDateWelfare(start, end) {
    let lstart = new Date(start).getTime() / 1000
        // var myDate = new Date((lstart + 7889229) * 1000);
    SELECT_DATA_WELFARE = lstart
    console.log(lstart)
}

function selectFilterDate(start, end) {
    let lstart = new Date(start).getTime() / 1000
    let lend = new Date(end).getTime() / 1000
        // var myDate = new Date((lstart + 7889229) * 1000);
    SELECT_FILTER_DATE_START = parseInt(lstart)
    SELECT_FILTER_DATE_END = parseInt(lend)
        // console.log(`${lstart} TO ${lend}`)
    let tableName = `MyRequestHistory`
    let userId = DATA_USER_LOGIN.emp_id
    let option = byId(`select-filter-option-${tableName}`).value;
    let option_Type = byId(`select-filter-option-${tableName}-Type`).value;
    let option_Status = byId(`select-filter-option-${tableName}-Status`).value;
    let inputsearch = byId(`search-${tableName}`).value;
    let dataAPI = [userId, option, inputsearch, option_Type, option_Status, SELECT_FILTER_DATE_START, SELECT_FILTER_DATE_END]
        // console.log(dataAPI)
    createTableDataRequestHistory('search-admin', dataAPI)
    createDataDashboardAdmin()
}

function selectFilterDateDashboard(start, end) {
    let lstart = new Date(start).getTime() / 1000
    let lend = new Date(end).getTime() / 1000
        // var myDate = new Date((lstart + 7889229) * 1000);
    SELECT_FILTER_DATE_DASHBOARD_START = parseInt(lstart)
    SELECT_FILTER_DATE_DASHBOARD_END = parseInt(lend)
        // console.log(`${lstart} TO ${lend}`)
        // let tableName = `MyRequestHistory`
        // let userId = DATA_USER_LOGIN.emp_id
        // let option = byId(`select-filter-option-${tableName}`).value;
        // let option_Type = byId(`select-filter-option-${tableName}-Type`).value;
        // let option_Status = byId(`select-filter-option-${tableName}-Status`).value;
        // let inputsearch = byId(`search-${tableName}`).value;
        // let dataAPI = [userId, option, inputsearch, option_Type, option_Status, SELECT_FILTER_DATE_START, SELECT_FILTER_DATE_END]
        //     // console.log(dataAPI)
        // createTableDataRequestHistory('search-admin', dataAPI)
    showDataDashboard('MyDashboard')
    console.log(SELECT_FILTER_DATE_DASHBOARD_START, SELECT_FILTER_DATE_DASHBOARD_END)
}

function selectFilterDateReturnDate(start, end) {
    let lstart = new Date(start).getTime() / 1000
    let lend = new Date(end).getTime() / 1000
    SELECT_FILTER__START = parseInt(lstart + configToTimeZone)
    SELECT_FILTER__END = parseInt(lend + configToTimeZone)
    createPageDataApiReturnDate('plan-return-date', 0)
    console.log(SELECT_FILTER__START, SELECT_FILTER__END)
}

function selectFilterPlanDate(start, end) {
    let lstart = new Date(start).getTime() / 1000
    let lend = new Date(end).getTime() / 1000
    SELECT_FILTER__START = parseInt(lstart + configToTimeZone)
    SELECT_FILTER__END = parseInt(lend + configToTimeZone)
        // createPageDataApiReturnDate('plan-return-date', 0)
    getDataPlan('delivery-plan-manage', 'ApiPlan')
        // createPageDataPlan('delivery-plan-manage','')
    console.log(SELECT_FILTER__START, SELECT_FILTER__END)
}


function selectFilterDateReturnDate_Calendar(start, end) {
    let lstart = new Date(start).getTime() / 1000
    let lend = new Date(end).getTime() / 1000
    SELECT_FILTER__START = parseInt(lstart + configToTimeZone)
    SELECT_FILTER__END = parseInt(lend + configToTimeZone)
    createPageDataApiReturnDateCalendar('plan-return-date', 0)
    console.log(SELECT_FILTER__START, SELECT_FILTER__END)
}


function selectFilterDateMyJob(start, end) {
    let lstart = new Date(start).getTime() / 1000
    let lend = new Date(end).getTime() / 1000
    SELECT_FILTER__START = parseInt(lstart + configToTimeZone)
    SELECT_FILTER__END = parseInt(lend + configToTimeZone)
    getDataMyJob('myJob', 'inprocess')
    console.log(SELECT_FILTER__START, SELECT_FILTER__END)
}

function selectReturnDate(start, end) {
    let lstart = new Date(start).getTime() / 1000
        // let lend = new Date(end).getTime() / 1000
    DATA_PLAN_DATE = parseInt(lstart)

    console.log(DATA_PLAN_DATE)
        // SELECT_FILTER__END = parseInt(lend)
        // createPageDataApiReturnDate('plan-return-date', 0)
        // console.log(SELECT_FILTER__START, SELECT_FILTER__END)
}

function selectReturnDate_day(start, end) {
    // console.log(start, end)
    let lstart = new Date(start).getTime() / 1000
    let lend = new Date(end).getTime() / 1000
        // console.log(lstart, lend)
    SELECT_FILTER__START_DAY = parseInt(lstart)
    SELECT_FILTER__END_DAY = parseInt(lend)
        // SELECT_FILTER__START_DAY = parseInt(lstart + configToTimeZone)
        // SELECT_FILTER__END_DAY = parseInt(lend + configToTimeZone)
        // DATA_PLAN_DATE_DAY = parseInt(lstart + configToTimeZone)
    getDataCreatePlanFromServer()
    console.log(SELECT_FILTER__START_DAY, SELECT_FILTER__END_DAY)

}




function ChangeStatusTo( tableDB, columnstatus, newstatus, columnwhere, id) {
    let data = {
        tableDB: tableDB,
        columnstatus: columnstatus,
        columnwhere: columnwhere,
        newstatus: newstatus,
        id: id
    };

    // saveLogsFile('all', '', `Change Status Table : ${tableDB} (${columnstatus}=${newstatus}) Where ${columnwhere}=${id} `)
    let divname = ''
  
    // console.log(data)
    connectApi('setStatus', data, divname, function(output) {
        let data = output.data
            // console.log(output)
        if (output.status == 1) {
            if (tableDB == 'it_request_type') {
                getdataTypeRequestSwitch();
            } 
        }
    })


}

function viewModelPDF(path, filename, title, type) {
    let ViewPDF = byId('body-ViewPDF')
    ViewPDF.innerHTML = ''
    type = type.split('/')
    openModal('ViewPDF')
    byId('ViewPDF-Title').innerHTML = title
    saveLogsFile('all', '', `View File ${path}/${filename}`)
    if (type[0] == 'application') {
        let iframe = createTagE('iframe', ['iframe-pdf-viewer'])
            // iframe.setAttribute('id', 'iframe-pdf-viewer')
        iframe.setAttribute('frameborder', 0)
        iframe.setAttribute('width', '100%')
        iframe.src = `./include/${path}${filename}`
        ViewPDF.appendChild(iframe)
    } else if (type[0] == 'image') {
        let image = createTagE('img', ['w-100'])
        image.src = `./include/${path}${filename}`
        ViewPDF.appendChild(image)
    }


    // if(type=='')
    console.log(type)



    // let iframe = byId('iframe-pdf-viewer')


    // let body = byId('body-ViewPDF')
    // body.classList.add('ui', 'loading', 'form')

}

let mobileAndTabletCheck = function() {
    let check = false;
    (function(a) { if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true; })(navigator.userAgent || navigator.vendor || window.opera);
    return check;
};

function alertConfirm(icon, title, detail, afterConfirm) {
    Swal.fire({
        icon: "success",
        title: "ดำเนินการสำเร็จ",
        showCancelButton: true,
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            return true
        } else {
            return false
        }
    })
}

function showError(msg) {
    saveLogsFile('error', `Someting Error : ${msg}`, `Someting Error : ${msg}`)
    saveLogsFile('all', '', `Show Error : ${msg}`)
    Swal.fire({
        title: 'มีบางอย่างผิดพลาด',
        html: msg,
        icon: 'warning',
        confirmButtonText: 'ลองอีกครั้ง'
    });
}

function showErrorConnect(msg, dataUrl, dataArray, error) {
    Swal.fire({
        title: 'มีบางอย่างผิดพลาด',
        html: msg,
        icon: 'warning',
        confirmButtonText: 'ลองอีกครั้ง'
    }).then((result) => {
        if (result.isConfirmed) {
            saveLogsFile('api_error', `${dataUrl} (${error})`, dataArray)
            saveLogsFile('all', ``, `api error : ${error} (${dataUrl}) `)
            window.location = './'
        }

    })
}

function showSuccess(msg) {
    Swal.fire({
        title: 'ดำเนินการสำเร็จ',
        html: msg,
        icon: 'success',
        confirmButtonText: 'ตกลง'
    });
}

function clearClassList(arrClassName) {
    for (let i = 0; i < arrClassName.length; i++) {
        const findClass = document.querySelectorAll(`.${arrClassName[i]}`);
        for (let n = 0; n < findClass.length; n++) {
            findClass[n].classList.remove(arrClassName[i])
        }
    }
}

function conditionSortData(type, up, a, b) {
    // console.log(type, up, a, b)
    if (type == 1) {
        if (a < b) {
            if (up) { return -1; } else { return 1; }
        } else if (a > b) {
            if (up) { return 1; } else { return -1; }
        } else {
            return 0;
        }
    } else {
        if (a < b) {
            if (up) { return 1; } else { return -1; }
        } else if (a > b) {
            if (up) { return -1; } else { return 1; }
        } else {
            return 0;
        }
    }

}

function SortDataBy(btn, table, data, by, type, search) {
    clearClassList(['text-filter', 'fa-sort-amount-up-alt'])
    let className = btn.className
    let up = false
    if (className.search('down') < 1) {
        btn.classList.remove('text-filter', 'fa-sort-amount-up-alt')
        btn.classList.add('text-filter', 'fa-sort-amount-down')
    } else {
        btn.classList.remove('text-filter', 'fa-sort-amount-down')
        btn.classList.add('text-filter', 'fa-sort-amount-up-alt')
        up = true;
    }
    // console.log(data)
    switch (by) {
        case 'EmpCode':
            data.sort(function(a, b) {
                return conditionSortData(1, up, a.emp.emp_code, b.emp.emp_code)
            });
            break;
        case 'RentalOrderNo':
            data.sort(function(a, b) {
                return conditionSortData(1, up, a.ol, b.ol)
            });
            break;
        case 'RentalOrderPlanReturnDate':
            data.sort(function(a, b) {
                return conditionSortData(1, up, a.returnDate, b.returnDate)
            });
            break;

        default:
    }

    if (table == 'employee') {
        createDataEmpToTable(data, type, search)
    } else if (table == 'ApiReturnDate') {
        // createDataEmpToTable(data, type, search)
        createDataReturnDateToTable(data, table, type, search)
    }


}

function resetDataTbodyBeforeCreateTable(tablename) {
    let Oldtbody = byId(`tbody-${tablename}`)
    if (Oldtbody) { Oldtbody.remove() }
    let boxbox = byId(`boxbox-table-${tablename}`)
    if (boxbox) { boxbox.remove() }
    let tbody = createE('tbody');
    tbody.setAttribute('id', `tbody-${tablename}`)

    return tbody
}

function createAlertConfirm(ConfirmType, title, e, key, id, type, search) {
    if (key == 0) {
        Swal.fire({
            icon: "question",
            title: title,
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
            input: 'text',
            inputPlaceholder: `Remark`,
            inputValidator: (value) => {
                if (value) {
                    if (ConfirmType == 'childEmp') {
                        ChangeStatusTo(e, 'welfare_child', 'child_status', key, 'child_id', id, type, search)
                        ChangeStatusTo(e, 'welfare_child', 'child_remark', value, 'child_id', id, type, search)
                    }
                } else {
                    return 'โปรดระบุข้อมูลให้ครบถ้วน!'
                }
            }
        })
    } else {
        Swal.fire({
            icon: "question",
            title: title,
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                if (ConfirmType == 'childEmp') {
                    ChangeStatusTo(e, 'welfare_child', 'child_status', key, 'child_id', id, type, search)
                }


            }

        })
    }


}



let createTagDivColumnPreview = function(htmlText, arrClass, id) {
    let div = createTagE('div', arrClass)
    div.setAttribute('id', id)
    div.innerHTML = htmlText
    return div
}

let createBoxShowNumber = function(arrText, arrcol, arrClass, color, id) {
    let colDiv = createTagE('div', arrcol)
    let col = createTagE('div', arrClass)
    col.style.backgroundColor = `${color}25`
    col.classList.add('BoxShowNumber')
    col.setAttribute('id', id)
    let text1 = createTagE('div', ['title'])
    let text2 = createTagE('div', ['Number'])
    text2.style.color = color
    text2.setAttribute('id', `textnum-${id}`)
    let text3 = createTagE('div', ['qty'])
    text1.innerHTML = arrText[0]
    text2.innerHTML = arrText[1]
    text3.innerHTML = arrText[2]
    col.appendChild(text1)
    col.appendChild(text2)
    col.appendChild(text3)
    colDiv.appendChild(col)
    return colDiv
}

let createBoxDashboardShowNumber = function(arrText, arrcol, arrClass, color, id) {
    let colDiv = createTagE('div', arrcol)
    let col = createTagE('div', arrClass)
    col.style.backgroundColor = `${color}25`
    col.classList.add('BoxDashboardShowNumber')
    col.setAttribute('id', id)
    let text1 = createTagE('div', ['title'])
    let text2 = createTagE('div', ['Number'])
    text2.style.color = color
    text2.setAttribute('id', `textnum-${id}`)
    let text3 = createTagE('div', ['qty'])
    text1.innerHTML = arrText[0]
    text2.innerHTML = arrText[1]
    text3.innerHTML = arrText[2]
    col.appendChild(text1)
    col.appendChild(text2)
    col.appendChild(text3)
    colDiv.appendChild(col)
    return colDiv
}

function createColumnPageNouFound(numcolumn, tablename) {
    let tbody = resetDataTbodyBeforeCreateTable(tablename);
    let table_row = createE('tr');
    let ArrTd = createTd(1, table_row)
    ArrTd[0].innerHTML = '- ไม่พบข้อมูล -'
    ArrTd[0].setAttribute('colspan', numcolumn)
    ArrTd[0].classList.add('text-center')
    tbody.appendChild(table_row);
    byId('table-' + tablename).appendChild(tbody)
    return true;
}

function createRadioButton(id, name, title) {
    let inputcontainer = createTagE('div', ['input-container'])
    let input = createTagE('input', ['radio-button'])
    input.setAttribute('id', `radio-${id}`)
    if (id == 1) {
        input.setAttribute('checked', 'true')
    }
    input.setAttribute('type', 'radio')
    input.setAttribute('name', name)
    let showradio = createTagE('div', ['radio-tile'])
    let label = createTagE('label', ['radio-tile-label'])
    label.setAttribute('for', `radio-${id}`)
    label.innerHTML = title
    showradio.appendChild(label)
    inputcontainer.appendChild(input)
    inputcontainer.appendChild(showradio)
    return inputcontainer
}

function createRadioButton3(id, name, title) {
    let inputcontainer = createTagE('div', ['input-container', 'input-3'])
    let input = createTagE('input', ['radio-button'])
    input.setAttribute('id', `radio3-${id}`)
    if (id == 1) {
        input.setAttribute('checked', 'true')
    }
    input.setAttribute('type', 'radio')
    input.setAttribute('data-type', `${id}`)
    input.setAttribute('name', name)
    let showradio = createTagE('div', ['radio-tile'])
    let label = createTagE('label', ['radio-tile-label'])
    label.setAttribute('for', `radio-${id}`)
    label.innerHTML = title
    showradio.appendChild(label)
    inputcontainer.appendChild(input)
    inputcontainer.appendChild(showradio)
    return inputcontainer
}

function createSelectInput() {
    let data = { type: 'getyear', data: '' }
    connectApi('getdata/credit', data, '', function(output) {
        if (output.status == 1) {
            let yaer = output.year
            let arrValue = []
            let arrShow = []
            for (let i = 0; i < yaer.length; i++) {
                arrValue.push(yaer[i].credit_year)
                arrShow.push(yaer[i].credit_year)
            }
            addOptionToSelectV2(byId('select-credit'), arrValue, arrShow)
        }
    })
}

function saveLogsFile(type, filename, contant) {
    let dataArray = {
            type: type,
            filename: filename,
            data: contant
        }
        // $.ajax({
        //     type: 'post',
        //     url: '../include/php/savelogsfile.php',
        //     data: dataArray,
        //     contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        //     dataType: "text",
        //     success: function(result) {},
        //     beforeSend: function() {

    //     }

    // });

}

function ExportFileExcel(tablename, filename) {

    let tab_text = "<table border='2px'><tr bgcolor='#909090'>";
    tab = document.getElementById(`table-${tablename}`);
    for (let j = 0; j < tab.rows.length; j++) {
        tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
    }
    filename = filename ? filename + '.xls' : 'excel_data.xls';
    saveLogsFile('all', '', `ExportFileExcel ${tablename} - Filen Name : ${filename}.xls`)
    tab_text = tab_text + "</table>";
    let ua = window.navigator.userAgent;
    let msie = ua.indexOf("MSIE ");
    downloadLink = document.createElement("a");
    downloadLink.href = 'data:application/vnd.ms-excel, ' + encodeURIComponent(tab_text);
    // downloadLink.href = 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, ' + encodeURIComponent(tab_text);

    downloadLink.download = filename;
    downloadLink.click();

    // var blob = new Blob([data], {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"});
    // var objectUrl = URL.createObjectURL(blob);
    // window.open(objectUrl);


}

function randomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

function searchArr(all, find) {
    let result = []
    for (let i = 0; i < all.length; i++) {
        if (all[i] == find) {
            result.push(i)
        }
    }
    if (result.length > 0) {
        return true
    } else {
        return false
    }
}

function searchArrToType(nameKey, myArray) {
    let result = []
    for (var i = 0; i < myArray.length; i++) {
        if (myArray[i].to_type == nameKey) {
            result.push(myArray[i])
        }
    }
    return result
}

function searchArrToTypeAssign(nameKey, myArray) {
    let result = []
    for (var i = 0; i < myArray.length; i++) {
        if (myArray[i].emp_token == nameKey) {
            result.push(myArray[i])
        }
    }
    return result
}

function collapseListItem(e, id) {
    let show = byId(id)
    let className = show.className
    console.log(className, e, id)
    if (className.search('collapse') < 1) {
        e.classList.add('fa-angle-down')
        e.classList.remove('fa-angle-up')
        show.classList.add('collapse')
            // className.add
    } else {
        e.classList.remove('fa-angle-down')
        e.classList.add('fa-angle-up')
        show.classList.remove('collapse')
    }
}

function collapseListItemV2(id, icon) {
    let show = byId(id)
    let className = show.className
    let icon_ = byId(icon)
        // console.log(className)
    if (className.search('collapse') < 1) {
        icon_.classList.add('fa-angle-down')
        icon_.classList.remove('fa-angle-up')
        show.classList.add('collapse')
            // className.add
    } else {
        icon_.classList.remove('fa-angle-down')
        icon_.classList.add('fa-angle-up')
        show.classList.remove('collapse')
    }
}

function collapseListItem_plan(e, id) {
    let show = byId(id)
    let className = show.className
    let token = e.dataset.token
        // console.log(token)
    let order_show = 1
    if (className.search('collapse') < 1) {
        e.classList.add('fa-angle-down')
        e.classList.remove('fa-angle-up')
        show.classList.add('collapse')
        order_show = 0
            // className.add
    } else {
        e.classList.remove('fa-angle-down')
        e.classList.add('fa-angle-up')
        show.classList.remove('collapse')
        order_show = 1
    }

    updateCollapseShowOnPlanOrder(token, order_show)

}

function collapseListItemV2_plan(e, id, icon) {
    let show = byId(id)
    let className = show.className
    let icon_ = byId(icon)
    let token = e.dataset.token
        // console.log(token)
    let order_show = 1
        // console.log(className)
    if (className.search('collapse') < 1) {
        icon_.classList.add('fa-angle-down')
        icon_.classList.remove('fa-angle-up')
        show.classList.add('collapse')
        order_show = 0
            // className.add
    } else {
        icon_.classList.remove('fa-angle-down')
        icon_.classList.add('fa-angle-up')
        show.classList.remove('collapse')
        order_show = 1
    }
    updateCollapseShowOnPlanOrder(token, order_show)
}

function updateCollapseShowOnPlanOrder(token, order_show) {
    let dataAPI = {
        token: token,
        show: order_show
    }

    // console.log(dataAPI)
    connectApi('getdata/plan', { type: 'update_function_show_plan', data: dataAPI, dataoption: '0' }, '', function(output) {
        console.log(output)
            // loopShowDataPlan(output.data, tablename)
    })
}

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}


function deleteCookie(name) {
    document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function ChangeSidebar(){

    
    let sidebar = byId(`sidebar`)
    console.log(1)
    if(mobileAndTabletCheck()){
        sidebar.classList.add('hide');
             sidebar.classList.remove('show');
    }else{
        sidebar.classList.remove('hide');
             sidebar.classList.add('show');
    }
    // console.log(getCookie('sidebar'))
    // if(getCookie('sidebar')){
    //     setCookie('sidebar',getCookie('sidebar')=='hide'?'show':'hide',30);

    //     if(getCookie('sidebar')=='hide'){
    //         sidebar.classList.add('hide');
    //         sidebar.classList.remove('show');
    //     }else{
    //         sidebar.classList.add('show');
    //         sidebar.classList.remove('hide');
    //     }
    // }else{
    //     setCookie('sidebar','hide',30);
    // }

}

function createTextEditor(textareaId){
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
        //  'code',
        'table',
        'link',
        // 'image',
        'hr',
        'indent',
        'outdent',
        'alignment'
    ]
    let set__upload = {
        url: '../include/php/upload_test.php',
        params: 1,
        fileKey: 'upload_file',
        connectionCount: 1,
        leaveConfirm: 'Uploading is in progress, are you sure to leave this page?',
        pasteImage: true,
    }
    let set__defaultImage = '../../src/img/setting/image128.png'
   
        var editor = new Simditor({
            textarea: $(`#${textareaId}`),
            defaultImage: set__defaultImage,
            upload: set__upload,
            toolbarFloat: true,
            toolbar: set__toolbar
        });

}

let SETTING_ALL = [];
let SETTINGPAGE3 = [];
function getdatasettingByKey(key) {
    let data = false;
    // console.log(SETTING_ALL,key)
    SETTINGPAGE3.forEach(set => {

        if (key == set.roles_typeKey) {
            data = true;
        }
    })
    return data;
    // console.log(SETTINGPAGE3)

    // let all = sessionStorage.getItem('permission');
    // console.log(all)

    // if(sessionStorage.getItem('permission')){
    //     return true;
    // }else{
    //     return false;

    // }
}


function getDataMySettingPage(){
    
    connectApi("setting/set",{ type: "all", data:0, dataoption: 0 },"",function (output) {
        // console.log(output)
            if(output.status==200){
                SETTING_ALL= output.data 
            }
        }
    )
}

function viewModelPDFV2(path, filename, title) {

    let ViewPDF = byId('body-ViewPDF')
    ViewPDF.innerHTML = ''
    let type = filename.split('.')
    openModal('ViewPDF')
    byId('ViewPDF-Title').innerHTML = title
    saveLogsFile('all', '', `View File ${path}/${filename}`)
    if (type[1] == 'pdf') {
        let iframe = createTagE('iframe', ['iframe-pdf-viewer'])
            // iframe.setAttribute('id', 'iframe-pdf-viewer')
        iframe.setAttribute('frameborder', 0)
        iframe.setAttribute('width', '100%')
        iframe.src = `./${path}${filename}`
        ViewPDF.appendChild(iframe)
    } else {
        // let image = createTagE('img', ['w-100'])
        // image.src = `./${path}${filename}`
        let token = createToken(25);

        ViewPDF.innerHTML = ``;
        ViewPDF.innerHTML = `
        <span class="badge text-bg-primary cursor-pointer">
            <span id="buttonRotateImgPrevice" onclick="buttonRotateImgPrevice(this,'${token}',0)" ><i class="fas fa-sync-alt"></i> Rotate</span>
        </span>
        <div class="imgPreview_" id="imgPreview_${token}">
        <img src="./${path}${filename}" class="imgPre__TIW"  width="100%"></div>`


        // ViewPDF.appendChild(image)
    }


    // if(type=='')
    //console.log(type)



    // let iframe = byId('iframe-pdf-viewer')


    // let body = byId('body-ViewPDF')
    // body.classList.add('ui', 'loading', 'form')

}

function buttonRotateImgPrevice(e,token,anglePreview){
    let img = byId(`imgPreview_${token}`);
    anglePreview = (anglePreview + 90) % 360;
    img.className =`imgPreview_ rotate${anglePreview}`;
    e.setAttribute('onclick',`buttonRotateImgPrevice(this,'${token}',${anglePreview})`);
}