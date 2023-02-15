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
    var inputs = All("input");
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
        
                    
        form.preventDefault();

        inputs.forEach(inputElement => {

            var dataName = inputElement.getAttribute("data-name");
            var regex = inputElement.getAttribute("data-regex")
            var dataMin = inputElement.getAttribute("data-min")
            var generalErr = inputElement.getAttribute("data-name-err")
            var dataMax = inputElement.getAttribute("data-max")
            var dataRequired = inputElement.getAttribute("data-required") || inputElement.getAttribute("required")
            var message = "";

            if(generalErr && generalErr !== ""){
                message =  generalErr;
            }

            if(inputElement.getAttribute("type") !== "file"){

                var val = inputElement.value.trim();

                if(val === "" || (regex && regex !== "" && !new RegExp(regex).test(val)) || (dataMin && dataMin !== "" && val.length < parseInt(dataMin)) || (dataMax && dataMax !== "" && val.length > parseInt(dataMax))){

                    if(dataRequired && val === ""){
    
                        var newErr = inputElement.getAttribute("data-required-err") || inputElement.getAttribute("required-err")
    
                        if(newErr && newErr !== ""){
    
                            message = newErr;
    
                        }else{
                            message = "This field is required";
                        }
    
                    }else if(regex && regex !== "" && !new RegExp(regex).test(val)){

                        console.log("worked")
    
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
                }
            
            }

        })

        if(!checkArr.includes(false)){

            var xmlHttp;

            if (window.XMLHttpRequest) {
            // code for modern browsers
                xmlHttp = new XMLHttpRequest();
            } else {
            // code for old IE browsers
                xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
            }

            if(action && action !== ""){

                if(!method || method === ""){
                    method = "get";
                }

                xmlHttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {

                        

                        inputs.forEach((element)=>{

                            element.value = "";

                        })


                    }else{
                        
                    }
                };

                xmlHttp.open(method, action, true)

                xmlHttp.send();
            }


        }
    }

}

window.addEventListener("load", () => {
    var formChangeButton = All(".form-change-btn");
    var inputFields = All("input");
    var forms = All("form");

    formChangeButton.forEach((element) => {
        element.addEventListener("click", (e)=>{

            var content = element.getAttribute("data-content");
            showFormElement(content)
            

        })
    })

    inputFields.forEach(inputElement => {
        var dataName = inputElement.getAttribute("data-name");
        var regex = inputElement.getAttribute("data-regex")
        var dataMin = inputElement.getAttribute("data-min")
        var generalErr = inputElement.getAttribute("data-name-err")
        var dataMax = inputElement.getAttribute("data-max")
        var dataRequired = inputElement.getAttribute("data-required") || inputElement.getAttribute("required")
        var message = "";

        if(generalErr && generalErr !== ""){
            message = generalErr;
        }

        if(inputElement.getAttribute("type") !== "file"){

            inputElement.addEventListener("input", (e)=>{

                var val = e.target.value.trim();

                if(val === "" || (regex && regex !== "" && !new RegExp(regex).test(val)) || (dataMin && dataMin !== "" && val.length < parseInt(dataMin)) || (dataMax && dataMax !== "" && val.length > parseInt(dataMax))){

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

            })

        }
    })

    forms.forEach(form => {
        form.addEventListener("submit", submitFormValidation);
    })

})