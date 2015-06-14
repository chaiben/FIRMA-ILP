ILP.Controllers.Index = function(){
    var form_el, xml_hash, n;
    function Init(){
        form_el = $("form");
        Validate();
    }

    function Validate(){
        form_el.validate({
            rules: {
                name_input: {
                    required: true
                },
                first_surname: {
                    required: true
                },
                second_surname: {
                    required: true
                },
                birthday_input: {
                    required: true
                },
                doc: {
                    required: true,
                    minlength: 9,
                    maxlength: 9
                }
            },
            messages: {
                name_input:{
                    required: error.required
                },
                first_surname:{
                    required: error.required
                },
                second_surname:{
                    required: error.required
                },
                birthday_input:{
                    required: error.required
                },
                doc:{
                    required: error.required,
                    minlength: error.dni_format,
                    maxlength: error.dni_format,
                }
            },
            submitHandler: function(form) {
                var label = getDataForm();
                sendEventGA("Formulario", "Validado", label, 2);
                Firmar();
            },
            invalidHandler: function(event, validator){
                var label = getDataForm();
                sendEventGA("Formulario", "Erro de validación", label, 1);
            }
        });
}

function Firmar(){
    var data = {};
        // @todo: Check form

        // Get form data
        $("input").each(function(){
            if($(this).attr("id") != undefined)
                data[$(this).attr("id")] = $(this).val();
        });
        $.ajax({
            url: "/ilp/get-doc",
            dataType: "json",
            data: data,
            type: "POST",
            success: function(result){
                if(result.error != ""){
                    showErrorFunction("Erro ILP", result.error);
                    alert(result.error);
                } else {
                    xml_hash = result.h;
                    n = result.n;
                    sendEventGA("ILP", "Recibido", result.doc_xml, 3);
                    sign(result.doc_xml, result.filter);
                }
            }
        })
    }

    function showCallback (signatureB64) {
        var xml_signed = MiniApplet.getTextFromBase64(signatureB64, "utf-8");
        var data = {}
        data["xml_hash"] = xml_hash;
        data["n"] = n;
        data["xml_signed"] = xml_signed;

        $.ajax({
            url: "/ilp/save-sign",
            dataType: "json",
            data: data,
            type: "POST",
            success: function(result){
                if(result.error == 0){
                    sendEventGA("Firmar", "ILP guardada en la base de datos", "", 8);
                    alert("Firma realizada correctamente. ¡Gracias!");
                }

                if(result.error == 1){
                    sendEventGA("Error al firmar", "XML Invalido.", result.xml, 5);
                    alert(error.sign);
                }
            }
        });
    }
    function showErrorFunction (type, message) {
        label = getDataForm();
        sendEventGA(type, message, label, 3);
        alert(message);
    }


    function sendEventGA(category, action, label, value){
        value = (value == undefined) ? value : 1;
        ga('send', {
            'hitType': 'event',
            'eventCategory': category,
            'eventAction': action,
            'eventLabel': label,
            'eventValue': value
        });
    }

    function sign(xml, filter){
        var dataB64 = MiniApplet.getBase64FromText(xml, "utf-8");
        MiniApplet.language
        MiniApplet.sign(dataB64, "SHA512withRSA", "XAdES", 'format=XAdES Enveloped\nfilter=subject.rfc2254:(CN='+filter+')', showCallback, showErrorFunction);
    }

    function getDataForm(){
        var result="";
        $("input").each(function(){
            if($(this).attr("id") != undefined)
                result = result+$(this).attr("id")+":"+$(this).val()+";";
        });
        return result;
    }

    return{
        Init : Init,
        Firmar : Firmar
    }
}();