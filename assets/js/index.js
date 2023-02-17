"use strict";
function Ele(element){
    if(document.querySelector(element)){
        return document.querySelector(element);
    }else{
        return false
    }
}

function All(element){
    if(document.querySelector(element)){
        return document.querySelectorAll(element);
    }else{
        return []
    }
}

function showFormElement(element){
    var formElements = All(".option-container");
    var formButtonElements = All(".form-change-btn");

    if(element && Ele("." + element)){

        formElements.forEach(elementContainer => {
            
            if(elementContainer.classList.contains(element)){
                elementContainer.classList.add("active-option")
            }else{
                elementContainer.classList.remove("active-option")

            }
        })

        formButtonElements.forEach(button => {
            if(button.getAttribute("data-content") === element){
                button.classList.add("active-button")
            }else{
                button.classList.remove("active-button")

            }
        })



    }
}


function showFormErr(dataName, message, removeErr){
    var inputs = [...All("input"), ...All("textarea")];
    var formErr = All(".form-err");
    var formLabels = All("label");

    if(dataName && !removeErr){

        inputs.forEach(inp => {
            if(inp.getAttribute("data-name") === dataName){
                inp.classList.add("input-err");
            }
        })
    
        formLabels.forEach(inp => {
            if(inp.getAttribute("data-name") === dataName){
                inp.classList.add("label-err");
            }
        })
    
        formErr.forEach(inp => {
            if(inp.getAttribute("data-name") === dataName){
                inp.classList.add("shown-err");

                if(message && message!==""){

                    inp.textContent = message;
                }else{
                    
                    inp.textContent = "Please input the correct information in this field";
                }
            }
        })
    }

    if(removeErr){

        inputs.forEach(inp => {
            if(inp.getAttribute("data-name") === dataName){
                inp.classList.remove("input-err");
            }

            if(inp.getAttribute("type") === "file"){

                formLabels.forEach(label => {
                    if(label.getAttribute("data-name") === dataName){
                        label.innerText = message;
                    }
                })

            }
        })
    
        formLabels.forEach(inp => {
            if(inp.getAttribute("data-name") === dataName){
                inp.classList.remove("label-err");
            }
        })
    
        formErr.forEach(inp => {
            if(inp.getAttribute("data-name") === dataName){
                inp.classList.remove("shown-err");
                inp.textContent = "";
            }
        })

    }



}

function submitFormValidation(form){
    
    if(form){
        
        var inputs = [...form.target.elements];
        var action = form.target.getAttribute("action");
        var method = form.target.getAttribute("method");
        var data = {};
        var checkArr = [];
        

        inputs.forEach(inputElement => {

            var dataName = inputElement.getAttribute("data-name");
            var regex = inputElement.getAttribute("data-regex")
            var dataMin = inputElement.getAttribute("data-min")
            var generalErr = inputElement.getAttribute("data-name-err")
            var dataMaxSize = inputElement.getAttribute("data-max-size")
            var dataMinSize = inputElement.getAttribute("data-min-size")
            var dataType = inputElement.getAttribute("data-type")
            var dataMax = inputElement.getAttribute("data-max")
            var dataRequired = inputElement.getAttribute("data-required") || inputElement.getAttribute("required")
            var message = "";

            if(generalErr && generalErr !== ""){
                message =  generalErr;
            }

            if(inputElement.getAttribute("type") !== "file"){

                var val = inputElement.value.trim();

                if((dataRequired && val === "") || (regex && regex !== "" && !new RegExp(regex).test(val)) || (dataMin && dataMin !== "" && val.length < parseInt(dataMin)) || (dataMax && dataMax !== "" && val.length > parseInt(dataMax))){

                    if(dataRequired && val === ""){
    
                        var newErr = inputElement.getAttribute("data-required-err") || inputElement.getAttribute("required-err")
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "This field is required";
                        }
    
                    }else if(regex && regex !== "" && !new RegExp(regex).test(val)){
    
                        var newErr = inputElement.getAttribute("data-regex-err")
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "Please provide a valid Input"
                        }
                    } else if(dataMin && dataMin !== "" && val.length < parseInt(dataMin)){
    
                        var newErr = inputElement.getAttribute("data-min-err")
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "Character length must not be less than " + dataMin + " characters";
                        }
                    } else if(dataMax && dataMax !== "" && val.length > parseInt(dataMax)){
    
                        var newErr = inputElement.getAttribute("data-max-err")
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                           
                            message = "Character length must not be more than " + dataMax + " characters";
                        }
                    }
    
                    showFormErr(dataName, message);

                    if(inputElement.tagName.toLowerCase() !== "button" && inputElement.type !== "submit"){

                        checkArr.push(false);
                    }else{
                        
                        checkArr.push(true);
                    }
                    
                    
                }else{
                    
                    checkArr.push(true);
                    showFormErr(dataName, "", true)
                    data[dataName] = val;

                    if(checkArr.length === inputs.length && !checkArr.includes(false)){

                        form.returnValue  = true;
                        form.defaultPrevented  = false;

                    }
                }
            
            }else{

                var fileTypePassed = false,
                    maxSizePassed = false,
                    minSizePassed = false,
                    type = "",
                    fileLengthExceeded = false,
                    neededDataTypes = [];


                if(inputElement.getAttribute("type") === "file"){
                    type = "file";

                    if(dataMax && dataMax !== ""){

                        if(inputElement.files.length > dataMax){

                            fileLengthExceeded = true

                        }
                    }

                    if(dataType && dataType !== ""){

                        var checkDataType = (dataType.replace(/\[|\"|\'|\]/g,'').split(',')).map(data => data.trim());
                        
                        var uploadedDataTypes = ([...inputElement.files].map(file => file.type))

                        uploadedDataTypes.forEach(data => {
                            if(checkDataType.includes(data)){
                                neededDataTypes.push(true)
                            }else{
                                neededDataTypes.push(false)
                            }
                        })


                        if(uploadedDataTypes.length === neededDataTypes.length && !neededDataTypes.includes(false)){
                            fileTypePassed = true;
                        }

                        

                    }

                    
                    if(dataMaxSize && dataMaxSize !== ""){

                        dataMaxSize = (dataMaxSize * 1000000)


                         var uploadedDataSizes = ([...inputElement.files].map(file => file.size));

                         var outlaws = uploadedDataSizes.filter(sizes => sizes > dataMaxSize);


                         if(outlaws.length > 0){
                            maxSizePassed = true
                         }

                    }

                    if(dataMinSize && dataMinSize !== ""){

                         dataMinSize = (dataMinSize * 1000000)

                         var uploadedDataSizes = ([...inputElement.files].map(file => file.size));

                         var outlaws = uploadedDataSizes.filter(sizes => sizes < dataMinSize);

                         if(outlaws.length > 0){
                            minSizePassed = true
                         }


                    }

                }

                var val = inputElement.value.trim();

                if((dataRequired && val === "") || (type === "file" && fileLengthExceeded) || (dataMaxSize && dataMaxSize !== "" && maxSizePassed) || (dataMinSize && dataMinSize !== "" && minSizePassed) || (dataType && dataType !== "" && !fileTypePassed)){
                    

                    if(dataRequired && val === ""){
    
                        var newErr = inputElement.getAttribute("data-required-err") || inputElement.getAttribute("required-err")
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "This field is required";
                        }
    
                    }else if(type === "file" && fileLengthExceeded){

                        var newErr = inputElement.getAttribute("data-max-err")
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "You can't select more than " + dataMax + " files";
                        }

                    }else if(dataType && dataType !== "" && !fileTypePassed){

                        var newErr = inputElement.getAttribute("data-type-err");
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "The file selected is an invalid file format";
                        }

                        
                    }else if(dataMaxSize && dataMaxSize !== "" && maxSizePassed){

                        var newErr = inputElement.getAttribute("data-max-size-err");
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "The file selected too large";
                        }


                    }else if(dataMinSize && dataMinSize !== "" && minSizePassed){

                        var newErr = inputElement.getAttribute("data-min-size-err");
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "The file selected too small";
                        }


                    }

                    
                    showFormErr(dataName, message)

                    if(inputElement.tagName.toLowerCase() !== "button" && inputElement.type !== "submit"){

                        checkArr.push(false);
                    }else{
                        
                        checkArr.push(true);
                    }
                            
                            
                }else{
                    
                    checkArr.push(true);
                    showFormErr(dataName, "", true)
                    data[dataName] = val;

                    
                }

            }

        })


        if(checkArr.includes(false)){
                    
            form.preventDefault();

        }
    }

}

function addInputEventListener(){

    
    var inputFields = [...All("input"), ...All("textarea")];

    inputFields.forEach(inputElement => {
        var dataName = inputElement.getAttribute("data-name");
        var regex = inputElement.getAttribute("data-regex")
        var dataMin = inputElement.getAttribute("data-min")
        var generalErr = inputElement.getAttribute("data-name-err")
        var dataMaxSize = inputElement.getAttribute("data-max-size")
        var dataMinSize = inputElement.getAttribute("data-min-size")
        var dataType = inputElement.getAttribute("data-type")
        var dataMax = inputElement.getAttribute("data-max")
        var dataRequired = inputElement.getAttribute("data-required") || inputElement.getAttribute("required")
        var message = "";

        


        if(generalErr && generalErr !== ""){
            message = generalErr;
        }

        if(inputElement.getAttribute("type") !== "file"){

            inputElement.addEventListener("input", (e)=>{

                var val = e.target.value.trim();

                if((dataRequired && val === "") || (regex && regex !== "" && !new RegExp(regex).test(val)) || (dataMin && dataMin !== "" && val.length < parseInt(dataMin)) || (dataMax && dataMax !== "" && val.length > parseInt(dataMax))){

                    if(dataRequired && val === ""){
    
                        var newErr = inputElement.getAttribute("data-required-err") || inputElement.getAttribute("required-err")
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "This field is required";
                        }
    
                    }else if(regex && regex !== "" && !new RegExp(regex).test(val)){

                        
    
                        var newErr = inputElement.getAttribute("data-regex-err")
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "Please provide a valid Input"
                        }
                    } else if(dataMin && dataMin !== "" && val.length < parseInt(dataMin)){
    
                        var newErr = inputElement.getAttribute("data-min-err")
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "Character length must not be less than " + dataMin + " characters";
                        }
                    } else if(dataMax && dataMax !== "" && val.length > parseInt(dataMax)){
    
                        var newErr = inputElement.getAttribute("data-max-err")
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                           
                            message = "Character length must not be more than " + dataMax + " characters";
                        }
                    }
    
                    showFormErr(dataName, message);

                }else{
                    
                    showFormErr(dataName, "", true)
                    return true;
                    
                }




            })
            
        }else{

            inputElement.addEventListener("change", (e)=>{

                var fileTypePassed = false,
                    maxSizePassed = false,
                    minSizePassed = false,
                    type = "",
                    fileLengthExceeded = false,
                    neededDataTypes = [],
                    fileLength= 0;


                if(inputElement.getAttribute("type") === "file"){
                    type = "file";
                    
                    fileLength = inputElement.files.length;

                    if(dataMax && dataMax !== ""){

                        if(inputElement.files.length > dataMax){

                            fileLengthExceeded = true
                            fileLength = 0;

                        }
                    }

                    if(dataType && dataType !== ""){

                        var checkDataType = (dataType.replace(/\[|\"|\'|\]/g,'').split(',')).map(data => data.trim());
                        
                        var uploadedDataTypes = ([...inputElement.files].map(file => file.type))

                        uploadedDataTypes.forEach(data => {
                            if(checkDataType.includes(data)){
                                neededDataTypes.push(true)
                            }else{
                                neededDataTypes.push(false)
                            }
                        })


                        if(uploadedDataTypes.length === neededDataTypes.length && !neededDataTypes.includes(false)){
                            fileTypePassed = true;
                        }

                        

                    }

                    if(dataMaxSize && dataMaxSize !== ""){

                        dataMaxSize = (dataMaxSize * 1000000)


                         var uploadedDataSizes = ([...inputElement.files].map(file => file.size));


                         var outlaws = uploadedDataSizes.filter(sizes => sizes > dataMaxSize);



                         if(outlaws.length > 0){
                            maxSizePassed = true
                         }

                    }

                    if(dataMinSize && dataMinSize !== ""){

                         dataMinSize = (dataMinSize * 1000000)

                         var uploadedDataSizes = ([...inputElement.files].map(file => file.size));

                         var outlaws = uploadedDataSizes.filter(sizes => sizes < dataMinSize);

                         if(outlaws.length > 0){
                            minSizePassed = true
                         }


                    }

                }

                
                var val = e.target.value.trim();

                if((dataRequired && val === "") || (type === "file" && fileLengthExceeded) || (dataMaxSize && dataMaxSize !== "" && maxSizePassed) || (dataMinSize && dataMinSize !== "" && minSizePassed) || (dataType && dataType !== "" && !fileTypePassed)){

                    if(dataRequired && val === ""){
    
                        var newErr = inputElement.getAttribute("data-required-err") || inputElement.getAttribute("required-err")
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "This field is required";
                        }
    
                    }else if(type === "file" && fileLengthExceeded){

                        var newErr = inputElement.getAttribute("data-max-err")
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "You can't select more than " + dataMax + " files";
                        }

                    }else if(dataType && dataType !== "" && !fileTypePassed){

                        var newErr = inputElement.getAttribute("data-type-err");
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "The file selected is an invalid file format";
                        }

                        
                    }else if(dataMaxSize && dataMaxSize !== "" && maxSizePassed){

                        var newErr = inputElement.getAttribute("data-max-size-err");
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "The file selected too large";
                        }


                    }else if(dataMinSize && dataMinSize !== "" && minSizePassed){

                        var newErr = inputElement.getAttribute("data-min-size-err");
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "The file selected too small";
                        }


                    }


    
                    showFormErr(dataName, message);
                    inputElement.value = ""

                }else{

                    var mess = fileLength + (fileLength > 1?" files": " file") + " selected";
                    
                    if(fileLength > 0){

                        showFormErr(dataName, mess, true)
                    }else{
                        
                        showFormErr(dataName, "", true)
                    }

                    return true;
                    
                }

            })

        }
    })

}

window.addEventListener("load", () => {
    var formChangeButton = All(".form-change-btn");
    var forms = All("form");

    formChangeButton.forEach((element) => {
        element.addEventListener("click", (e)=>{

            var content = element.getAttribute("data-content");
            showFormElement(content)
            

        })
    })

    addInputEventListener();

    forms.forEach(form => {
        form.addEventListener("submit", submitFormValidation, true);
    })

})