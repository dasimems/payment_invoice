window.addEventListener("load", ()=>{
    var addInvoiceBtn = Ele(".action-btn-container");

    var invoiceCountInput = Ele(".invoice-details-count");

    addInvoiceBtn.addEventListener("click", ()=>{

        
        var invoiceCount = Ele(".invoice-details-count").value;

        var invoiceFormHtml = `<h4 class="form-inner-title full-width">Invoice Details - #${(parseInt(invoiceCount) + 2)}</h4>

                <div class="form-content half-width">
                    
                    <label for="invoice-price-${(parseInt(invoiceCount) + 1)}" data-name="invoice-price-${(parseInt(invoiceCount) + 1)}">Price</label>
                    <input type="number" name="invoice-price[]" id="invoice-price-${(parseInt(invoiceCount) + 1)}" placeholder="Price" data-name="invoice-price-${(parseInt(invoiceCount) + 1)}" data-name-err="" data-required-err="This field is required" data-min-err="" data-max-err="" data-regex-err="" data-regex="" data-min="" data-max="" data-required="true" >
                    <p class="form-err" data-name="invoice-price-${(parseInt(invoiceCount) + 1)}">
                        this is an error
                    </p>
                </div>

                <div class="form-content half-width">
                    
                    <label for="invoice-quantity-${(parseInt(invoiceCount) + 1)}" data-name="invoice-quantity-${(parseInt(invoiceCount) + 1)}">Quantity</label>
                    <input type="number" name="invoice-quantity[]" id="invoice-quantity-${(parseInt(invoiceCount) + 1)}" placeholder="Quantity" data-name="invoice-quantity-${(parseInt(invoiceCount) + 1)}" data-name-err="" data-required-err="This field is required" data-min-err="" data-max-err="" data-regex-err="" data-regex="" data-min="" data-max="" data-required="true" >
                    <p class="form-err" data-name="invoice-quantity-${(parseInt(invoiceCount) + 1)}">
                        this is an error
                    </p>
                </div>

                <div class="form-content full-width">
                    
                    <label for="invoice-description[]" data-name="invoice-description-${(parseInt(invoiceCount) + 1)}">Description</label>
                    
                    <textarea type="number" name="invoice-description-${(parseInt(invoiceCount) + 1)}" id="invoice-description-${(parseInt(invoiceCount) + 1)}" placeholder="Description..." data-name="invoice-description-${(parseInt(invoiceCount) + 1)}" data-name-err="" data-required-err="This field is required" data-min-err="" data-max-err="" data-regex-err="" data-regex="" data-min="" data-max="100" data-required="true" ></textarea>
                    <p class="form-err" data-name="invoice-description-${(parseInt(invoiceCount) + 1)}">
                        this is an error
                    </p>
                </div>`;

        addInvoiceBtn.insertAdjacentHTML("beforebegin", invoiceFormHtml)
        invoiceCountInput.value = (parseInt(invoiceCount) + 1)

        addInputEventListener();
    })
})