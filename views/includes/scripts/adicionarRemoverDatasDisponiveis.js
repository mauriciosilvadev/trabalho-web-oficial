var inputAppend = `
    <div class="d-flex" id="data$">
      <input type="date" onchange="validarData()" name="datas[]" class="form-control mb-2 data_input">
      <button type="button" onclick="removeDate($)" class="mb-2 btn btn-outline-danger mx-1" style="min-width: 100px;">Remover</button>
    </div>
  `;

  const divDateInput = document.querySelector("#datas");

  function addDate() {
    const lenghtDateInput = divDateInput.querySelectorAll("input").length;
    if (lenghtDateInput < 7) {
      divDateInput.insertAdjacentHTML("beforeend", inputAppend.replaceAll('$', lenghtDateInput));
    }
  }

  function removeDate(index) {
    divDateInput.querySelector("#data" + index).remove();

    divDateInput.querySelectorAll("div:has(input[type='date'])").forEach((item, index) => {
      item.id = "data" + index;
      item.querySelector("button").setAttribute("onclick", `removeDate(${index})`);
      item.querySelector("input").id = "data_input_" + index;
      item.querySelector("input").setAttribute("onblur", `validarData('data_input_${index}')`);
    })

    validarData();
  }