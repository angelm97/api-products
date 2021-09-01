var url = "http://localhost/api-inventario/api/";

$(document).ready(function () {
  getItems();
});

$("#add").click(function () {
  if (
    $("#name").val() != "" &&
    $("#price").val() != "" &&
    $("#stock").val() != ""
  ) {
    var data = {
      nombre: $("#name").val(),
      precio: $("#price").val(),
      stock: $("#stock").val(),
    };

    $.post(url, data, function (data, status) {
      $("#tr").after(
        `<tr id="element${data}">
            <td>${$("#name").val()}</td>   
            <td>${$("#price").val()}</td>     
            <td>${$("#stock").val()}</td>  
            <td>    
                <button class="edit" onclick="editItem(${data}, '${$(
          "#name"
        ).val()}', ${$("#price").val()}, ${$("#stock").val()})">Edit</button>
                <button class="delete" onclick="deleteItem(${data})">Delete</button>
            </td> 
        </tr>`
      );
      $("form")[0].reset();
    });
  } else {
    alert("Name, Price and Stock are required!");
  }
});

function getItems() {
  $.get(url, function (data, status) {
    var products = Object.values(data);
    products.forEach((element) => {
      if (element != "No products found") {
        element.precio = new Intl.NumberFormat().format(element.precio);
        $("table").append(
          `<tr id="element${element.id}">
            <td>${element.nombre}</td>   
            <td>${element.precio}</td>     
            <td>${element.stock}</td> 
            <td>    
                <button class="edit" onclick="editItem(${element.id}, '${element.nombre}', ${element.precio}, ${element.stock})">Edit</button>
                <button class="delete" onclick="deleteItem(${element.id})">Delete</button>
            </td>  
        </tr>`
        );
      }
    });
  });
}

function editItem(productId, name, price, stock) {
  $("#updateBtn").remove();
  $("#name").val(name);
  $("#price").val(price);
  $("#stock").val(stock);

  $("#add").after(
    `<div id="updateBtn">
        <button id="update" onclick="btnUpdate(${productId})">Update</button>
        <button id="cancel"  onclick="btnCancel()">Cancel</button>
    </div>`
  );

  $("#add").hide();
}

function deleteItem(productId) {
  var data = {
    method: "DELETE",
    id: productId,
  };

  $.post(url, data, function (data, status) {
    $("#element" + productId).remove();
  });

  btnCancel();
}

function btnUpdate(productId) {
  if (
    $("#name").val() != "" &&
    $("#price").val() != "" &&
    $("#stock").val() != ""
  ) {
    var data = {
      method: "PUT",
      id: productId,
      nombre: $("#name").val(),
      precio: $("#price").val(),
      stock: $("#stock").val(),
    };

    $.post(url, data, function (data, status) {
      $("#element" + productId).html(`
            <td>${$("#name").val()}</td>   
            <td>${$("#price").val()}</td>     
            <td>${$("#stock").val()}</td> 
            <td>    
                <button class="edit" onclick="editItem(${productId}, '${$("#name").val()}', ${$("#price").val()}, ${$("#stock").val()})">Edit</button>
                <button class="delete" onclick="deleteItem(${productId})">Delete</button>
            </td>`);
      $("form")[0].reset();
      btnCancel();
    });
    
  } else {
    alert("Name, Price and Stock are required!");
  }
}

function btnCancel() {
  $("#updateBtn").remove();
  $("form")[0].reset();
  $("#add").show();
}
