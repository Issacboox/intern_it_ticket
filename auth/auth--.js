const URLAPI = '../api/welfare/';
let FROMPAGE = ''
let byId = function(id) { return document.getElementById(id); };
let createE = function(id) { return document.createElement(id); };
let Find = function(tag) { return document.querySelector(tag); }
let btnUploadImgProfile = function(idInput) { byId(idInput).click() }
let openModal = function(id) { $('#modal-' + id).modal('show') }
let closeModal = function(id) { $('#modal-' + id).modal('hide') }
let createTagE = function(nametag, arrClass) {
    let tag = createE(nametag)
    for (let i = 0; i < arrClass.length; i++) { tag.classList.add(arrClass[i]) }
    return tag
}


function loginWithGoogle(id, fname, lname, email, img) {
    let data = {
        fname: fname,
        lname: lname,
        email: email,
        id: id,
        img: img,
    };
    // console.log(data)
    $.ajax({
        type: 'post',
        url: URLAPI + 'auth/loginwithgoogle',
        data: JSON.stringify(data),
        contentType: "application/json",
        dataType: "json",
        success: function(result) {
            // console.log(result);
            let obj = $.parseJSON(JSON.stringify(result));
            if (obj.status === 1) {

                saveLogsFile('auth', email, 'signin')
                sessionStorage.removeItem('from-page');
                window.location = "" + FROMPAGE

                // window.location = "./" + FROMPAGE
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'ไม่สามารถทำรายการได้',
                    html: obj.msg,
                    confirmButtonText: 'ตกลง',
                })
            }
        },
        beforeSend: function() {
            console.log('send...');
        },
        error: function(data, errorThrown) {
            console.log('request failed :' + errorThrown);
        }
    });

}

function saveLogsFile(type, filename, contant) {
    let dataArray = {
        type: type,
        filename: filename,
        data: contant
    }
    $.ajax({
        type: 'post',
        url: '../include/php/savelogsfile.php',
        data: dataArray,
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        dataType: "html",
        success: function(result) {},
        beforeSend: function() {

        }

    });

}

function signOut() {
    let auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function() {
        console.log('User signed out.');
        window.location = window.location.href;
    });
}


function bindGpLoginBtn(frompage) {
    FROMPAGE = frompage
    gapi.load('auth2', function() {
        auth2 = gapi.auth2.init({
            client_id: '758364311008-9c3kp8975g2m1n8qlf6fags9ih3d2rp8.apps.googleusercontent.com',
            scope: 'profile email'
        });
        attachSignin(document.getElementById('gp-login-btn'));
    });
}
//production -  758364311008-9c3kp8975g2m1n8qlf6fags9ih3d2rp8.apps.googleusercontent.com
// test - 758364311008-f1shc1g4vephpqct7slpa47i59snnc1l.apps.googleusercontent.com

function bindGpLoginBtnTech(frompage) {
    // FROMPAGE = frompage
    console.log(frompage)
    window.location = './tech/'
}

function checkDataEmpCode() {
    let arrIdInput = ['empCode']
    if (checkDataInputRequest(arrIdInput)) {
        let empCode = byId('empCode').value
            // console.log(empCode)
            // token
        let token
        let data
        let DataType
        if (!byId('btnSignIn').dataset.token) {
            DataType = 'empcode'
            token = 'new'
            data = {
                type: 'empcode',
                data: empCode,
                token: token
            }
        } else {
            token = byId('btnSignIn').dataset.token
            DataType = 'otp'
            data = {
                type: 'otp',
                data: byId('OTP').value,
                token: token
            }
        }

        // console.log(data)
        connectApi('auth/loginwithempcode', data, 'cardTech', function(output) {
            // console.log(output)
            if (output.status === 1) {
                if (DataType == 'empcode') {
                    let emp = output.data.emp
                    let showInputOtp = byId('showInputOtp')
                    showInputOtp.innerHTML = ''
                    let label = createTagE('label', ['txtTitleD'])
                    label.setAttribute('for', 'OTP')
                    label.innerHTML = `ระบุ OTP ที่ได้รับทาง Email<br><small>${emp.emp_email}</small>`
saveLogsFile('auth', emp.emp_email, 'signin')
                    let input = createTagE('input', ['form-control', 'inputempCode_signin'])
                    input.setAttribute('type', 'text')
                    input.setAttribute('id', 'OTP')
                    input.setAttribute('maxlength', '6')
                    let subtitle = createTagE('small', [])
                    subtitle.innerHTML = `ID : ${output.data.OTP}`
                    showInputOtp.appendChild(label)
                    showInputOtp.appendChild(input)
                    showInputOtp.appendChild(subtitle)
                    byId('empCode').setAttribute('disabled', 'true')
                    byId('empCode').classList.remove('is-valid')
                    byId('txt_subtitle_signin').style.display = 'none'
                    byId('btnSignIn').innerHTML = 'ลงชื่อเข้าใช้'
                    byId('btnSignIn').classList.remove('btn_checkData')
                    byId('btnSignIn').setAttribute('data-token', `${output.data.OTP}`)

                    // $('.inputempCode_signin').click(function() {

                    // })
                } else if (DataType == 'otp') {
                    saveLogsFile('auth', output.data.emp_email, 'signin')
                    sessionStorage.removeItem('from-page');
                    window.location = "" + FROMPAGE
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'ไม่สามารถทำรายการได้',
                    html: output.msg,
                    confirmButtonText: 'ตกลง',
                })
            }
        })

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

function attachSignin(element) {
    auth2.attachClickHandler(element, {},
        function(googleUser) {
            getCurrentGpUserInfo(googleUser);
        },
        function(error) {
            console.log(JSON.stringify(error, undefined, 2));
        }
    );
}

function getCurrentGpUserInfo(userInfo) {
    let result = '';
    let profile = userInfo.getBasicProfile();
    console.log(profile)
    result += "ID: " + profile.getId() + "\n";
    result += "Full Name:  " + profile.getName() + "\n";
    result += "Given Name: " + profile.getGivenName() + "\n";
    result += "Family Name: " + profile.getFamilyName() + "\n";
    result += "Email: " + profile.getEmail() + "\n";
    result += "ID Token: " + userInfo.getAuthResponse().id_token + "\n";
    if (result && checkEmailDomain(profile.getEmail())) {
        console.log(profile.getImageUrl())
        loginWithGoogle(profile.getId(), profile.getGivenName(), profile.getFamilyName(), profile.getEmail(), profile.getImageUrl());
    }
}

function checkEmailDomain(email) {
    console.log(email)
    let stringEmail = email.split("@");
    if (stringEmail[1] === 'bt-midland.com' || stringEmail[1] === 'tech.bt-midland.com') {
        return true
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'ไม่สามารถเข้าระบบได้',
            html: 'โปรดใช้ Email @bt-midland.com เท่านั้น',
            confirmButtonText: 'ตกลง',
        })
        return false
    }
}

function connectApi(dataUrl, dataArray, loading, handleData) {
    let username = 'AdminBT-Midland'
    let password = 'btmidland@2022'
    $.ajax({
        type: 'post',
        url: '../' + URLAPI + dataUrl,
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

            // showErrorConnect('ตรวจสอบการเชื่อมต่อ หรือลองรีเฟรชหน้านี้ใหม่อีกครั้ง', dataUrl, JSON.stringify(dataArray).toString(), errorThrown)
        }
    });
}