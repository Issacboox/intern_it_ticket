function getCardGuide() {
  // let show = document.getElementById('showguide');
  // show.innerHTML = "";

  // let dataAPI = {
  //   problem : byId('problem').value,
  // }

  // console.log(dataAPI)
  connectApi(
    "getdata/SugestCardguide",
    { type: "cardguide", data:0, dataoption: 0 },
    "",
    function (output) {
      console.log(output);
      if (output.status == 200) {
        let typeRequest = output.data;
        let htmltypeRequest = byId("showguide");

        htmltypeRequest.innerHTML = "";

        typeRequest.forEach((sop) => {
          htmltypeRequest.innerHTML += `
          <li>
          <i class="fab fa-guilded"></i>
          <span class="text">
              <h><strong>${sop.guide_title}</strong></h><br>
              <a href="#" class="btn btn-light" onclick="showResult(${sop.guide_id})">View detail</a>
          </span>   
      </li>
           `;
        });

        console.log(typeRequest);
      } else {
      }
    }
  );
}
function  getDataEmpDashboard() {
  let dataAPI = {
    start: FILTER_START,
    end: FILTER_END
  };
  if(getdatasettingByKey('ManageTicket')){
    connectApi(
      "getdata/TypeRequest",
      { type: "EmpDash", data: dataAPI, dataoption: 0 },
      "",

      function (output) {
        console.log(output);
        if (output.status == 200) {
          let emp = output.data;
          let empdash = byId("empdash");

          empdash.innerHTML = "";

          emp.forEach((ed) => {
            empdash.innerHTML += `
            
          <div class="row">
          <div class="col-md-12">
              <div class="row">
                  <div class="col-md-4">
                      <div class="dash">
                          <div class="row">
                              <div class="col-md-3">
                              <div class="profileV3">
                              <img src="${ed.emp_profile}" width="100%" >
                            </div>
                              </div>
                              <div class="col-md-9">
                                  <div class=" text-center">
                                      <div class="row">
                                          <div class="col-md-12">
                                          ${ed.emp_fname}  ${ed.emp_lname}
                                          </div>

                                          <div class="col-4">
                                              <div class="jobbox">
                                                  <div class="num text-align:center"></div>
                                                  ${addCommas(ed.Current)}
                                                  <div class="texts">
                                                      Current
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-4">
                                              <div class="jobbox1">

                                                  <div class="num text-align:center">
                                                  ${addCommas(ed.Started)}
                                                  </div>
                                                  <div class="texts">
                                                      Started
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-4">
                                              <div class="jobbox2">

                                                  <div class="num text-align:center">
                                                  ${addCommas(ed.Plan)}
                                                  </div>
                                                  <div class="texts">
                                                      Plan
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
            `;
          });
          // console.log(typeRequest);
        } else {
        }
      }
    );
  }
}
let chartWorkEmp;

function ChartBarDash() {
  let dataAPI = {
    start: FILTER_START,
    end: FILTER_END
  };

  connectApi(
    'getdata/responderManagement',
    { type: 'responder', data: dataAPI, dataoption: 0 },
    '',
    function (response) {
      if (response.status == 200) {
        let arrSeriesemp = [];
        let arrSeriesplan = [];
        let arrSeriescurrent = [];
        let arrSeriesSatrted = [];

        chartWorkEmp ? chartWorkEmp.destroy() : null;

        response.data.it_emp.forEach(emp => {
          arrSeriesemp.push(`${emp.emp_fname} ${emp.emp_lname}`);

          arrSeriesplan.push(emp.Plan);
          arrSeriescurrent.push(emp.Current);
          arrSeriesSatrted.push(emp.Started);
        });

        var options = {
          series: [
            {
              name: 'Plan',
              data: arrSeriesplan
            },
            {
              name: 'Current',
              data: arrSeriescurrent
            },
            {
              name: 'Started',
              data: arrSeriesSatrted
            }
          ],
          chart: {
            type: 'bar',
            height: 350,
            stacked: true,
            toolbar: {
              show: true
            },
            zoom: {
              enabled: true
            }
          },
          responsive: [
            {
              breakpoint: 480,
              options: {
                legend: {
                  position: 'bottom',
                  offsetX: -10,
                  offsetY: 0
                }
              }
            }
          ],
          plotOptions: {
            bar: {
              horizontal: false,
              borderRadius: 10,
              dataLabels: {
                total: {
                  enabled: true,
                  style: {
                    fontSize: '13px',
                    fontWeight: 900
                  }
                }
              }
            }
          },
          xaxis: {
            type: 'text',
            categories: arrSeriesemp
          },
          legend: {
            position: 'right',
            offsetY: 40
          },
          fill: {
            opacity: 1
          }
        };

        // chartWorkEmp = new ApexCharts(document.getElementById('chartWorkEmp'), options);
        chartWorkEmp = new ApexCharts(Find("#chartWorkEmp"), options);

        chartWorkEmp.render();
      }
    }
  );
}


let chartWorkType_top5;
function DonutDashboard() {
  let dataAPI = {
    start:FILTER_START,
    end:FILTER_END
  }
  connectApi(
    'getdata/responderManagement',
    { type: 'donutChart', data: dataAPI, dataoption: 0 },
    '',
    function (response) {
      if(response.status==200){

        let arrSeries=[];
        let arrLabel=[];

        chartWorkType_top5?chartWorkType_top5.destroy():null;

        response.data.forEach(type=>{
          arrSeries.push(parseInt(type.request_count));
          arrLabel.push(`${type.type_name} (${parseInt(type.request_count)})`);

        })
        console.log(arrSeries)


        var options = {
          series: arrSeries,
          chart: {
          type: 'donut',
          height: 350,
        },
      
        labels: arrLabel,
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              // width: 200
              
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };
        chartWorkType_top5 = new ApexCharts(Find("#chartWorkType_top5"), options);
        chartWorkType_top5.render();

      }
    }
  );
}


function showResult(id) {
  connectApi(
    "getdata/sugestcardSetting",
    { type: "view", data: id, dataoption: 0 },
    "",
    function (output) {
      console.log(output);
      let g_title = "";
      let g_desc = "";
      let g_solute = "";

      if (output.status == 200) {
        output.data.data.forEach((showresult) => {
          g_title = showresult.guide_title;
          g_desc = showresult.guide_description;
          g_solute = showresult.guide_solutions;
        });
      }
      Swal.fire({
        html: `
        <div class="showguide">
            <div class="" style="text-align:left">
                 <h4>${g_title}</h4>
            </div>
            <div class="descguide" style="text-align:left">
                 <p>${g_desc}</p> 
            </div>
            <div>
                 <p>${g_solute}</p>
            </div>
        </div>
      `,
        backdrop: 'rgba(0, 0, 0, 0.5)',
        showCloseButton: true,
        showConfirmButton: false,
        width: 1000,
        padding: '1em',
      });
    }
  );

  if (id != 0) {
    // Additional code logic for when id is not equal to 0
  } else {
    // Additional code logic for when id is equal to 0
  }
}


function rejectTicket(id) {
  //   Swal.fire({
         
  //     // input: 'text', 
  //     html: `
  //     <div class="container">
  //       <h3 class="mb-3">Reject <img src="https://img.freepik.com/free-icon/error_318-437352.jpg?w=2000" width="4%"></h3>
  //    <div class="form-floating mb-3">
  //   <textarea class="form-control" id="rejectdesc" name="rejectdesc" style="height: 150px" placeholder="Description"></textarea>
  //   <label for="rejectdesc">Type here to remark</label>
  // </div>
  // <button type="submit" class="btn btn-danger mt-1 float-end" onclick="rejectTicketissue(${id})">Reject</button>
  
  // </div>
  //   `,
  //     width: 600,
  //     padding:'',
  //     showConfirmButton: false,
  //     showCloseButton:true,
  //   });
  Swal.fire({
    icon: 'warning',
    // html:``;
    confirmButtonText: 'Reject',
    showCancelButton: true,
    cancelButtonText: 'Cancel',
    input: 'textarea',
    inputPlaceholder: 'remark',
    inputAttributes: { 'aria-label': 'remark'},
    inputValidator: (value) => {
        if (value && value.length<=240) {
            // console.log(value,value.length)
            // activeStatusWorkOther_(toType, workId, type, token, 'finish', value)
            rejectTicketissue(id,value)
        } else {
            if(value.length>240){
                return 'Supports 250 characters.'
            }else{
                return 'Please provide complete information.!'
            }
        }
    }
  }).then((result) => {
      if (!result.isConfirmed) {}
  })


  }

  function rejectTicketissue(id,remark){
    let dataAPI = {
      rejectdesc : remark,
      id: id,
    };
    console.log(dataAPI)
    Swal.fire({
      icon : 'warning',
      title: "Confirm?",
      showCancelButton: true,
      confirmButtonText: "Confirm",
      cancelButtonText: "Cancel",
      
    }).then((result) => {
      if (result.isConfirmed) {
        connectApi("getdata/CurrentJobRequest", { type: "reject", data: dataAPI, dataoption: 0 }, "loadingDiv", function (output) {
          console.log(output);
          if (output.status == 200) {
            Swal.fire({
             icon:'success',
             title: "This ticket has been reject",
             confirmButtonText: "Close!",
            }).then((result) => {
              location.reload();
          });
          
          }  
        });
      }
    });
  }
  
  


function filterTicket(){
  $('#ticketfilter').on('change', function () {
    // set reference to select elements
    var ticketfilter = $('#ticketfilter');
    
    $('.result').addClass('active');
    if (ticketfilter.prop('selectedIndex') > 0) {
      // get all result divs, and filter for matching data attributes
      $('.result').filter('[data-ticket!="' + ticketfilter.val() + '"]').removeClass('active');
    }
  });
}


 function selectEmpTicket(){
  connectApi(
    "getdata/allEmpforTicket",
    { type: "empSelect", data: 0, dataoption: 0 },
    "",
    function (output) {
      console.log(output);
      if (output.status == 200) {
        let typeRequest = output.data;
        let htmltypeRequest = byId("selectAnotherEmp");

        htmltypeRequest.innerHTML = "";

        typeRequest.forEach((owner) => {
          htmltypeRequest.innerHTML += `
             <option value="${owner.emp_id}">
             ${owner.emp_fname} ${owner.emp_lname}</option>
           `;
        });
        $('.filterEmp').select2();
        console.log(typeRequest);
      } else {
      }
    }
  );
 }


let array_style_urgent=[`display: none;`,`color:red`];
let array_style_bg =[`background-color: white;`,`background-color: #fff0f0;`];
let FILTER_START = moment().startOf('month').format('YYYY-MM-DD H:mm:s');
let FILTER_END = moment().endOf('month').format('YYYY-MM-DD H:mm:s');


function getDataHistoryRequest() {
  let show = byId(`show-divHistory`);
  show.innerHTML = "";
  let dataAPI = {
    search : byId('searchInput').value,
    filterstatus : byId('ticketfilterType').value,
    filterEmp : byId('ticketfilterEmp').value,
    start : FILTER_START,
    end :FILTER_END

  }
  console.log(dataAPI) 

  connectApi("getdata/HistoryRequest",{ type: "foruser", data: dataAPI, dataoption: 0 },"show-divHistory",
    function (output) {
      console.log(output);
      if (output.status == 200) {
        let typeRequest = output.data;
        filterTicket();
        
        typeRequest.forEach((type) => {
          let statusText = "";
          let statusClass = "";
          let file = type.file;
          let staff1 = type.staff;
          let staffit = type.staffit;

          let txtFile = "";
          file.forEach((file) => {
            let showFile = file.file_name.split(".");
            let array_file_type = [`pdf`, `docx`, `jpg`, `png`, `xlsx`];
            txtFile += `
            <button class="button_file" onclick="viewModelPDFV2('include/uploads/${file.file_path}','${file.file_name}','#${type.Ticket_No}')">
            <img src="${BASEPATH}include/icon_file/file_${array_file_type.includes(showFile[1]) ? showFile[1] : `other`}.png" width="25px"></button>&nbsp;`;
          });
          
          let optionRespon ="";
          let request_responder = type.request_responder;
          staffit.forEach((optionRes) => {
            let selectSatff =""
            if(optionRes.emp_id==request_responder){
              selectSatff='selected';
            }
            optionRespon += `<option ${selectSatff} value="${optionRes.emp_id}">${optionRes.emp_fname} ${optionRes.emp_lname}</option>`;
          });
          show.insertAdjacentHTML(
            "beforeend",
            `
            <div class="box work mb-3" id="reloadpage">
            <div class="result tagStatus" data-ticket="${array_status_form_request[type.request_status]}" data-pincode="glenchill">
            <p class="${array_status_class[type.request_status]} float-end mt-1">${array_status_form_request[type.request_status]}</p>
          </div>
             <div>
              <div class="floatRight"> 
                <div class="" onclick="checkTimeline(${type.request_id}); return false;" style="border-radius: 1rem;
                background-color: #ebebeb;
                padding: 0.25rem 16px;
                margin-right: .5rem;
                display: flow-root;
                align-content: center;
                cursor: pointer;
                align-self: flex-end;"><i class="fas fa-stream"></i> Timeline Status</div>
                ${getdatasettingByKey('ManageTicket') ? `
                <div class="dropdown">
                  <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-caret-down"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li><button class="dropdown-item" type="button" onclick="rejectTicket(${type.request_id})"><i class="far fa-times-circle"></i> Reject</button></li>
                    <li><button class="dropdown-item" type="button" onclick="EditTicket(${type.request_id},'${type.type_id}')"><i class="fas fa-pencil-alt"></i> Change Type</button></li>
                  </ul>
                </div>` : ``}
              </div>
              <div class="head">
                <div class="header">
                  <div class="title">
                    <div class="workType">
                      <div class="icontype" style="background-color:${type.type_color}">
                        <i class="${type.type_icon}"></i> ${type.type_name}
                      </div>
                    </div>
                    <div class="workTitle d-flex gap-2">
                      <div class="mt-2"><a href="" onclick="checkTimeline(${type.request_id}); return false;" class="TimelineCheck">${type.request_title}</a></div>
                    </div>
                  </div>
                  <div class="mt-2 description">
                    <p><small>${type.request_description}</small></p>
                  </div>
                  <div class="detail">
                    <div class="workNo borderRight">#${type.Ticket_No}</div>
                    <div class="workNo borderRight"><i class="fas fa-user"></i>&nbsp; ${type.emp_fname} ${type.emp_lname}</div>
                    <div class="workNo borderRight"><i class="fas fa-history"></i> ${moment(type.req_datetime).format("HH:m | DD MMM YYYY ")} </div>
                    <div class="workNo" style="${array_style_urgent[type.request_urgent]};">
                      <i class="fas fa-thumbtack"></i>
                      Due date: ${moment(type.request_duedate).format("HH:m | DD MMM YYYY ")}
                      <img src="https://em-content.zobj.net/source/animated-noto-color-emoji/356/police-car-light_1f6a8.gif" width="3%">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr class="m-0">
            <div class="footer d-flex mobile">
                 <div class="footer d-flex flex-wrap ">
                      <div class="option d-flex borderRight selectemp_respond">
                            <div class="icon"><i class="bi bi-person-rolodex"></i></div>
                            <select class="form-select form-select-sm" id="emp_respond_${type.request_id}" name="emp_respond" ${getdatasettingByKey('ManageTicket') ? '' : 'disabled'} ${type.request_status != 2 ? 'disabled' : ''}>
                            ${optionRespon}
                          </select>
                                  <button class="saveChangeBtn" id="saveButton_${type.request_id}" style="display: none;" onclick="saveResponderedit('${type.request_id}')">Save Change</button>
                                      </div>
                                      <div class="tagAlertInprocess">
                          ${type.request_status == 4 ? '<p style="color:red" class="ms-3">This ticket is currently being handled!</p>' : ''}
                          </div>
                                      <div class="floatRight buttonmodified">
                                      <div class="file-box">
                                    ${txtFile !== " " ? txtFile : ``}
                              </div>
                              ${getdatasettingByKey('ManageMyJob') ? `
                               <div class="mobileSize">
                            <a href="#" class="forMobile"><button class="commentBtn d-none" onclick="CommentTicket(${type.request_id},'${type.request_status}')">Comment</button></a>
                            ${request_responder!=type.myuserId?`<a href="#"  class="forMobile"><button class="Choosebtn" ${type.request_status != 2 ? 'style="display:none;"' : ''} onclick="chooseJob(${type.request_id})"><i class="fas fa-hand-pointer"></i> Choose Job</button></a>`:``}` : ``}
                             
                            
                </div>
                </div>
          </div>
          
          
         
          
    `
          );
        });
        separateCards(show);
        filterTicket()
        attachSaveChangeBtnListeners(output);
       
      } else {
        // console.log(output);
        show.innerHTML = `<div class="text-center">Empty!</div>`;
      }
    }
    
  );
}

function separateCards(container) {
  const cards = Array.from(container.getElementsByClassName("box work mb-3"));
  const cardsPerPage = 10; // Change this value according to the desired number of cards per page
  let currentPage = 1;
  let startIndex = 0;
  let endIndex = cardsPerPage;

  const showPage = (start, end) => {
    cards.forEach((card, index) => {
      if (index >= start && index < end) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  };

  const updatePaginationButtons = () => {
    // Update pagination buttons based on current page
    // You can implement this logic based on your UI and requirements
  };

  const goToPage = (page) => {
    currentPage = page;
    startIndex = (currentPage - 1) * cardsPerPage;
    endIndex = startIndex + cardsPerPage;

    showPage(startIndex, endIndex);
    updatePaginationButtons();
  };

  // Initial setup
  showPage(startIndex, endIndex);
  updatePaginationButtons();
}
function chooseJob(id) {
  let dataAPI = {
    id: id,
  };
  console.log(dataAPI);
  Swal.fire({
    icon: 'warning',
    title: "Do you want to choose this ticket?",
    padding: '1em',
    showCancelButton: true,
    confirmButtonText: "Confirm",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      connectApi(
        'getdata/CurrentJobRequest',
        { type: 'job', data: dataAPI, dataoption: 0 },
        'loadingDiv',
        function (output) {
          console.log(output);
          if (output.status == 200) {
            Swal.fire({
              icon: 'success',
              title: "Complete",
              padding: '1em',
              confirmButtonText: "Ok",
            }).then(() => {
              location.reload();
            });
          } else {
            console.log(output.message);
          }
        }
      );
    }
  });
}


function saveResponderedit(id) {
  let dataAPI = {
    emp_respond: byId(`emp_respond_${id}`).value,
    id: id,
  };
 console.log(dataAPI)
  Swal.fire({
    icon:'warning',
    title: "Confirm?",
    padding:'1em',
    showCancelButton: true,
    confirmButtonText: "Confirm",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      connectApi(
        'getdata/HistoryRequest',
        { type: 'reponderEdit', data: dataAPI, dataoption: 0 },
        '',
        function (output) {
          console.log(output);
          if (output.status == 200) {
            // getDataHistoryRequest();
            byId(`saveButton_${id}`).style.display ='none';
          } else {
            console.log(output.message);
          }
        }
      );
    }
  });
}


function attachSaveChangeBtnListeners(output) {
  let typeRequest = output.data;
  typeRequest.forEach((type) => {
    let selectElement = document.getElementById(`emp_respond_${type.request_id}`);
    let saveButton = document.getElementById(`saveButton_${type.request_id}`);

    selectElement.addEventListener('change', function() {
      saveButton.style.display = 'block';
    });
  });
}

function EditTicket(id,oldtype) {
  connectApi(
    "getdata/HistoryRequest",
    { type: "view", data: id, dataoption: 0 },
    "",
    
    function (output) {
      console.log(output);
      
      let rq_editTitle = "";
      let rq_editDuedate = "";
      let type_tk ="";

      output.data.forEach((type) => {
        let ticketTypes = type.allticket;


        let optionTypeData = "";
        ticketTypes.forEach((optionType) => {
          let selectTypeticket = "";
          // output.data.forEach((type) => {
          //   if (optionType.request_type == type.type_id) {
          //     selectTypeticket = "selected"
          //   }
          // });
          optionTypeData += `<option ${oldtype==optionType.type_id?`selected disabled`:``} value="${optionType.type_id}">${optionType.type_name}</option>`;
        });

        if (output.status == 200) {
          output.data.forEach((editor) => {
            rq_editTitle = editor.request_title;
            rq_editDuedate = editor.request_duedate;
            type_tk = editor.request_id;
          });
        }

        Swal.fire({
          html: `
            <div class="container">
              <h3 class="mb-3">Change Ticket Type <img src="https://cdn-icons-png.flaticon.com/512/1350/1350731.png" width="6%"></h3>
              <form>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="titleInput" placeholder="Title" value="${rq_editTitle}" Disabled>
                  <label for="titleInput">Title</label>
                </div>
               
                <div class="form-floating">
                  <select class="form-select" id="TypeSelectEdit" name="TypeSelectEdit" style="height: 70px;">
                    ${optionTypeData}
                  </select>
                  <label for="statusSelect">Status</label>
                </div>
                <button type="submit" class="btn btn-primary mt-3 float-end" onclick="updateTypeticket('${type_tk}')">Update</button>
              </form>
            </div>
          `,
          showConfirmButton: false,
          showCloseButton:true,
        });
      });
    }
  );

  if (id != 0) {
    // Handle the case where id is not equal to 0
  } else {
    // Handle the case where id is equal to 0
  }
}

function updateTypeticket(id){
  if (checkDataInputRequest(['TypeSelectEdit'])) {
    let dataAPI = {
      TypeSelectEdit : byId('TypeSelectEdit').value,
      id: id,
    };
    Swal.fire({
      icon: 'warning',
      title: 'Save Change?',
      showCancelButton: true,
      confirmButtonText: 'Confirm',
      cancelButtonText: 'Cancel',
    }).then((result) => {
      if (result.isConfirmed) {
        connectApi(
          'getdata/HistoryRequest',
          { type: 'edit', data: dataAPI, dataoption: 0 },
          'loadingDiv',
          function (output) {
            console.log(output);
            if (output.status == 200) {
              getDataHistoryRequest();
            } 
          }
        );
      }
    });
  }
}

function CommentTicket(id,status) {
  connectApi(
    "getdata/HistoryRequest",
    { type: "view", data: id, dataoption: 0 },
    "loadingDiv",
    function (output) {
      console.log(output);

      // Swal.fire({
      //   html: `
      //   <div class="container">
      //   <h3 class="mb-3">Comment <img src="https://cdn-icons-png.flaticon.com/512/2665/2665038.png" width="5%" class="img-responsive"></h3>
      //   <div class="form-floating mb-3">
      //     <textarea class="form-control" id="descInput" name="descInput" style="height: 200px" placeholder="Description"></textarea>
      //     <label for="descInput">Type here</label>
      //   </div>
      //   <button type="submit" class="btn btn-primary mt-1 float-end" onclick="addTicketTimeline(${id})">Comment</button>
      // </div>
      
      //   `,
      //   width: 700,
      //   padding: '0.5em',
      //   showConfirmButton: false,
      // });

      Swal.fire({
        title: 'Comment?',
        // html:``;
        confirmButtonText: 'Confirm',
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        input: 'textarea',
        inputPlaceholder: 'remark',
        inputAttributes: { 'aria-label': 'remark'},
        inputValidator: (value) => {
            if (value && value.length<=240) {
                // console.log(value,value.length)
                // activeStatusWorkOther_(toType, workId, type, token, 'finish', value)
                addTicketTimeline0(id,value,status)
            } else {
                if(value.length>240){
                    return 'Supports 250 characters.'
                }else{
                    return 'Please provide complete information.!'
                }
            }
        }
    })


    }
  );

  if (id !== 0) {
    // Handle the case where id is not equal to 0
  } else {
    // Handle the case where id is equal to 0
  }
}

function addTicketTimeline0(id,remark,status){
  let dataAPI = {
    descInput : remark,
    id: id,
  };
  Swal.fire({
    icon: 'warning',
    title: 'Confirm?',
    showCancelButton: true,
    confirmButtonText: 'Ok',
    cancelButtonText: 'Cancel',
  }).then((result) => {
    if (result.isConfirmed) {
      connectApi(
        'getdata/CurrentJobRequest',
        { type: 'comment', data: dataAPI, dataoption: 0 },
        'loadingDiv',
        function (output) {
          console.log(output);
          if (output.status == 200) {
            Swal.fire({
              icon: 'success',
              title: 'Comment Success',
              showCancelButton: false,
              confirmButtonText: 'Close!',
            }); 
          } 
        }
      );
    }
  });
} 



function  getDataEmpSelect() {
  connectApi(
    "getdata/responderManagement",
    { type: "responder", data: 0, dataoption: 0 },
    "",

    function (output) {
      console.log(output);
      if (output.status == 200) {
        let typeRequest = output.data.it_emp;
        let htmltypeRequest = byId("emp_respond");

        htmltypeRequest.innerHTML = "";

        typeRequest.forEach((res_emp) => {
          htmltypeRequest.innerHTML += `
             <option value="${res_emp.emp_id}">${res_emp.emp_fname} ${res_emp.emp_lname}</option>
           `;
        });
        console.log(typeRequest);
      } else {
      }
    }
  );
}

function getdataDashboardTicket() {
  let dataAPI = {
    start:FILTER_START,
    end:FILTER_END
  }
  connectApi(
    "getdata/responderManagement",
    { type: "dashboard", data: dataAPI, dataoption: 0 },
    "homeDashboard",
    function (output) {
      console.log(output);
      if (output.status == 200) {
        let homeDash = output.data[0];
        let Dash = byId("homeDashboard");
        Dash.innerHTML = "";

        // homeDash.forEach((dash) => {
          Dash.innerHTML = `
          <li>
            <i class="fas fa-user-clock"></i>
            <span class="text">
              <h3>${addCommas(homeDash.Assigned)}</h3>
              <p>Assigned</p>
            </span>
          </li>
          <li>
            <i class="fas fa-user-check"></i>
            <span class="text">
              <h3>${addCommas(homeDash.Inprocess)}</h3>
              <p>Inprocess</p>
            </span>
          </li>
          <li>
            <i class="fas fa-clipboard-check"></i>
            <span class="text">
              <h3>${addCommas(homeDash.Complete)}</h3>
              <p>Completed</p>
            </span>
          </li>
          <li>
            <i class="fas fa-window-close"></i>
            <span class="text">
              <h3>${addCommas(homeDash.Reject)}</h3>
              <p>Reject</p>
            </span>
          </li>`;
        // });
      } else {
        // Handle other status codes or errors if needed
      }
    }
  );
}



function getDataEmpPermission() {
  connectApi(
    "getdata/SugestCardguide",
    { type: "AllEmp", data: 0, dataoption: 0 },
    "permissionAll",
    function (output) {
      console.log(output);
      if (output.status == 200) {
        let typeRequest = output.data;
        let htmltypeRequest = byId("tbody-permissionEmp");
        htmltypeRequest.innerHTML = "";

        typeRequest.forEach((permission) => {
          htmltypeRequest.innerHTML += `
            <tr>
              <td>${permission.emp_code}</td>
              <td>${permission.emp_fname} ${permission.emp_lname}</td>
              <td>${permission.orgunit_name}</td>
              <td>${permission.emp_positionName}</td>
              <td>${permission.emp_email}</td>
              <td><button class="btn btn-warning btn-sm" onclick="permissionSetting(${permission.emp_id})"> <i class="bi bi-pen-fill"></i> </button></td>
            </tr>
          `;
        });
        setTable_DataTableNoFilterNoExport('permissionAll')
      } else {
        // Handle other status codes or errors if needed
      }
    }
  );
}


function permissionSetting(id){

  connectApi(
    "getdata/SugestCardguide",
    { type: "check", data: id, dataoption: 0 },
    "",
    function (output) {
      console.log(output);
      let per_img = "";
      let per_name = "";
      let per_lname = "";
      let per_depart = "";
      let per_section = "";
      let email = "";
      let code ="";
      id = id ;
      console.log(id)

      let per_emp = "";
      let htmlRoles = '';
     


       
      if (output.status == 200) {
        output.data.forEach((setper) => {
           per_img = setper.emp_profile;
           per_name = setper.emp_fname;
           per_lname = setper.emp_lname;
           per_depart = setper.orgunit_name ;
           per_section = setper.emp_positionName;
           email = setper.emp_email;
           code = setper.emp_code;
        });  
        
        output.data.forEach((optionPer) => {
          optionPer.allEmp.forEach((emp) => {
            per_emp += `<option value="${emp.emp_id}">${emp.emp_fname} ${emp.emp_lname}</option>`;
          });


          optionPer.RolesType.forEach(roles => {
            let checked_ = roles.checked;
            htmlRoles+=` <div class="form-check">
              <input class="form-check-input settingRoles " type="checkbox" value="" data-id="${roles.roles_typeId}" ${checked_.length>0?`checked`:``} id="Roles_${roles.roles_typeId}">
              <label class="form-check-label" for="Roles_${roles.roles_typeId}">
              ${roles.roles_typeName}
              </label>
          </div>`;
          });




        });



      }
      Swal.fire({
        title: "Permission Management",
        html: `
          <div class="permissionManage">
            <div class="row gap-2">
              <div class="col-md-3 col-sm-12">
                <img class="permissionImg" src="${per_img}" width="150px" style="padding: 15px;background-color: #ffffff;border-radius: 10px;border-style: solid;border-color: #cbcbcb;">
              </div>
      
              <div class="col-md-5 col-sm-12" style="width:73%">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInputDisabled" value="${code}" disabled>
                  <label for="floatingInputDisabled">Emp code:</label>
                </div>
      
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInputDisabled" value="${per_name} ${per_lname}" disabled>
                  <label for="floatingInputDisabled">Emp name:</label>
                </div>
      
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInputDisabled" value="${per_depart}" disabled>
                  <label for="floatingInputDisabled">Department:</label>
                </div>
      
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInputDisabled" value="${per_section}" disabled>
                  <label for="floatingInputDisabled">Section:</label>
                </div>
      
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInputDisabled" value="${email}" disabled>
                  <label for="floatingInputDisabled">Email:</label>
                </div>
              </div>
      
              <div class="col-md-5 col-sm-12 settingPerformobile" style="text-align:left;">
                <h>Setting <strong>Permission</strong></h>
                ${htmlRoles}
      
                <br>
      
                <h>Duplicate Permission</h>
                <select onchange="copyRolesV2(this)" class="form-select mt-2 empnamePe" name="empnamePer" id="empnamePer">
                  <option selected>Select to copy the Permission</option>
                  ${per_emp}
                </select>
              </div>
            </div>
      
            <div class="row">
              <div class="col-md-12">
                <button class="btn btn-danger float-end mt-3 mb-3" onclick="saveDataPermission('${id}')">Save</button>
              </div>
            </div>
          </div>`,
        width: '700',
        padding: '2em',
        showCloseButton: true,
        showConfirmButton: false,
      });
      

    }
  );
  
  if (id != 0) {
  } else {
  }
}

function saveDataPermission(id){
  let permissionAll = FindAll('.settingRoles:checked')
  let Arr =[];
  permissionAll.forEach(roles=>{
    Arr.push(roles.dataset.id)
  })
  let dataAPI = {
    empId : id,
    roles:Arr
  }
  console.log(dataAPI)

  connectApi(
    "getdata/SugestCardguide",
    { type: "updatePermission", data: dataAPI, dataoption: 0 },
    "",
    function (output) {
      console.log(output)
      if(output.status==200){
        Swal.fire({
          icon:'success',
          title: "Success!",
          showCancelButton: false,
          confirmButtonText: "OK",
        }).then((result) => { });
      }
    }
  );
}

function copyRolesV2(e){
  let dataAPI = {
    empId : e.value
  }
  let permissionAll = FindAll('.settingRoles:checked');
  // console.log(permissionAll)
  permissionAll.forEach(roles=>{ byId(`Roles_${roles.dataset.id}`).checked=false; })
  console.log(dataAPI)
  connectApi(
    "getdata/SugestCardguide",
    { type: "DuplicatePermission", data: dataAPI, dataoption: 0 },
    "",
    function (output) {
      console.log(output)
      if(output.status==200){
       
        output.data.forEach(role=>{
          byId(`Roles_${role.roles_typeId}`).checked = true;
        })
        // Swal.fire({
        //   icon:'success',
        //   title: "Success!",
        //   showCancelButton: false,
        //   confirmButtonText: "OK",
        // }).then((result) => { });
      }
    }
  );
}

// let RESPONDER_ARR =[]
// function getdataSettingResponder() {
//   connectApi(
//     "getdata/responderSetting",{ type: "responder", data: 0, dataoption: 0 },"",
//     function (output) {
//       console.log(output)
//       if (output.status == 200) {
//         let typeRequest = output.data.request_type;
//         let htmltypeRequest = byId("tbody-responder");
//        htmltypeRequest.innerHTML = "";
        
//         RESPONDER_ARR=[];
//         typeRequest.forEach((res) => {
//          let selectedEmp=res.emp;
//            let emp_res = '';
//            output.data.it_emp.forEach((emp) => { 
//             let select_emp=false;
//             selectedEmp.forEach(resEmp=>{
//                 if(resEmp.emp_id==emp.emp_id){
//                   select_emp=true;
//                 }
//               })
//                 emp_res += `<option ${select_emp==true?`selected`:``} value="${emp.emp_id}">${emp.emp_fname} ${emp.emp_lname}</option>`; 
//               })
//           htmltypeRequest.innerHTML += `
//           <tr>
//           <td><div class="d-flex gap-2 mt-1">
//                 <div class="cardicon" style="background-color:${res.type_color}">
//                   <i class="${res.type_icon}" ></i>
//                 </div>
//               <p class="mt-1">${res.type_name}</p>
//             </div>
//           </td>
//           <td>
//               <div class="d-flex gap-2">
//               <select class="js-example-basic-multiple manageResponder_${res.type_id}" name="states[]" placeholder="Select Responder here.." multiple="multiple" style="width:100%">

//               </select> 
//               </div>
//           </td>
//       </tr>
//            `;

//            RESPONDER_ARR.push(res)
//         });
        
//         select2()
//         console.log(typeRequest);
//         console.log(RESPONDER_ARR)
//             } else {
//       }
//     }
//   );
// }

let RESPONDER_ARR = [];

function getdataSettingResponder() {
  connectApi(
    "getdata/responderSetting",
    { type: "responder", data: 0, dataoption: 0 },
    "",
    function (output) {
      console.log(output);
      if (output.status === 200) {
        let typeRequest = output.data.request_type;
        let htmltypeRequest = byId("tbody-responder");
        htmltypeRequest.innerHTML = "";

        RESPONDER_ARR = [];
        typeRequest.forEach((res) => {
          let selectedEmp = res.emp;
          let emp_res = '';
          output.data.it_emp.forEach((emp) => {
            let select_emp = selectedEmp.some((resEmp) => resEmp.emp_id === emp.emp_id);
            emp_res += `<option ${select_emp ? 'selected' : ''} value="${emp.emp_id}">${emp.emp_fname} ${emp.emp_lname}</option>`;
          });

          htmltypeRequest.innerHTML += `
          <tr>
            <td>
              <div class="d-flex gap-2 mt-1">
                
                <p class="mt-1">${res.type_name}</p>
              </div>
            </td>
            <td>
              <div class="d-flex gap-2">
                <select class="js-example-basic-multiple manageResponder_${res.type_id}" name="states[]" placeholder="Select Responder here.." multiple="multiple" style="width:100%">
                  ${emp_res}
                </select> 
              </div>
            </td>
          </tr>
        `;

          RESPONDER_ARR.push(res);
        });

        // Call any necessary functions here
        select2();

        console.log(typeRequest);
        console.log(RESPONDER_ARR);
      } else {
        // Handle error case here
      }
    }
  );
}

function select2(){
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
}

function saveResponderSetting(){
  let responder_array =[]

   RESPONDER_ARR.forEach((res)=> {
    let manageResponder = $(`.manageResponder_${res.type_id}`).val();
   
    if(!!manageResponder){
responder_array.push({
      type_id : res.type_id ,
      emp : manageResponder
    })
    }
    
    // console.log($(`.manageResponder_${res.type_id}`).val())
   })
 
   console.log(responder_array)

      // console.log(dataAPI);
      Swal.fire({
        icon:'warning',
        title: "Confirm Save?",
        showCancelButton: true,
        confirmButtonText: "Save change",
        cancelButtonText: "Cancel",
      }).then((result) => {
        if (result.isConfirmed) {
          connectApi("getdata/HistoryRequest",
          { type: "manageresponder", data: responder_array, dataoption: 0 },"",
            function (output) {
              console.log(output);
              if (output.status == 200) {
                location.reload();
              }
            }
          );
        }
      });
    }
    
   







function getdataTypeRequestSwitch() {
  connectApi(
    "getdata/typeRequestSetting",
    { type: "forsetting", data: 0, dataoption: 0 },
    "",
    function (output) {
      // console.log(output)
      if (output.status == 200) {
        let typeRequest = output.data;
        let htmltypeRequest = byId("show-type");

        htmltypeRequest.innerHTML = "";

        typeRequest.forEach((tq) => {
          htmltypeRequest.innerHTML += `
          
          <div class="row">
          <div class="col-md-7 col-lg-7">
            <div class="d-flex gap-4 mt-3">
              <div class="iconsetting" style="background-color:${tq.type_color}"><i class="${tq.type_icon}"></i></div>
              <h6 style="margin:10px">${tq.type_name}</h6>
            </div>
          </div>
          <div class="col-md-5 col-lg-5 mt-3">
            <div class="d-flex justify-content-end gap-2">
              <div class="form-check form-switch gap-2">
                  <input class="form-check-input mt-2 switchVisible" type="checkbox" onchange="switchVisibleTq(this, ${tq.type_visible}, ${tq.type_id})" 
                  role="switch" style="background-color: #69fd0d;border-color: #69fd0d;" id="rq_visible" ${tq.type_visible == 1 ? `checked` : ''} >
              </div>
              <div class="form-check form-switch d-flex gap-2">
                <label class="switch">
                  <input class="form-check-input mt-2" style="background-color: #d385dd;border-color: #d385dd;" type="checkbox" onchange="switchStatusTypeRequest(this, ${tq.type_status}, ${tq.type_id})" role="switch" id="flexSwitchCheckChecked" ${tq.type_status == 1 ? `checked` : ''}>
                  <span class="slider"></span>
                </label>
              </div>
              <button class="btn btn-warning btn-sm" onclick="add_type_request(${tq.type_id})"><i class="bi bi-pencil"></i></button>
              <button class="btn btn-danger btn-sm" onclick="delTqSetting(${tq.type_id})"><i class="bi bi-trash3"></i></button>
            </div>
          </div>
        </div>
           `;
        });

        console.log(typeRequest);
      } else {
      }
    }
  );
}


function switchVisibleTq(e, oldId, id) {
  ChangeStatusTo("it_request_type","type_visible",oldId == 1 ? 0 : 1,"type_id",id);
  e.setAttribute("onchange",`switchVisibleTq(this,${oldId == 1 ? 0 : 1}),${id}`
  
  );
  
}


function switchStatusTypeRequest(e, oldId, id) {
  ChangeStatusTo("it_request_type","type_status",oldId == 1 ? 0 : 1,"type_id",id);
  e.setAttribute("onchange",`switchStatusTypeRequest(this,${oldId == 1 ? 0 : 1}),${id}`
  );
}


function countTimeforKPI(){
  const inputElement = document.getElementById("rq_kpi_minites");
  const resultElement = document.getElementById("result");
  
  inputElement.addEventListener("input", 
  function() {
    const minutes = parseInt(this.value);
    const hours = Math.floor(minutes / 60);
    const minutesLeft = minutes % 60;
   
    resultElement.textContent = `${hours} hours and ${minutesLeft} minutes`;
  });
  
}

function delTqSetting(id) {
  Swal.fire({
    title: "ยืนยัน?",
    html:`<img src="https://azcourthelp.org/images/PovertyGuidelines/elderly-caution.png" width="50%">`,
    padding:'1em',
    showCancelButton: true,
    confirmButtonText: "Confirm",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      ChangeStatusTo("it_request_type", "type_status", 9, "type_id", id);
    }
  });
}

function add_type_request(id) {
  connectApi(
    "getdata/typeRequestSetting",
    { type: "view", data: id, dataoption: 0 },
    "",
    function (output) {
      console.log(output);
      let rq_type = "";
      let rqt_desc ="";
      let rq_icon = "";
      let rq_short = "";
      let rq_kpi_minites="";
      let rq_color = "";
      let rq_id ="";

      if (output.status == 200) {
        output.data.forEach((type) => {
          rq_type = type.type_name;
          rqt_desc = type.type_description;
          rq_icon = type.type_icon;
          rq_short = type.type_code;  
          rq_kpi_minites = type.type_kpi_minuts;
          rq_color = type.type_color;
          rq_id = type.type_id;
        });
      }
      Swal.fire({
        title: "Add Type Request",
        // input: 'text',
        html: `
      <div  style="text-align:left">
      <div class="mb-3">
        <label for="" class="form-label">Request Type</label>
        <input type="text" class="form-control" id="rq_type" name="rq_type" value="${rq_type}"> 
      </div>
      <div class="mb-3 ">
        <label for="" class="form-label">Link Icon</label>
        <input type="text" class="form-control" id="rq_icon" name="rq_icon" value="${rq_icon}">
        <div id="" class="form-text" style="color:red"><i class="bi bi-info-circle-fill"></i>&nbsp;Icon source &nbsp;<i class="bi bi-arrow-right"></i>&nbsp; <a href="https://icons8.com/line-awesome">https://icons8.com/line-awesome</a> </div>
      </div>
      <div class="mb-3 ">
        <label for="" class="form-label">Description</label>
        <textarea  class="form-control" id="rqt_desc" name="rqt_desc" value="">${rqt_desc}</textarea>
        
      </div>
      <div class="mb-3 ">
      <label for="" class="form-label">Abbreviation</label>
      <input type="text" class="form-control" id="rq_short" name="rq_short" value="${rq_short}">
      <div id="" class="form-text" style="color:red"><i class="bi bi-info-circle-fill"></i>&nbsp;Example : File Sharing &nbsp;<i class="bi bi-arrow-right"></i>&nbsp; FS</div>
      </div>
      <div class="mb-3">
            <div class="col-md-3">
            <label for="" class="form-label">Set Color</label>
                 <input type="color" class="form-control" id="rq_color" name="rq_color" value="${rq_color}">
           </div> 
       </div>
      <div class="mb-3">
      <label for="" class="form-label">KPI (Minute)</label>
      <div class="col-md-12">
      <input type="number" class="form-control" id="rq_kpi_minites" name="rq_kpi_minites" value="${rq_kpi_minites}">
      <span id="result" class="TimeCal mt-2"></span>
      </div>
      </div>
       
      <button type="button" class="btn btn-primary float-end" onclick="addTypeRq(${id})">${id != 0 ? `Update` : `Add`}</button>
    </div>
      `,
        padding: '1em',
        showConfirmButton: false,
        showCloseButton:true,
      });
      countTimeforKPI()
    }
  );

  if (id != 0) {
  } else {
  }
}

function addTypeRq(id) {
  if (checkDataInputRequest(['rq_type', 'rq_icon', 'rq_short', 'rq_kpi_minites', 'rq_color'])) {
    let dataAPI = {
      rq_type: byId('rq_type').value,
      rqt_desc: byId('rqt_desc').value,
      rq_icon: byId('rq_icon').value,
      rq_short: byId('rq_short').value,
      rq_kpi_minites: byId('rq_kpi_minites').value,
      rq_color: byId('rq_color').value,
      id: id,
    };
    Swal.fire({
      icon: 'warning',
      title: 'Confirm?',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      cancelButtonText: 'No',
    }).then((result) => {
      if (result.isConfirmed) {
        connectApi(
          'getdata/typeRequestSetting',
          { type: 'manage', data: dataAPI, dataoption: 0 },
          '',
          function (output) {
            console.log(output);
            if (output.status == 200) {
              getdataTypeRequestSwitch();
            }
          }
        );
      }
    });
  }
}




function getDataTypeRequest() {
  connectApi(
    "getdata/TypeRequest",
    { type: "formrequest", data: 0, dataoption: 0 },
    "",
    function (output) {
      // console.log(output)
      if (output.status == 200) {
        let typeRequest = output.data;
        let htmltypeRequest = byId("typeRequest");

        htmltypeRequest.innerHTML = "";

        typeRequest.forEach((type) => {
          htmltypeRequest.innerHTML += `
           <div class="col-4 col-sm-4 col-md-3 col-xxl-2 mb-2">
            <div class="custom-radio">
              <input type="radio" id="typeProblem_${type.type_id}" data-type="${type.type_id}" name="radio"  class="type_problem" />
              <label for="typeProblem_${type.type_id}" class="radio-btn"><i class="las la-check"></i>
                  <div class="hobbies-icon">
                    <i class="${type.type_icon}"></i>
                    <h3>${type.type_name}</h3>
                  </div>
              </label>
            </div>
          </div>`;
        });

        htmltypeRequest.innerHTML += `
        <div class="col-4 col-sm-4 col-md-3 col-xxl-2">
         <div class="custom-radio">
           <input type="radio" id="typeProblem_12" data-type="12" name="radio"  class="type_problem" />
           <label for="typeProblem_12" class="radio-btn"><i class="las la-check"></i>
               <div class="hobbies-icon">
                 <i class="las la-ellipsis-h"></i>
                 <h3>Other</h3>
               </div>
           </label>
         </div>
       </div>`;

        console.log(typeRequest);
      } else {
      }
    }
  );
}

function getDataTypeRequestForAdmin(token) {
  connectApi(
    "getdata/TypeRequest",
    { type: "formrequest", data: 0, dataoption: 0 },
    "",
    function (output) {
      console.log(output);
      if (output.status == 200) {
        let typeRequest = output.data;
        let htmltypeRequest = byId("typeRequest");

        htmltypeRequest.innerHTML = "";

        typeRequest.forEach((type) => {
          htmltypeRequest.innerHTML += `
          
          <label class="custom-radio">
            <input type="radio" id="typeProblem_${type.type_id}" data-type="${type.type_id}" name="radio"  class="type_problem" />
            <span class="radio-btn"><i class="las la-check"></i>
               <div class="hobbies-icon">
                  <i class="${type.type_icon}"></i>
                  <h3>${type.type_name}</h3>
               </div>
            </span>
         </label>`;
        });
        getDataFormRequest(token);
        console.log(typeRequest);
      } else {
      }
    }
  );
}

let array_status_form_request = [
  `cancel`,
  `Assign Issue`,
  `Assigned`,
  `Complete`,
  `Inprocess`,
  `rejected`,
  `changType`
];
const array_status_class = [
  `rejected`,
  `assigned`,
  `assign`,
  `complete`,
  `inprocess`,
  `rejected`,
];


function selectFilterEmp(){
  connectApi(
    "getdata/TypeRequest",
    { type: "EmpDash", data: 0, dataoption: 0 },
    "",

    function (output) {
      console.log(output);
      if (output.status == 200) {
        let typeRequest = output.data;
        let htmltypeRequest = byId("ticketfilterEmp");

        htmltypeRequest.innerHTML = "";
        htmltypeRequest.innerHTML += `
        <option value="All">All</option>
      `;
        typeRequest.forEach((res_emp) => {
          htmltypeRequest.innerHTML += `
             <option value="${res_emp.emp_id}">${res_emp.emp_fname} ${res_emp.emp_lname}</option>
           `;
        });
        console.log(typeRequest);

        getDataHistoryRequest();
      } else {
      }
    }
  );
}

function selecthFilterEmp(){
  connectApi(
    "getdata/TypeRequest",
    { type: "EmpDash", data: 0, dataoption: 0 },
    "",

    function (output) {
      console.log(output);
      if (output.status == 200) {
        let typeRequest = output.data;
        let htmltypeRequest = byId("ticketfilterHistoryEmp");

        htmltypeRequest.innerHTML = "";
        htmltypeRequest.innerHTML += `
        <option value="All">All</option>
      `;
        typeRequest.forEach((history) => {
          htmltypeRequest.innerHTML += `
             <option value="${history.emp_id}">${history.emp_fname} ${history.emp_lname}</option>
           `;
        });
        console.log(typeRequest);

        getDataTicketComplete();
      } else {
      }
    }
  );
}
function planToWork(id) {
  connectApi(
    "getdata/HistoryRequest",
    { type: "view", data: id, dataoption: 0 },
    "loadingDiv",

    
    function (output) {
      if (output.status == 200) {
        output.data.forEach((editor) => {
          // Handle each editor object as needed
          // For example, access editor properties like editor.propertyName
        });
      }
console.log(id)
      Swal.fire({
        title: "Plan to Work",
        html: `
        
          <div class="PlanWork mt-2">
            <div class="mb-3">
              <label class="form-label float-start">Start date</label>
              <input type="datetime-local" class="form-control" id="planTimeStart" name="planTimeStart">
            </div>   
            <div class="mb-3">
              <label class="form-label float-start">Remark</label>
              <textarea class="form-control" rows="3" id="planRemark" name="planRemark"></textarea>
            </div>
            <div class="float-end mt-2">
              <button class="btn btn-info" onclick="sendPlan(${id})">Create Plan</button>
            </div>
          </div>
          `,
        width: 500,
        padding: '1em',
        showCancelButton: false,
        showConfirmButton: false,
      });
    }
  );

  if (id != 0) {
    // Handle the case where id is not equal to 0
  } else {
    // Handle the case where id is equal to 0
  }
}



function sendPlan(id) {
  let dataAPI = {
    planTimeStart: moment(byId(`planTimeStart`).value).format('YYYY-MM-DD H:mm'),
    planRemark: byId(`planRemark`).value,
    id: id,
  };
  console.log(dataAPI)
  Swal.fire({
    icon:'warning',
    title: "Confirm Plan?",
    showCancelButton: true,
    confirmButtonText: "Confirm",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      connectApi("getdata/CurrentJobRequest", { type: "planProcess", data: dataAPI, dataoption: 0 }, "loadingDiv", 
      function (output) {
        console.log(output);
        if (output.status == 200) {
          Swal.fire({
            icon:'success',
            title: "Confirm?",
            confirmButtonText: "OK!",
          });
        }
      });
    }
  });
}

function finishWork(id) {
  // Swal.fire({
  //   title:"Complete Ticket",
  //   html: `
  //     <div class="col-md-12">
  //           <img class="d-flex" src="https://img.freepik.com/premium-vector/woman-working-laptop-cartoon-illustration_607277-158.jpg?w=2000" width="60%" 
  //           style="align-items: center;
  //           justify-content: center;
  //           margin-left: 20%;
  //           border-radius: 50%;">
  //           <label class="mt-3">Remark</label>
  //           <textarea class="form-control mt-2" id="remarkSolveTicket" name="remarkSolveTicket"></textarea>
  //           <button class="btn btn-success float-end mt-2" onclick="problemSolve(${id})">Ticket Solve</button>
  //     </div>
  //   `,
  //   width: 700,
  //   padding: '1rem',
  //   showConfirmButton: false,
  //   showCloseButton: true,
  // });

  Swal.fire({
    title: 'Complete Ticket?',
    // html:``;
    confirmButtonText: 'Confirm',
    showCancelButton: true,
    cancelButtonText: 'Cancel',
    input: 'textarea',
    inputPlaceholder: 'remark',
    inputAttributes: { 'aria-label': 'remark'},
    inputValidator: (value) => {
        if (value && value.length<=240) {
            // console.log(value,value.length)
            // activeStatusWorkOther_(toType, workId, type, token, 'finish', value)
            problemSolve(id,value)
        } else {
            if(value.length>240){
                return 'Supports 250 characters.'
            }else{
                return 'Please provide complete information.!'
            }
        }
    }
})



  if (id != 0) {
    // Handle the case where id is not equal to 0
  } else {
    // Handle the case where id is equal to 0
  }
}


function problemSolve(id,remark){
  let dataAPI = {
    remarkSolveTicket : remark,
    id: id,
  };
  console.log(dataAPI)
  Swal.fire({
    icon : 'warning',
    title: "Confirm?",
    showCancelButton: true,
    confirmButtonText: "Confirm",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      connectApi("getdata/CurrentJobRequest", { type: "finish", data: dataAPI, dataoption: 0 }, "loadingDiv", function (output) {
        console.log(output);
        if (output.status == 200) {
          Swal.fire({
           icon:'success',
           title: "Ticket Complete",
           confirmButtonText: "Close!",
          }).then((result) => {
            location.reload();
          });
        }
      });
    }
  });
}

function showContent() {
  const pbSolveRadio = document.getElementById('pbSolve');
  const forwardRadio = document.getElementById('forward');
  const divCardforfinishTicket = document.getElementById('div-cardforfinishTicket');
  const divCardforForward = document.getElementById('div-cardforForward');

  if (pbSolveRadio.checked) {
    divCardforfinishTicket.style.display = 'block';
    divCardforForward.style.display = 'none';
  } else if (forwardRadio.checked) {
    divCardforfinishTicket.style.display = 'none';
    divCardforForward.style.display = 'block';
  }
}




function checkAllCheckboxes() {
  var checkboxes = document.querySelectorAll('.checkbox_select input[type="checkbox"]');
  var checkAllCheckbox = document.getElementById('checkAll');

  for (var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = checkAllCheckbox.checked;
  }
  var checkAllCheckbox = document.getElementById('checkAll');
  checkAllCheckbox.addEventListener('change', checkAllCheckboxes);
}



function getDataInprocessWork() {
  let show = byId(`show-inprocessWork`);
  show.innerHTML = "";

  let dataAPI = {
    search : byId('SeachMyjob').value,
    filterstatus : byId('filterstatus').value,
    start : FILTER_START,
    end :FILTER_END
  }
  connectApi(
    "getdata/CurrentJobRequest",
    { type: "forstaff", data: dataAPI, dataoption: 0 },
    "loadingDiv",
    function (output) {
      console.log(output);
      if (output.status == 200) {
        let typeRequest = output.data;

        typeRequest.forEach((Current) => {
          let file = Current.file;
          let empInpro = Current.staffIn;
          // let Staffshow = Current.staffInpro;
          // let optionShowEmp ="";

         
          let txtFile = "";
          file.forEach((file) => {
            let showFile = file.file_name.split(".");
            let array_file_type = [`pdf`, `docx`, `jpg`, `png`, `xlsx`];
            txtFile += `
            <button class="button_file" onclick="viewModelPDFV2('include/uploads/${file.file_path}','${file.file_name}','#${Current.Ticket_No}')">
            <img src="${BASEPATH}include/icon_file/file_${array_file_type.includes(showFile[1]) ? showFile[1] : `other`}.png" width="25px"></button>&nbsp;`;
          });

          let optionRespon ="";
          let request_responder = Current.request_responder;
          empInpro.forEach((optionRes) => {
            let selectSatff =""
            if(optionRes.emp_id==request_responder){
              selectSatff='selected';
            }
            optionRespon += `<option ${selectSatff} value="${optionRes.emp_id}">${optionRes.emp_fname} ${optionRes.emp_lname}</option>`;
          });

          show.insertAdjacentHTML(
            "beforeend",
            `<div class="box work mb-3">
    
          <div class="result tagStatus" >
          <p class="${array_status_class[Current.request_status]} float-end mt-1">${array_status_form_request[Current.request_status]}</p>
        </div>
        
            <div class="d-flex flex-wrap">
            
              <div class="head w-100">
              
                <div class="header w-100">
                <div class="float-end">
                <div class="" onclick="checkTimeline(${Current.request_id}); return false;" style="border-radius: 1rem;
        background-color: #ebebeb;
        padding: 0.25rem 16px;
        margin-right: .5rem;
        display: flow-root;
        align-content: center;
        cursor: pointer;
        align-self: flex-end;"><i class="fas fa-stream"></i> Timeline Status</div>
        </div>
                  <div class="title">
                  
                    <div class="workType">
                    <div class="icontype" style="background-color:${Current.type_color}">
                    <i class="${Current.type_icon}"></i> ${Current.type_name}
                  </div>
                    </div>
                    <div class="workTitle d-flex gap-2">
                      <div class="mt-2">
                        <a href="" onclick="checkTimeline(${Current.request_id}); return false;" class="TimelineCheck">
                          ${Current.request_title}
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="mt-2 description">
                    <p><small>${Current.request_description}</small></p>
                  </div>
                  <div class="detail">
                    <div class="workNo borderRight">#${Current.Ticket_No}</div>
                    <div class="workNo borderRight"><i class="fas fa-user"></i> ${Current.emp_fname} ${Current.emp_lname}</div>
                    <div class="workNo borderRight"><i class="fas fa-history"></i>
                      ${moment(Current.request_create_at).format("H:m | DD MMM YYYY ")}
                    </div>
                    <div class="workNo" style="${array_style_urgent[Current.request_urgent]};">
                      <i class="fas fa-thumbtack"></i> Due date: ${moment(Current.request_duedate).format("H:m | DD MMM YYYY ")}
                      <img src="https://em-content.zobj.net/source/animated-noto-color-emoji/356/police-car-light_1f6a8.gif" width="3%">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr class="my-2">
            ${Current.assign_status!=3?`<div class="costomFooterTicket float-end"> 
                <div class="mobileSizeCurrent">
                  <button class="Startbtn me-2" ${Current.request_status != 2 ? 'style="display:none;"' : ''} onclick="startProcess(${Current.request_id})">Start</button>
                  <button class="CommentBtn me-2" ${Current.request_status != 2 ? '' : 'style="display:none;"'} onclick="CommentTicket(${Current.request_id},'${Current.request_status}')">Update User Info</button>
                  <button class="FinishWorkBtn" ${Current.request_status != 2 ? '' : 'style="display:none;"'} onclick="finishWork(${Current.request_id})">Finish</button>
                </div>
             </div>`:``}
            
            <div class="footer d-flex">
              <div class="option d-flex  ">
                
                <button class="btn btn-light me-2 ${!!Current.assign_plan? 'd-none':''}" ${Current.request_status ==3 ? 'style="display:none;"':''}  onclick="planToWork(${Current.request_id})">Plan</button>
                
             </div>
             <div class="file-box">
             ${txtFile}
       </div>
             
                
            </div>
          </div>
          
          
          
          `
          ); 
        });

      } else {
        console.log(output.message);
        show.innerHTML = `<div class="text-center">Empty!</div>`;
      }
    }
   
  );
}
function startProcess(id) {
  Swal.fire({
    title: 'Start?',
    // html:``;
    confirmButtonText: 'Confirm',
    showCancelButton: true,
    cancelButtonText: 'Cancel',
    input: 'textarea',
    inputPlaceholder: 'remark',
    inputAttributes: { 'aria-label': 'remark'},
    inputValidator: (value) => {
        if (value && value.length<=240) {
            // console.log(value,value.length)
            // activeStatusWorkOther_(toType, workId, type, token, 'finish', value)
            startProcessComplete(id,value)
        } else {
            if(value.length>240){
                return 'Supports 250 characters.'
            }else{
                return 'Please provide complete information.!'
            }
        }
    }
}).then((result) => {
    if (!result.isConfirmed) {}
})


}

function startProcessComplete(id,startPc){
  let dataAPI = {
    startPc : startPc,
    id: id,
  };
  console.log(dataAPI)
  Swal.fire({
    icon : 'warning',
    title: "Confirm Start?",
    showCancelButton: true,
    confirmButtonText: "Confirm",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      connectApi("getdata/CurrentJobRequest", { type: "start", data: dataAPI, dataoption: 0 }, "loadingDiv", function (output) {
        console.log(output);
        if (output.status == 200) {
          Swal.fire({
           icon:'success',
           title: "Start Process Complete",
           confirmButtonText: "Close!",
          }).then((result) => {
            location.reload()
          });
          
        }
      });
    }
  });
}


function addTicketTimeline(id){
  // let dataAPI = {
  //   descInput : byId('descInput').value,
  //   id: id,
  // };
  // Swal.fire({
  //   icon: 'warning',
  //   title: 'Confirm Sent?',
  //   showCancelButton: true,
  //   confirmButtonText: 'Yes',
  //   cancelButtonText: 'No',
  // }).then((result) => {
  //   if (result.isConfirmed) {
  //     connectApi(
  //       'getdata/CurrentJobRequest',
  //       { type: 'comment', data: dataAPI, dataoption: 0 },
  //       'loadingDiv',
  //       function (output) {
  //         console.log(output);
  //         if (output.status == 200) {
  //           Swal.fire({
  //             icon: 'success',
  //             title: 'Comment Success',
  //             showCancelButton: false,
  //             confirmButtonText: 'OK',
  //           }); 
  //           checkTimeline(id)
  //         } 
  //       }
  //     );
  //   }
  // });
} 

function CommentTicketTimeline(id,descInput){
  let dataAPI = {
    descInput : descInput,
    id: id,
  };
  Swal.fire({
    icon: 'warning',
    title: 'Confirm?',
    showCancelButton: true,
    confirmButtonText: 'Yes',
    cancelButtonText: 'Cancel',
  }).then((result) => {
    if (result.isConfirmed) {
      connectApi(
        'getdata/CurrentJobRequest',
        { type: 'comment', data: dataAPI, dataoption: 0 },
        'loadingDiv',
        function (output) {
          console.log(output);
          if (output.status == 200) {
            checkTimeline(id)
          } 
        }
      );
    }
  });
} 

function checkTimeline(id) {
  connectApi(
    "getdata/checkTimelineTicket",
    { type: "timeline", data: id, dataoption: 0 },
    "",
    function (output) {
      console.log(output);

      let Timeline = "";

      output.data.forEach((detail) => {
        Timeline += `<li>
                       <div class="content">
                          <div class="time">
                              <h3>${detail.status_icon} ${moment(detail.timeline_timestamp).format("HH:mm | DD MMM YYYY ")}</h3>
                          </div>
                              <h2>${detail.timeline_title}</h2>
                              <p class="text-info" ${detail.timeline_description ? "" : `style="display:none"`}>${detail.timeline_description}</p>
                              
                              <p><small><i class="far fa-user"></i> ${detail.emp_fname}  ${detail.emp_lname}</small></p>
                          </div>
                      </li>`;
      })

      Swal.fire({
        html: `
        <h4>Timeline</h4>
        <div class="timeline">
            <ul>
                ${Timeline}
            </ul>
        </div>
        `,
        width: 500,
        heightAuto: true,
        padding: '1em',
        showCloseButton: true,
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        confirmButtonText:'Sent', 
        input: 'textarea',
        inputPlaceholder: 'Type here',
        inputAttributes: { 'aria-label': 'remark' },
        inputValidator: (value) => {
            if (value && value.length <= 240) {
                CommentTicketTimeline(id, value);
            } else {
                if (value.length > 240) {
                    return 'Supports 250 characters.';
                } else {
                    return 'Please provide complete information!';
                }
            }
        }
      }).then((result) => {
        if (result.isConfirmed) {
        
        }
      });
    }
  );

  if (id != 0) {
  } else {
  }
}



function getDataTicketComplete() {
  let show = document.getElementById('showInfoHistory');
  show.innerHTML = "";

  let dataAPI = {
    search: document.getElementById('searchInputhistory').value,
    filterbystatus : byId('filterHistoryType').value,
    filterbyEmp : byId('ticketfilterHistoryEmp').value,
    datestart: FILTER_START,
    dateend: FILTER_END
  };

  console.log(dataAPI);

  connectApi(
    "getdata/TicketComplete",
    { type: "forcheck", data: dataAPI, dataoption: 0 },
    "loadingDiv",
    function(output) {
      console.log(output);
      if (output.status == 200) {
        let typeRequest = output.data;

        typeRequest.forEach(Complete => {
          let file = Complete.file;
          let respon = Complete.staffitCom;
          let txtFile = "";
   

          file.forEach((file) => {
            let showFile = file.file_name.split(".");
            let array_file_type = [`pdf`, `docx`, `jpg`, `png`, `xlsx`];
            txtFile += `
            <button class="button_file" onclick="viewModelPDFV2('include/uploads/${file.file_path}','${file.file_name}','#${Complete.Ticket_No}')">
            <img src="${BASEPATH}include/icon_file/file_${array_file_type.includes(showFile[1]) ? showFile[1] : `other`}.png" width="25px"></button>&nbsp;`;
          });

          let rating = "";
          typeRequest.forEach((star) => {
            for (let i = 0; i < star.request_rate_service; i++) {
              rating += `<i class="fas fa-star" style="color: #f3d462;"></i>`;
            }
          });
          
          
                
          let service = "";
      typeRequest.forEach((star) => {
        for (let i = 0; i < star.request_rate; i++) {
          service += `<i class="fas fa-star" style="color: #f3d462;"></i>`;
        }
      });

          

        let optionresponder ="";
        let request_responder = Complete.request_responder;
        respon.forEach((optionRes) => {
          let selectSatff =""
          if(optionRes.emp_id==request_responder){
            selectSatff='selected';
          }
          optionresponder += `<option ${selectSatff} value="${optionRes.emp_id}">${optionRes.emp_fname} ${optionRes.emp_lname}</option>`;
        });

          let feedbackStyle = Complete.request_rate_service!=0 ? "" : "style=\"display:none\"";
          let showfeedbackcutton = (Complete.request_status==5? 'd-none' : '')
          let showfeedbackcutton1 = (Complete.request_rate_service!=0? 'd-none' : '')



          show.insertAdjacentHTML(
            "beforeend",
            `<div class="box work mb-3"><div class="result tagStatus" >
                <p class="${array_status_class[Complete.request_status]} float-end mt-1">${array_status_form_request[Complete.request_status]}</p>
              </div>
              <div>
                <div class="floatRight">
                
                </div>
                <div class="head">
            
                  <div class="header w-100">
                  <div class="float-end">
                  <div class="" onclick="checkTimeline(${Complete.request_id}); return false;" style="border-radius: 1rem;
                  background-color: #ebebeb;
                  padding: 0.25rem 16px;
                  margin-right: .5rem;
                  display: flow-root;
                  align-content: center;
                  cursor: pointer;
                  align-self: flex-end;"><i class="fas fa-stream"></i> Timeline Status</div>
                  </div>
                    <div class="title">
                      <div class="workType">
                      <div class="icontype" style="background-color:${Complete.type_color}">
                      <i class="${Complete.type_icon}"></i> ${Complete.type_name}
                    </div>
                      </div>
                      <div class="workTitle d-flex gap-2">
                        <div class="mt-2"><a href="" onclick="checkTimeline(${Complete.request_id}); return false;" class="TimelineCheck">${Complete.request_title}</a></div>
                      </div>
                    </div>
                    <div class="mt-2 description"><p><small>${Complete.request_description}</small></p></div>
                    
                    <div class="alert alert-light" ${feedbackStyle} role="alert">
                          <h><small>Feedback :${Complete.request_comment}</small></h>
                          <div class="workNo borderRight" ><small>Hour Service Rate : ${rating}</small></div>
                          <div class="workNo"}><small>Service Rate : ${service}</small></div>
                    </div>
                      <div class="detail">
                      <div class="workNo borderRight">#${Complete.Ticket_No}</div>
                      <div class="workNo borderRight"><i class="fas fa-user"></i> ${Complete.emp_fname} ${Complete.emp_lname}</div>
                      <div class="workNo borderRight"><i class="fas fa-history"></i> ${moment(Complete.request_create_at).format("H:m | DD MMM YYYY ")}</div>
                   
                    </div>
                  </div>
                </div>
              </div>
              <hr class="m-0">
              <div class="footer d-flex">
                <div class="option d-flex">
                  <div class="icon"><i class="bi bi-person-badge"></i></div>
                  <div>
                  <select class="form-select" disabled>
                    ${optionresponder}
                  </select>
                </div>
                
                </div>
                  <button class="FeedbackBtn ${showfeedbackcutton} ${showfeedbackcutton1}"  onclick="Assessment(${Complete.request_id})">Feedback</button>
                <div class="floatRight">
                <div class="file-box">
                  ${txtFile !== " " ? txtFile : ''}
                </div>

                </div>
               
              </div>
            </div>`
          );
        });
      } else {
        console.log(output.message);
        show.innerHTML = `<div class="text-center">Empty!</div>`;
      }
    }
  );
}


function Assessment(id) {
  connectApi(
    "getdata/HistoryRequest",
    { type: "assessment", data: id, dataoption: 0 },
    "",
    
    function (output) {
      console.log(output);
      let ass_title = "";
      let ass_desc = "";
      let ass_Date = "";
      let ass_running ="";
      let ass_resf ="";
      let ass_resl ="";
      let ass_id ="";
      // let ass_FinishTime ="";
      console.log(id)
      if (output.status == 200) {
        output.data.forEach((ass) => {
          ass_title = ass.request_title;
          ass_desc = ass.request_description;
          ass_Date = ass.request_create_at;
          ass_running = ass.request_workNo;
          ass_resf = ass.emp_fname;
          ass_resl = ass.emp_lname;
          ass_id = id ;
        });

        
      }
      Swal.fire({
        html: `
        <div class="container">
        <h4>Assessment <img src="https://i.pinimg.com/originals/ed/76/df/ed76df1b5da78ca7317a01cf9a648d0c.gif" width="5%" class="mb-1 img-responsive"></h4>
        <div class="cardForAss">
          <div class="row">
            <div class="col-md-6">
              <div class="cardforAssdetail">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="fortitle" value="${ass_title}" disabled>
                  <label for="fortitle">Ticket title</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="datetime-local" class="form-control" id="duedate" value="${ass_Date}" disabled>
                  <label for="duedate">Created at</label>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="cardforAssdetail">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="fortype" value="${ass_running}" disabled>
                  <label for="fortype">Ticket No</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="forres" value="${ass_resf} ${ass_resl}" disabled>
                  <label for="forres">Responder</label>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-11">
              <h5 class="mt-1"><img src="https://cdn-icons-png.flaticon.com/512/1196/1196635.png" width="4%"> Description</h5>
              <div class="DescAss">
                <p>${ass_desc}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
        <div class="RatingAss mt-3 row">
        <div class="col-md-6 p-2">
        
        
       
        <div class="feedback">
        <h5 style="text-align:left;">Working hours are acceptable.</h5>
          <div class="rating">
            <input type="radio" name="rating" id="rating-5">
            <label for="rating-5"></label>
            <input type="radio" name="rating" id="rating-4">
            <label for="rating-4"></label>
            <input type="radio" name="rating" id="rating-3">
            <label for="rating-3"></label>
            <input type="radio" name="rating" id="rating-2">
            <label for="rating-2"></label>
            <input type="radio" name="rating" id="rating-1">
            <label for="rating-1"></label>
            <div class="emoji-wrapper">
              <div class="emoji">
                <svg class="rating-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                <path d="M512 256c0 141.44-114.64 256-256 256-80.48 0-152.32-37.12-199.28-95.28 43.92 35.52 99.84 56.72 160.72 56.72 141.36 0 256-114.56 256-256 0-60.88-21.2-116.8-56.72-160.72C474.8 103.68 512 175.52 512 256z" fill="#f4c534"/>
                <ellipse transform="scale(-1) rotate(31.21 715.433 -595.455)" cx="166.318" cy="199.829" rx="56.146" ry="56.13" fill="#fff"/>
                <ellipse transform="rotate(-148.804 180.87 175.82)" cx="180.871" cy="175.822" rx="28.048" ry="28.08" fill="#3e4347"/>
                <ellipse transform="rotate(-113.778 194.434 165.995)" cx="194.433" cy="165.993" rx="8.016" ry="5.296" fill="#5a5f63"/>
                <ellipse transform="scale(-1) rotate(31.21 715.397 -1237.664)" cx="345.695" cy="199.819" rx="56.146" ry="56.13" fill="#fff"/>
                <ellipse transform="rotate(-148.804 360.25 175.837)" cx="360.252" cy="175.84" rx="28.048" ry="28.08" fill="#3e4347"/>
                <ellipse transform="scale(-1) rotate(66.227 254.508 -573.138)" cx="373.794" cy="165.987" rx="8.016" ry="5.296" fill="#5a5f63"/>
                <path d="M370.56 344.4c0 7.696-6.224 13.92-13.92 13.92H155.36c-7.616 0-13.92-6.224-13.92-13.92s6.304-13.92 13.92-13.92h201.296c7.696.016 13.904 6.224 13.904 13.92z" fill="#3e4347"/>
              </svg>
                <svg class="rating-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
                <path d="M328.4 428a92.8 92.8 0 0 0-145-.1 6.8 6.8 0 0 1-12-5.8 86.6 86.6 0 0 1 84.5-69 86.6 86.6 0 0 1 84.7 69.8c1.3 6.9-7.7 10.6-12.2 5.1z" fill="#3e4347"/>
                <path d="M269.2 222.3c5.3 62.8 52 113.9 104.8 113.9 52.3 0 90.8-51.1 85.6-113.9-2-25-10.8-47.9-23.7-66.7-4.1-6.1-12.2-8-18.5-4.2a111.8 111.8 0 0 1-60.1 16.2c-22.8 0-42.1-5.6-57.8-14.8-6.8-4-15.4-1.5-18.9 5.4-9 18.2-13.2 40.3-11.4 64.1z" fill="#f4c534"/>
                <path d="M357 189.5c25.8 0 47-7.1 63.7-18.7 10 14.6 17 32.1 18.7 51.6 4 49.6-26.1 89.7-67.5 89.7-41.6 0-78.4-40.1-82.5-89.7A95 95 0 0 1 298 174c16 9.7 35.6 15.5 59 15.5z" fill="#fff"/>
                <path d="M396.2 246.1a38.5 38.5 0 0 1-38.7 38.6 38.5 38.5 0 0 1-38.6-38.6 38.6 38.6 0 1 1 77.3 0z" fill="#3e4347"/>
                <path d="M380.4 241.1c-3.2 3.2-9.9 1.7-14.9-3.2-4.8-4.8-6.2-11.5-3-14.7 3.3-3.4 10-2 14.9 2.9 4.9 5 6.4 11.7 3 15z" fill="#fff"/>
                <path d="M242.8 222.3c-5.3 62.8-52 113.9-104.8 113.9-52.3 0-90.8-51.1-85.6-113.9 2-25 10.8-47.9 23.7-66.7 4.1-6.1 12.2-8 18.5-4.2 16.2 10.1 36.2 16.2 60.1 16.2 22.8 0 42.1-5.6 57.8-14.8 6.8-4 15.4-1.5 18.9 5.4 9 18.2 13.2 40.3 11.4 64.1z" fill="#f4c534"/>
                <path d="M155 189.5c-25.8 0-47-7.1-63.7-18.7-10 14.6-17 32.1-18.7 51.6-4 49.6 26.1 89.7 67.5 89.7 41.6 0 78.4-40.1 82.5-89.7A95 95 0 0 0 214 174c-16 9.7-35.6 15.5-59 15.5z" fill="#fff"/>
                <path d="M115.8 246.1a38.5 38.5 0 0 0 38.7 38.6 38.5 38.5 0 0 0 38.6-38.6 38.6 38.6 0 1 0-77.3 0z" fill="#3e4347"/>
                <path d="M131.6 241.1c3.2 3.2 9.9 1.7 14.9-3.2 4.8-4.8 6.2-11.5 3-14.7-3.3-3.4-10-2-14.9 2.9-4.9 5-6.4 11.7-3 15z" fill="#fff"/>
              </svg>
                <svg class="rating-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
                <path d="M336.6 403.2c-6.5 8-16 10-25.5 5.2a117.6 117.6 0 0 0-110.2 0c-9.4 4.9-19 3.3-25.6-4.6-6.5-7.7-4.7-21.1 8.4-28 45.1-24 99.5-24 144.6 0 13 7 14.8 19.7 8.3 27.4z" fill="#3e4347"/>
                <path d="M276.6 244.3a79.3 79.3 0 1 1 158.8 0 79.5 79.5 0 1 1-158.8 0z" fill="#fff"/>
                <circle cx="340" cy="260.4" r="36.2" fill="#3e4347"/>
                <g fill="#fff">
                  <ellipse transform="rotate(-135 326.4 246.6)" cx="326.4" cy="246.6" rx="6.5" ry="10"/>
                  <path d="M231.9 244.3a79.3 79.3 0 1 0-158.8 0 79.5 79.5 0 1 0 158.8 0z"/>
                </g>
                <circle cx="168.5" cy="260.4" r="36.2" fill="#3e4347"/>
                <ellipse transform="rotate(-135 182.1 246.7)" cx="182.1" cy="246.7" rx="10" ry="6.5" fill="#fff"/>
              </svg>
                <svg class="rating-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
          <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
          <path d="M407.7 352.8a163.9 163.9 0 0 1-303.5 0c-2.3-5.5 1.5-12 7.5-13.2a780.8 780.8 0 0 1 288.4 0c6 1.2 9.9 7.7 7.6 13.2z" fill="#3e4347"/>
          <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
          <g fill="#fff">
            <path d="M115.3 339c18.2 29.6 75.1 32.8 143.1 32.8 67.1 0 124.2-3.2 143.2-31.6l-1.5-.6a780.6 780.6 0 0 0-284.8-.6z"/>
            <ellipse cx="356.4" cy="205.3" rx="81.1" ry="81"/>
          </g>
          <ellipse cx="356.4" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347"/>
          <g fill="#fff">
            <ellipse transform="scale(-1) rotate(45 454 -906)" cx="375.3" cy="188.1" rx="12" ry="8.1"/>
            <ellipse cx="155.6" cy="205.3" rx="81.1" ry="81"/>
          </g>
          <ellipse cx="155.6" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347"/>
          <ellipse transform="scale(-1) rotate(45 454 -421.3)" cx="174.5" cy="188" rx="12" ry="8.1" fill="#fff"/>
        </svg>
                <svg class="rating-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
                <path d="M232.3 201.3c0 49.2-74.3 94.2-74.3 94.2s-74.4-45-74.4-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b"/>
                <path d="M96.1 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2C80.2 229.8 95.6 175.2 96 173.3z" fill="#d03f3f"/>
                <path d="M215.2 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff"/>
                <path d="M428.4 201.3c0 49.2-74.4 94.2-74.4 94.2s-74.3-45-74.3-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b"/>
                <path d="M292.2 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2-77.8-65.7-62.4-120.3-61.9-122.2z" fill="#d03f3f"/>
                <path d="M411.3 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff"/>
                <path d="M381.7 374.1c-30.2 35.9-75.3 64.4-125.7 64.4s-95.4-28.5-125.8-64.2a17.6 17.6 0 0 1 16.5-28.7 627.7 627.7 0 0 0 218.7-.1c16.2-2.7 27 16.1 16.3 28.6z" fill="#3e4347"/>
                <path d="M256 438.5c25.7 0 50-7.5 71.7-19.5-9-33.7-40.7-43.3-62.6-31.7-29.7 15.8-62.8-4.7-75.6 34.3 20.3 10.4 42.8 17 66.5 17z" fill="#e24b4b"/>
              </svg>
                <svg class="rating-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <g fill="#ffd93b">
                  <circle cx="256" cy="256" r="256"/>
                  <path d="M512 256A256 256 0 0 1 56.8 416.7a256 256 0 0 0 360-360c58 47 95.2 118.8 95.2 199.3z"/>
                </g>
                <path d="M512 99.4v165.1c0 11-8.9 19.9-19.7 19.9h-187c-13 0-23.5-10.5-23.5-23.5v-21.3c0-12.9-8.9-24.8-21.6-26.7-16.2-2.5-30 10-30 25.5V261c0 13-10.5 23.5-23.5 23.5h-187A19.7 19.7 0 0 1 0 264.7V99.4c0-10.9 8.8-19.7 19.7-19.7h472.6c10.8 0 19.7 8.7 19.7 19.7z" fill="#e9eff4"/>
                <path d="M204.6 138v88.2a23 23 0 0 1-23 23H58.2a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#45cbea"/>
                <path d="M476.9 138v88.2a23 23 0 0 1-23 23H330.3a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#e84d88"/>
                <g fill="#38c0dc">
                  <path d="M95.2 114.9l-60 60v15.2l75.2-75.2zM123.3 114.9L35.1 203v23.2c0 1.8.3 3.7.7 5.4l116.8-116.7h-29.3z"/>
                </g>
                <g fill="#d23f77">
                  <path d="M373.3 114.9l-66 66V196l81.3-81.2zM401.5 114.9l-94.1 94v17.3c0 3.5.8 6.8 2.2 9.8l121.1-121.1h-29.2z"/>
                </g>
                <path d="M329.5 395.2c0 44.7-33 81-73.4 81-40.7 0-73.5-36.3-73.5-81s32.8-81 73.5-81c40.5 0 73.4 36.3 73.4 81z" fill="#3e4347"/>
                <path d="M256 476.2a70 70 0 0 0 53.3-25.5 34.6 34.6 0 0 0-58-25 34.4 34.4 0 0 0-47.8 26 69.9 69.9 0 0 0 52.6 24.5z" fill="#e24b4b"/>
                <path d="M290.3 434.8c-1 3.4-5.8 5.2-11 3.9s-8.4-5.1-7.4-8.7c.8-3.3 5.7-5 10.7-3.8 5.1 1.4 8.5 5.3 7.7 8.6z" fill="#fff" opacity=".2"/>
              </svg>
              </div>
            </div>
         
        </div>
      </div>
      </div>
      <div class="col-md-6 p-2">
      <div class="feedback">
      <h5 style="text-align:left;">Rating Service</h5>
        <div class="Servicerating">
          <input type="radio" name="Servicerating" id="Servicerating-5">
          <label for="Servicerating-5"></label>
          <input type="radio" name="Servicerating" id="Servicerating-4">
          <label for="Servicerating-4"></label>
          <input type="radio" name="Servicerating" id="Servicerating-3">
          <label for="Servicerating-3"></label>
          <input type="radio" name="Servicerating" id="Servicerating-2">
          <label for="Servicerating-2"></label>
          <input type="radio" name="Servicerating" id="Servicerating-1">
          <label for="Servicerating-1"></label>
          <div class="emoji-wrapper">
            <div class="emoji">
              <svg class="Servicerating-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
              <path d="M512 256c0 141.44-114.64 256-256 256-80.48 0-152.32-37.12-199.28-95.28 43.92 35.52 99.84 56.72 160.72 56.72 141.36 0 256-114.56 256-256 0-60.88-21.2-116.8-56.72-160.72C474.8 103.68 512 175.52 512 256z" fill="#f4c534"/>
              <ellipse transform="scale(-1) rotate(31.21 715.433 -595.455)" cx="166.318" cy="199.829" rx="56.146" ry="56.13" fill="#fff"/>
              <ellipse transform="rotate(-148.804 180.87 175.82)" cx="180.871" cy="175.822" rx="28.048" ry="28.08" fill="#3e4347"/>
              <ellipse transform="rotate(-113.778 194.434 165.995)" cx="194.433" cy="165.993" rx="8.016" ry="5.296" fill="#5a5f63"/>
              <ellipse transform="scale(-1) rotate(31.21 715.397 -1237.664)" cx="345.695" cy="199.819" rx="56.146" ry="56.13" fill="#fff"/>
              <ellipse transform="rotate(-148.804 360.25 175.837)" cx="360.252" cy="175.84" rx="28.048" ry="28.08" fill="#3e4347"/>
              <ellipse transform="scale(-1) rotate(66.227 254.508 -573.138)" cx="373.794" cy="165.987" rx="8.016" ry="5.296" fill="#5a5f63"/>
              <path d="M370.56 344.4c0 7.696-6.224 13.92-13.92 13.92H155.36c-7.616 0-13.92-6.224-13.92-13.92s6.304-13.92 13.92-13.92h201.296c7.696.016 13.904 6.224 13.904 13.92z" fill="#3e4347"/>
            </svg>
              <svg class="Servicerating-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
              <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
              <path d="M328.4 428a92.8 92.8 0 0 0-145-.1 6.8 6.8 0 0 1-12-5.8 86.6 86.6 0 0 1 84.5-69 86.6 86.6 0 0 1 84.7 69.8c1.3 6.9-7.7 10.6-12.2 5.1z" fill="#3e4347"/>
              <path d="M269.2 222.3c5.3 62.8 52 113.9 104.8 113.9 52.3 0 90.8-51.1 85.6-113.9-2-25-10.8-47.9-23.7-66.7-4.1-6.1-12.2-8-18.5-4.2a111.8 111.8 0 0 1-60.1 16.2c-22.8 0-42.1-5.6-57.8-14.8-6.8-4-15.4-1.5-18.9 5.4-9 18.2-13.2 40.3-11.4 64.1z" fill="#f4c534"/>
              <path d="M357 189.5c25.8 0 47-7.1 63.7-18.7 10 14.6 17 32.1 18.7 51.6 4 49.6-26.1 89.7-67.5 89.7-41.6 0-78.4-40.1-82.5-89.7A95 95 0 0 1 298 174c16 9.7 35.6 15.5 59 15.5z" fill="#fff"/>
              <path d="M396.2 246.1a38.5 38.5 0 0 1-38.7 38.6 38.5 38.5 0 0 1-38.6-38.6 38.6 38.6 0 1 1 77.3 0z" fill="#3e4347"/>
              <path d="M380.4 241.1c-3.2 3.2-9.9 1.7-14.9-3.2-4.8-4.8-6.2-11.5-3-14.7 3.3-3.4 10-2 14.9 2.9 4.9 5 6.4 11.7 3 15z" fill="#fff"/>
              <path d="M242.8 222.3c-5.3 62.8-52 113.9-104.8 113.9-52.3 0-90.8-51.1-85.6-113.9 2-25 10.8-47.9 23.7-66.7 4.1-6.1 12.2-8 18.5-4.2 16.2 10.1 36.2 16.2 60.1 16.2 22.8 0 42.1-5.6 57.8-14.8 6.8-4 15.4-1.5 18.9 5.4 9 18.2 13.2 40.3 11.4 64.1z" fill="#f4c534"/>
              <path d="M155 189.5c-25.8 0-47-7.1-63.7-18.7-10 14.6-17 32.1-18.7 51.6-4 49.6 26.1 89.7 67.5 89.7 41.6 0 78.4-40.1 82.5-89.7A95 95 0 0 0 214 174c-16 9.7-35.6 15.5-59 15.5z" fill="#fff"/>
              <path d="M115.8 246.1a38.5 38.5 0 0 0 38.7 38.6 38.5 38.5 0 0 0 38.6-38.6 38.6 38.6 0 1 0-77.3 0z" fill="#3e4347"/>
              <path d="M131.6 241.1c3.2 3.2 9.9 1.7 14.9-3.2 4.8-4.8 6.2-11.5 3-14.7-3.3-3.4-10-2-14.9 2.9-4.9 5-6.4 11.7-3 15z" fill="#fff"/>
            </svg>
              <svg class="Servicerating-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
              <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
              <path d="M336.6 403.2c-6.5 8-16 10-25.5 5.2a117.6 117.6 0 0 0-110.2 0c-9.4 4.9-19 3.3-25.6-4.6-6.5-7.7-4.7-21.1 8.4-28 45.1-24 99.5-24 144.6 0 13 7 14.8 19.7 8.3 27.4z" fill="#3e4347"/>
              <path d="M276.6 244.3a79.3 79.3 0 1 1 158.8 0 79.5 79.5 0 1 1-158.8 0z" fill="#fff"/>
              <circle cx="340" cy="260.4" r="36.2" fill="#3e4347"/>
              <g fill="#fff">
                <ellipse transform="rotate(-135 326.4 246.6)" cx="326.4" cy="246.6" rx="6.5" ry="10"/>
                <path d="M231.9 244.3a79.3 79.3 0 1 0-158.8 0 79.5 79.5 0 1 0 158.8 0z"/>
              </g>
              <circle cx="168.5" cy="260.4" r="36.2" fill="#3e4347"/>
              <ellipse transform="rotate(-135 182.1 246.7)" cx="182.1" cy="246.7" rx="10" ry="6.5" fill="#fff"/>
            </svg>
              <svg class="Servicerating-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
        <path d="M407.7 352.8a163.9 163.9 0 0 1-303.5 0c-2.3-5.5 1.5-12 7.5-13.2a780.8 780.8 0 0 1 288.4 0c6 1.2 9.9 7.7 7.6 13.2z" fill="#3e4347"/>
        <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
        <g fill="#fff">
          <path d="M115.3 339c18.2 29.6 75.1 32.8 143.1 32.8 67.1 0 124.2-3.2 143.2-31.6l-1.5-.6a780.6 780.6 0 0 0-284.8-.6z"/>
          <ellipse cx="356.4" cy="205.3" rx="81.1" ry="81"/>
        </g>
        <ellipse cx="356.4" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347"/>
        <g fill="#fff">
          <ellipse transform="scale(-1) rotate(45 454 -906)" cx="375.3" cy="188.1" rx="12" ry="8.1"/>
          <ellipse cx="155.6" cy="205.3" rx="81.1" ry="81"/>
        </g>
        <ellipse cx="155.6" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347"/>
        <ellipse transform="scale(-1) rotate(45 454 -421.3)" cx="174.5" cy="188" rx="12" ry="8.1" fill="#fff"/>
      </svg>
              <svg class="Servicerating-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
              <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
              <path d="M232.3 201.3c0 49.2-74.3 94.2-74.3 94.2s-74.4-45-74.4-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b"/>
              <path d="M96.1 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2C80.2 229.8 95.6 175.2 96 173.3z" fill="#d03f3f"/>
              <path d="M215.2 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff"/>
              <path d="M428.4 201.3c0 49.2-74.4 94.2-74.4 94.2s-74.3-45-74.3-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b"/>
              <path d="M292.2 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2-77.8-65.7-62.4-120.3-61.9-122.2z" fill="#d03f3f"/>
              <path d="M411.3 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff"/>
              <path d="M381.7 374.1c-30.2 35.9-75.3 64.4-125.7 64.4s-95.4-28.5-125.8-64.2a17.6 17.6 0 0 1 16.5-28.7 627.7 627.7 0 0 0 218.7-.1c16.2-2.7 27 16.1 16.3 28.6z" fill="#3e4347"/>
              <path d="M256 438.5c25.7 0 50-7.5 71.7-19.5-9-33.7-40.7-43.3-62.6-31.7-29.7 15.8-62.8-4.7-75.6 34.3 20.3 10.4 42.8 17 66.5 17z" fill="#e24b4b"/>
            </svg>
              <svg class="Servicerating-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <g fill="#ffd93b">
                <circle cx="256" cy="256" r="256"/>
                <path d="M512 256A256 256 0 0 1 56.8 416.7a256 256 0 0 0 360-360c58 47 95.2 118.8 95.2 199.3z"/>
              </g>
              <path d="M512 99.4v165.1c0 11-8.9 19.9-19.7 19.9h-187c-13 0-23.5-10.5-23.5-23.5v-21.3c0-12.9-8.9-24.8-21.6-26.7-16.2-2.5-30 10-30 25.5V261c0 13-10.5 23.5-23.5 23.5h-187A19.7 19.7 0 0 1 0 264.7V99.4c0-10.9 8.8-19.7 19.7-19.7h472.6c10.8 0 19.7 8.7 19.7 19.7z" fill="#e9eff4"/>
              <path d="M204.6 138v88.2a23 23 0 0 1-23 23H58.2a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#45cbea"/>
              <path d="M476.9 138v88.2a23 23 0 0 1-23 23H330.3a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#e84d88"/>
              <g fill="#38c0dc">
                <path d="M95.2 114.9l-60 60v15.2l75.2-75.2zM123.3 114.9L35.1 203v23.2c0 1.8.3 3.7.7 5.4l116.8-116.7h-29.3z"/>
              </g>
              <g fill="#d23f77">
                <path d="M373.3 114.9l-66 66V196l81.3-81.2zM401.5 114.9l-94.1 94v17.3c0 3.5.8 6.8 2.2 9.8l121.1-121.1h-29.2z"/>
              </g>
              <path d="M329.5 395.2c0 44.7-33 81-73.4 81-40.7 0-73.5-36.3-73.5-81s32.8-81 73.5-81c40.5 0 73.4 36.3 73.4 81z" fill="#3e4347"/>
              <path d="M256 476.2a70 70 0 0 0 53.3-25.5 34.6 34.6 0 0 0-58-25 34.4 34.4 0 0 0-47.8 26 69.9 69.9 0 0 0 52.6 24.5z" fill="#e24b4b"/>
              <path d="M290.3 434.8c-1 3.4-5.8 5.2-11 3.9s-8.4-5.1-7.4-8.7c.8-3.3 5.7-5 10.7-3.8 5.1 1.4 8.5 5.3 7.7 8.6z" fill="#fff" opacity=".2"/>
            </svg>
            </div>
          </div>

      </div>
      </div>
     </div>
      </div>
        </div>
        <div class="col-md-11">
        <p class="explainass" style="text-align: left; color: red; margin-left: 5%;">Your rating is extremely important to us. Please notify us if there is a mistake so that we may make the work more efficient.</p>
        <div class="form-floating mb-3" style="margin-left: 5%;">
          <textarea class="form-control" placeholder="" id="feedbackAss" name="feedbackAss" style="height: 100px;"></textarea>
          <label for="feedbackAss">Feedback</label>
        </div>
        <button class="btn btn-success  float-end mt-3 mb-3" onclick="assessComplete(${ass_id})">Confirm</button>
      </div>
      
        

      `,  width: 700,
      padding: '1em',
        showCloseButton:true,
        showConfirmButton: false,
      });
    }
  );
  
  if (id != 0) {
  } else {
  }
}

function assessComplete(id) {
  let dataAPI = {
    feedbackAss: byId(`feedbackAss`).value,
    rating: byId(`rating-1`).checked ? 1 : (byId(`rating-2`).checked ? 2 : (byId(`rating-3`).checked ? 3 : (byId(`rating-4`).checked ? 4 : (byId(`rating-5`).checked ? 5 : 0)))),
    Servicerating: byId(`Servicerating-1`).checked ? 1 : (byId(`Servicerating-2`).checked ? 2 : (byId(`Servicerating-3`).checked ? 3 : (byId(`Servicerating-4`).checked ? 4 : (byId(`Servicerating-5`).checked ? 5 : 0)))),
    id: id,
  };
  
  if(dataAPI.rating!=0 && dataAPI.Servicerating!=0){
 Swal.fire({
    icon: 'warning',
    title: "Confirm Sent?",
    showCancelButton: true,
    confirmButtonText: "Confirm",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      connectApi("getdata/HistoryRequest", { type: "comAss", data: dataAPI, dataoption: 0 }, "", function (output) {
        console.log(output);
        if (output.status == 200) {
          Swal.fire({
            icon:'success',
            title:"Assessment Complete Thank you",
            confirmButtonText: "OK!",
          });
          getDataTicketComplete();
        }
      });
    }
  });
  }else{
    Swal.fire({
      icon: 'error',
      title: "Please rate us!",
      confirmButtonText: "OK",
    }).then((result) => {
      Assessment(id);
    });
  }
 
}




function getdataCardTypeSelect() {
  connectApi(
    "getdata/typeRequestSetting",
    { type: "forsetting", data: 0, dataoption: 0 },
    "",
    function (output) {
      console.log(output);
      if (output.status == 200) {
        let typeRequest = output.data;
        let htmltypeRequest = byId("typeSelect");

        htmltypeRequest.innerHTML = "";

        typeRequest.forEach((op) => {
          htmltypeRequest.innerHTML += `
             <option value="${op.type_id}">${op.type_name}</option>
           `;
        });

        console.log(typeRequest);
      } else {
      }
    }
  );
}

function createCardGuide(id){
  openModal('addCardGuide')
  byId(`body-addCardGuide`).innerHTML = `<div class="row p-2">
  <label class="mb-2">Select Type</label>
  <select class="form-select" aria-label="Default select example" id="typeSelect" name="">
  </select>
  <label class="mb-2 mt-2">Title</label>
  <input class="form-control" type="text" id="RqTitleCard" name="RqTitleCard">
  <label class="mb-2 mt-2">Description</label>
  <textarea class="form-control" type="text" id="RqDescCard" name="RqDescCard"
      row="5"></textarea>
  <label class="mb-2 mt-2">Solution</label>
  <textarea class="form-control" type="text" id="Solution" name="Solution" row="5"></textarea>
</div>`

getdataCardTypeSelect();



// createTextEditor('RqDescCard');
createTextEditor('Solution');

}


function getdataCardSetting() {
  connectApi(
    "getdata/sugestcardSetting",
    { type: "forguide", data: 0, dataoption: 0 },
    "tableCardcustom",
    function (output) {
      console.log(output);
      if (output.status == 200) {
        let typeRequest = output.data;
        let htmltypeRequest = byId("tbody-guideInfoCard");

        htmltypeRequest.innerHTML = "";

        typeRequest.forEach((scg) => {
          htmltypeRequest.innerHTML += `
          <tr>
          <th scope="row">${scg.guide_id}</th>
           <td>  <div class="d-flex gap-2 mt-1">
                      <div class="cardicon" style="background-color:${scg.type_color}">
                           <i class="${scg.type_icon}" ></i>
                      </div>
                      <p class="mt-1">${scg.type_name}</p>
                  </div>
           </td>
          <td>${scg.guide_title}</td>
      
          <td>
               <div class="d-flex gap-1 mt-1"><div class="form-check form-switch">
                     <input class="form-check-input" type="checkbox" role="switch" onchange="switchStatusCard(this,${scg.guide_status},${scg.guide_id})" id="flexSwitchCheckChecked" ${scg.guide_status == 1 ? `checked` : ``}>
               </div> 
                    <button class="btn btn-warning btn-sm" onclick="editGuideCard(${scg.guide_id})"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-danger btn-sm"  onclick="delCardSetting(${scg.guide_id})"><i class="bi bi-trash3-fill"></i></button>
          </div>
          </td>
          </tr>
           `;
        });
        setTable_DataTableNofilter('tableCardcustom')
        console.log(typeRequest);
      } else {
      }
    }
  );
}


function addGuideCard(id) {
  if (
    checkDataInputRequest([`typeSelect`,`RqTitleCard`,`RqDescCard`,`Solution`,])
    ) {
    let dataAPI = {
      typeSelect: byId(`typeSelect`).value,
      RqTitleCard: byId(`RqTitleCard`).value,
      RqDescCard: byId(`RqDescCard`).value,
      Solution: byId(`Solution`).value,
      id: id,
    };
    // console.log(dataAPI);
    Swal.fire({
      icon: "warning",
      title: "Confirm?",
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "Cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        connectApi("getdata/sugestcardSetting",{ type: "guidemanage", data: dataAPI, dataoption: 0 },"",
          function (output) {
            console.log(output);
            if (output.status == 200) {
              closeModal("addCardGuide");
              byId("RqTitleCard").value = "";
              byId("RqDescCard").value = "";
              byId("Solution").value = "";
            }
          }
        );
      }
    });
  }
}


function editGuideCard(id) {
  connectApi(
    "getdata/sugestcardSetting",
    { type: "view", data: id, dataoption: 0 },
    "",
    function (output) {
      console.log(output); 
      let edit_type = "";
      let edit_title = "";
      let edit_desc = "";
      let edit_solute = "";
      let type_id = "";
     
  let option = "";
      output.data.rqtype.forEach((opp) => {
        option += `<option value="${opp.type_id}">${opp.type_name}</option>`;
      });

      console.log(option)
      if (output.status == 200) {
        output.data.data.forEach((guide) => {
          edit_type = guide.guide_fortype;
          edit_title = guide.guide_title;
          edit_desc = guide.guide_description;
          edit_solute = guide.guide_solutions;
          type_id = guide.type_id;
        });
      }
    
      Swal.fire({
        title:'Edit Guide Card' ,
        html: `
        <div class="container">
        <div class="row p-2">
          <div class="col-lg-12">
            <label class="mb-2 float-start" for="edittypeSelect" >Select Type</label>
            <select class="form-select" id="edittypeSelect" name="typeSelect" aria-label="Default select example">
               ${option}
            </select>
          </div>
        </div>
        <div class="row p-2">
          <div class="col-lg-12">
            <label class="mb-2 mt-2 float-start" for="editRqTitleCard">Title</label>
            <input class="form-control" type="text" id="editRqTitleCard" name="RqTitleCard" value="${edit_title}">
          </div>
        </div>
        <div class="row p-2">
          <div class="col-lg-12">
            <label class="mb-2 mt-2 float-start" for="editRqDescCard">Description</label>
            <textarea class="form-control" type="text" id="editRqDescCard" name="RqDescCard" rows="5">${edit_desc}</textarea>
          </div>
        </div>
        <div class="row p-2">
          <div class="col-lg-12 float-start">
            <label class="mb-2 mt-2" for="editSolution">Solution</label>
            <textarea class="form-control" type="text" id="editSolution" name="Solution" rows="5">${edit_solute}</textarea>
          </div>
        </div>
        <div class="row p-2">
          <div class="col-lg-12">
            <button type="button" class="btn btn-primary float-end" onclick="updateguidecard(${id})">${id != 0 ? 'Update' : 'Add'}</button>
          </div>
        </div>
      </div>
      `,
        padding: '1em',
        width: 1000,
        showCloseButton: true,
        showConfirmButton: false,
      });
      // getdataCardTypeSelect() 
      createTextEditor('editSolution');
    }
  );

  if (id != 0) {
    // Code for handling the ID case
  } else {
  }
}

function updateguidecard(id) {
  console.log(id)
  if (checkDataInputRequest([`edittypeSelect`,`editRqTitleCard`,`editRqDescCard`,`editSolution`])) {
    let dataAPI = {
      typeSelect: byId(`edittypeSelect`).value,
      RqTitleCard: byId(`editRqTitleCard`).value,
      RqDescCard: byId(`editRqDescCard`).value,
      Solution: byId(`editSolution`).value,
      id: id
    };
    console.log(dataAPI)
    Swal.fire({
      icon: "warning",
      title: "Save Change?",
      showCancelButton: true,
      confirmButtonText: "Confirm",
      cancelButtonText: "Cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        connectApi(
          "getdata/sugestcardSetting",
          { type: "guidemanage", data: dataAPI, dataoption: 0 },
          "",
          function (output) {
            console.log(output);
            if (output.status == 200) {
              getdataCardSetting();
            }
          }
        );
      }
    });
  } else{
    let dataAPI = {
      typeSelect: byId(`edittypeSelect`).value,
      RqTitleCard: byId(`editRqTitleCard`).value,
      RqDescCard: byId(`editRqDescCard`).value,
      Solution: byId(`editSolution`).value,
      id: id
    };
    console.log(dataAPI)
  } 
}

function switchStatusCard(e, oldId, id) {
  ChangeStatusTo(
    "it_request_guide","guide_status",oldId == 1 ? 0 : 1,"guide_id",id
  );
  e.setAttribute("onchange",`switchStatusCard(this,${oldId == 1 ? 0 : 1}),${id}`
  );
}


function delCardSetting(id) {
  Swal.fire({
    icon:'warning',
    title: "Sure you want to delete?",
    showCancelButton: true,
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    padding: '1em' ,
  }).then((result) => {
    if (result.isConfirmed) {
      ChangeStatusTo("it_request_guide", "guide_status", 9, "guide_id", id);
      getdataCardSetting();
      location.reload(); // Reload the page
    }
  });
}



function  getTextEditorDesc() {
  byId(`problemDescedit`).innerHTML = `
  <div class="col-md-12">
  <label class="mt-4 mb-3"><i class="bi bi-arrow-return-right"></i> Problem Description 
  <label style="color:red">&#42;</label>
  </label>
  <textarea class="form-control"  name="prob_desc" id="problem-desc" required rows="5"></textarea>
</div>`

createTextEditor('problem-desc');

}

