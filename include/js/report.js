window.addEventListener("load", () => {
  const input = document.getElementById("AttachmentRequest");
  const filewrapper = document.getElementById("filewrapper");

  input.addEventListener("change", (e) => {
    let filewrapper = byId("filewrapper");
    filewrapper.innerHTML = `<h5 class="uploaded">Uploaded Documents</h5>`;
    let fileData = e.target.files;
    console.log(fileData);
    for (let f = 0; f < fileData.length; f++) {
      let file = fileData[f];
      let fileName = file.name;
      let filetype = e.target.value.split(".").pop();
      console.log(filetype);
      fileshow(fileName, filetype);
    }
    // fileData.forEach(file=>{
    //   console.log(file)
    // })
  });

  const fileshow = (fileName, filetype) => {
    const showfileboxElem = document.createElement("div");
    showfileboxElem.classList.add("showfilebox");
    const leftElem = document.createElement("div");
    leftElem.classList.add("left");
    // const fileTypeElem = document.createElement("span");
    // fileTypeElem.classList.add("filetype");
    // fileTypeElem.innerHTML = filetype;
    // leftElem.append(fileTypeElem);
    const filetitleElem = document.createElement("div");
    filetitleElem.classList.add('custimTextFile__1');
    filetitleElem.setAttribute('title',`${fileName}`);
    filetitleElem.innerHTML = fileName;
    leftElem.append(filetitleElem);
    showfileboxElem.append(leftElem);
    const rightElem = document.createElement("div");
    rightElem.classList.add("right");
    showfileboxElem.append(rightElem);
    const crossElem = document.createElement("span");
    crossElem.innerHTML = "&#215;";
    rightElem.append(crossElem);
    filewrapper.append(showfileboxElem);

    crossElem.addEventListener("click", () => {
      filewrapper.removeChild(showfileboxElem);
    });
  };
});


function  SelectDuedate() {
  var rqurgent = document.getElementsByName('rqurgent');
  var divUrgentDate = document.getElementById('div-urgentDate');

  // Add event listener to radio buttons
  for (var i = 0; i < rqurgent.length; i++) {
      rqurgent[i].addEventListener('change', function() {
          if (this.value === '1') {
              divUrgentDate.style.display = 'block';
          } else {
              divUrgentDate.style.display = 'none';
          }
      });
  }

  // Check initial state on page load
  var checkedButton = document.querySelector('input[name="rqurgent"]:checked');
  if (checkedButton && checkedButton.value === '1') {
      divUrgentDate.style.display = 'block';
  } 
}

function submit_ReportProblem() {
  // console.log(1)
  let type = FindAll(`.type_problem:checked`);

  let typeID = 0;
  type.forEach((typeSelect) => {
    typeID = typeSelect.dataset.type;
  });
  if(typeID==0){
    Swal.fire({
      icon:'error',
      title:"Please select type and fill form",
      confirmButtonText: "OK"
    })
  }else{

  
  if (checkDataInputRequest([`problem-desc`, `problem`])) {
    // Swal.fire({
    // 	icon: "success",
    // 	title: "ดำเนินการสำเร็จ",
    // 	confirmButtonText: 'ตกลง'
    // }).then((result) => {
         console.log(byId(`urgentDate`).value)
        console.log( $(`#selectAnotherEmp`).val())
        console.log(moment(byId(`urgentDate`).value).format('Y-M-d'))
        // })

    Swal.fire({
      icon:'warning',
      title:"Create Ticket?",
      padding:'1em',
      showCancelButton: true,
      confirmButtonText: "Confirm",
      cancelButtonText: "Cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        const formData = new FormData();
        formData.append("typeID", typeID);
        formData.append("problem", byId(`problem`).value);
        formData.append("problem-desc", byId(`problem-desc`).value);
        formData.append("rqurgent", byId(`rqurgent`).checked==true?1:0);
        formData.append("urgentDate", byId(`urgentDate`).value);
        formData.append("ticketOt", byId(`ticketOt`).checked==true?1:0);
        formData.append("selectAnotherEmp", $(`#selectAnotherEmp`).val());

        byId('App-formrequest').classList.add('ui','form','loading')

        let AttachmentRequest = byId(`AttachmentRequest`);
        let dataFile = AttachmentRequest.files;
        for (let f = 0; f < dataFile.length; f++) {
          let file = dataFile[f];
          formData.append("files[]", file);
        }
        fetch("./include/php/request.php", {
          method: "POST",
          body: formData,
        })
          .then(function (response) {
            console.log(response);
            return response.json();
          })
          .then(function (responseData) {
            console.log(responseData);
            if (responseData.status == 200) {
              // upload Success
              Swal.fire({
                icon:'success',
                title:"Complete",
                confirmButtonText: "Close",
              }).then((result) => {
                byId('App-formrequest').classList.remove('ui','form','loading')

                location.reload();
                // window.location = `?page=managequestion&token=${byId('stage_token').value}`;
              });
            }
          })
        // .catch((err) => console.log(err));
      }
    });
  }
}
  // console.log(type);
}


