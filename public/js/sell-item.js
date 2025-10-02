  const unitPrice = 3933.74; // base price for one item
    const itemsContainer = document.getElementById("itemsContainer");
    const addItemBtn = document.getElementById("addItemBtn");

    // Function to update price for a row
    function updatePrice(row) {
      let qtyInput = row.querySelector(".quantity");
      let priceBox = row.querySelector(".price-box");
      let qty = parseInt(qtyInput.value);
      let total = unitPrice * qty;
      priceBox.textContent = "£" + total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    // Function to attach event listeners to a row
    function attachRowEvents(row) {
      const minusBtn = row.querySelector(".minusBtn");
      const plusBtn = row.querySelector(".plusBtn");
      const qtyInput = row.querySelector(".quantity");

      minusBtn.addEventListener("click", () => {
        let val = parseInt(qtyInput.value);
        if (val > 1) {
          qtyInput.value = val - 1;
          updatePrice(row);
        }
      });

      plusBtn.addEventListener("click", () => {
        let val = parseInt(qtyInput.value);
        qtyInput.value = val + 1;
        updatePrice(row);
      });


      updatePrice(row); // initialize price
    }

    // Attach events to the first row
    /*document.querySelectorAll(".item-row").forEach(row => attachRowEvents(row));

    // Add new item row (only data, not headers)
    addItemBtn.addEventListener("click", () => {
      let newRow = document.querySelector(".item-row").cloneNode(true);
      newRow.querySelector(".quantity").value = 1;
      newRow.querySelector(".price-box").textContent = "£3,933.74";
      itemsContainer.appendChild(newRow);
      attachRowEvents(newRow);
    });*/