function validateForm() {
  document.getElementById("itemcode-error").innerHTML = "";
  document.getElementById("item-name-error").innerHTML = "";
  document.getElementById("item-category-error").innerHTML = "";
  document.getElementById("item-subcategory-error").innerHTML = "";
  document.getElementById("quantity-error").innerHTML = "";
  document.getElementById("unit_price-error").innerHTML = "";

  let itemCode = document.forms["add_customer"]["item_code"].value;
  let itemName = document.forms["add_customer"]["item_name"].value;
  let itemCategory = document.forms["add_customer"]["item_category"].value;
  let itemSubcategory =
    document.forms["add_customer"]["item_subcategory"].value;
  let quantity = document.forms["add_customer"]["quantity"].value;
  let unitPrice = document.forms["add_customer"]["unit_price"].value;

  let isValid = true;

  if (itemCode === "") {
    document.getElementById("itemcode-error").innerHTML =
      "Item code is required.";
    isValid = false;
  }

  if (itemName === "") {
    document.getElementById("item-name-error").innerHTML =
      "Item name is required.";
    isValid = false;
  }

  if (itemCategory === "") {
    document.getElementById("item-category-error").innerHTML =
      "Item category is required.";
    isValid = false;
  }

  if (itemSubcategory === "") {
    document.getElementById("item-subcategory-error").innerHTML =
      "Item subcategory is required.";
    isValid = false;
  }

  if (quantity === "") {
    document.getElementById("quantity-error").innerHTML =
      "Quantity is required.";
    isValid = false;
  } else if (isNaN(quantity) || quantity <= 0) {
    document.getElementById("quantity-error").innerHTML =
      "Quantity must be a positive number.";
    isValid = false;
  }

  if (unitPrice === "") {
    document.getElementById("unit_price-error").innerHTML =
      "Unit price is required.";
    isValid = false;
  } else if (isNaN(unitPrice) || unitPrice <= 0) {
    document.getElementById("unit_price-error").innerHTML =
      "Unit price must be a positive number.";
    isValid = false;
  }

  return isValid;
}
