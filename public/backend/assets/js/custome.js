document.addEventListener("DOMContentLoaded", function () {

    let productSearchInput = document.getElementById("product_search");
    let warehouseDropdown = document.getElementById("warehouse_id");
    let supplierDropdown = document.getElementById("supplier_id");
    let productList = document.getElementById("product_list");
    let warehouseError = document.getElementById("warehouse_error");
    let orderItemsTableBody = document.querySelector("tbody");

    /* ================= PRODUCT SEARCH ================= */

    if (productSearchInput) {
        productSearchInput.addEventListener("keyup", function () {

            let query = this.value;
            let warehouse_id = warehouseDropdown?.value;
            let supplier_id = supplierDropdown?.value || null;

            if (!warehouse_id) {
                warehouseError?.classList.remove('d-none');
                productList.innerHTML = "";
                return;
            } else {
                warehouseError?.classList.add('d-none');
            }

            if (query.length > 1) {
                fetchProducts(query, warehouse_id, supplier_id);
            } else {
                productList.innerHTML = "";
            }
        });
    }

    function fetchProducts(query, warehouse_id, supplier_id) {

        let url = productSearchUrl + "?query=" + query + "&warehouse_id=" + warehouse_id;

        if (supplier_id) {
            url += "&supplier_id=" + supplier_id;
        }

        fetch(url)
            .then(res => res.json())
            .then(data => {

                productList.innerHTML = "";

                if (data.length > 0) {
                    data.forEach(product => {

                        let item = `
                        <a href="#" class="list-group-item list-group-item-action product-item"
                            data-id="${product.id}"
                            data-code="${product.code}"
                            data-name="${product.name}"
                            data-cost="${product.price}"
                            data-stock="${product.product_qty}">
                            ${product.code} - ${product.name}
                        </a>`;

                        productList.innerHTML += item;
                    });

                    document.querySelectorAll(".product-item").forEach(item => {
                        item.addEventListener("click", function (e) {
                            e.preventDefault();
                            addProductToTable(this);
                        });
                    });

                } else {
                    productList.innerHTML = '<p class="text-muted">No Product Found</p>';
                }
            });
    }

    /* ================= ADD PRODUCT ================= */

    function addProductToTable(el) {

        let id = el.dataset.id;
        let name = el.dataset.name;
        let code = el.dataset.code;
        let cost = parseFloat(el.dataset.cost);
        let stock = parseInt(el.dataset.stock);

        if (document.querySelector(`tr[data-id="${id}"]`)) {
            alert("Already added");
            return;
        }

        let row = `
        <tr data-id="${id}">
            <td>${code} - ${name}</td>
            <td>${cost.toFixed(2)}</td>
            <td>${stock}</td>
            <td>
                <input type="number" class="qty-input" value="1" min="1" max="${stock}" data-cost="${cost}">
            </td>
            <td>
                <input type="number" class="discount-input" value="0">
            </td>
            <td class="subtotal">${cost.toFixed(2)}</td>
            <td><button class="remove-product">X</button></td>
        </tr>`;

        orderItemsTableBody.innerHTML += row;
        productList.innerHTML = "";
        productSearchInput.value = "";

        updateEvents();
        updateGrandTotal();
    }

    /* ================= EVENTS ================= */

    function updateEvents() {

        document.querySelectorAll(".qty-input, .discount-input").forEach(input => {
            input.oninput = function () {
                let row = this.closest("tr");

                let qty = parseFloat(row.querySelector(".qty-input").value) || 1;
                let cost = parseFloat(row.querySelector(".qty-input").dataset.cost) || 0;
                let discount = parseFloat(row.querySelector(".discount-input").value) || 0;

                let subtotal = (cost * qty) - discount;

                row.querySelector(".subtotal").innerText = subtotal.toFixed(2);

                updateGrandTotal();
            };
        });

        document.querySelectorAll(".remove-product").forEach(btn => {
            btn.onclick = function () {
                this.closest("tr").remove();
                updateGrandTotal();
            };
        });
    }

    /* ================= TOTAL ================= */

    function updateGrandTotal() {

        let total = 0;

        document.querySelectorAll(".subtotal").forEach(el => {
            total += parseFloat(el.textContent) || 0;
        });

        let discount = parseFloat(document.getElementById("inputDiscount")?.value) || 0;
        let shipping = parseFloat(document.getElementById("inputShipping")?.value) || 0;

        total = total - discount + shipping;
        if (total < 0) total = 0;

        document.getElementById("grandTotal").innerText = total.toFixed(2);
        document.querySelector("input[name='grand_total']").value = total.toFixed(2);

        updateDueAmount();
    }

    /* ================= DUE ================= */

    function updateDueAmount() {

        let total = parseFloat(document.querySelector("input[name='grand_total']")?.value) || 0;
        let paid = parseFloat(document.querySelector("input[name='paid_amount']")?.value) || 0;
        let full = parseFloat(document.querySelector("input[name='full_paid']")?.value) || 0;

        let due = total - (paid + full);
        if (due < 0) due = 0;

        document.getElementById("dueAmount").innerText = due.toFixed(2);
        document.querySelector("input[name='due_amount']").value = due.toFixed(2);
    }

    /* ================= SAFE EVENT BIND ================= */

    function bindStaticEvents() {

        let discount = document.getElementById("inputDiscount");
        let shipping = document.getElementById("inputShipping");
        let paid = document.querySelector("input[name='paid_amount']");
        let full = document.querySelector("input[name='full_paid']");

        if (discount) discount.oninput = updateGrandTotal;
        if (shipping) shipping.oninput = updateGrandTotal;
        if (paid) paid.oninput = updateDueAmount;
        if (full) full.oninput = updateDueAmount;
    }

    bindStaticEvents();

});