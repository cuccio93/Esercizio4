
function getImmobili(tipo_immobile){

    $("#titolo").text(tipo_immobile);

    var data = {
        tipo_immobile : tipo_immobile
    };

    $.ajax({
        type: "POST",
        url:"php/get_data.php",
        data:data,
        success: function(result){
            var immobili = JSON.parse(result);

            //SVUOTOLA TABELLA
            $("#immobili").text("");

            //RIEMPO LA TABELLA
            for(var immobile of immobili){
                var tr = createRow(immobile,"si");
                $("#immobili").append(tr);
            }
        },
        error: function(){
            errorMessage("Errore");
        }
    })
}

function createRow(immobile,checkPDF){

    //CREO GLI ELEMENTI
    var tr = $("<tr></tr>");
    var td1 = $("<td></td>");
    var td2 = $("<td></td>");
    var td3 = $("<td></td>");
    var td4 = $("<td></td>");
    var td5 = $("<td></td>");
    var td6 = $("<td></td>");
    var td7 = $("<td></td>");
    var td8 = $("<td></td>");
    var td9 = $("<td></td>");
    var td10 = $("<td></td>");

    //CREO I BOTTONI
    if(checkPDF == "si"){
        var btnPDF = $("<a href='http://localhost/Corso%20Sida/PHP/Esercizio4/php/create_pdf.php?id=" + immobile["id"] + "' target='_blank'>PDF</a>"); 
    }
    if(immobile["controlWishlist"] == "0"){
        var btnWishlist = $("<button type='button' class='btn btn-default' onclick='addToWishlist(" + immobile["id"] + ")'>Aggiungi alla wishlist</button>");
    }else{
        var btnWishlist = $("<button type='button' class='btn btn-default' onclick='deleteToWishlist(" + immobile["id"] + ")'>Elimina dalla wishlist</button>");        
    }

    //INSERISCO I DATI
    td1.append(immobile["immagine"]);
    td2.append(immobile["titolo"]);
    td3.append(immobile["prezzo"]);
    td4.append(immobile["mq"]);
    td5.append(immobile["locali"]);
    td6.append(immobile["data"]);
    td7.append(immobile["localita"]);
    td8.append(immobile["provincia"]);
    if(checkPDF == "si"){
        td9.append(btnPDF); 
    }
    td10.append(btnWishlist);

    tr.append(td1);
    tr.append(td2);
    tr.append(td3);
    tr.append(td4);
    tr.append(td5);
    tr.append(td6);
    tr.append(td7);
    tr.append(td8);
    if(checkPDF == "si"){
        tr.append(td9);
    }
    tr.append(td10);

    return tr;


}

function addToWishlist(id){
    var data = {
        id: id,
        action: "add"
    };

    $.ajax({
        type:"POST",
        url: "php/management_wishlist.php",
        data: data,
        success: function(result){
            if(result == "1"){
                successMessage("Aggiunto alla Wishlist");
                var tipo_immobili = $("#titolo").text();
                getImmobili(tipo_immobili);
            }else{
                errorMessage(result);
            }
        },
        error: function(){
            errorMessage("Errore");
        }
    })
}

function deleteToWishlist(id){
    var data={
        action : "delete",
        id: id
    };

    $.ajax({
        type: "POST",
        url: "php/management_wishlist.php",
        data: data,
        success: function(result){
            if(result == "1"){
                successMessage("Eliminato dalla Wishlist");
                var tipo_immobili = $("#titolo").text();
                getImmobili(tipo_immobili);
                openWishlist();
            }else{
                errorMessage(result);
            }
        },
        error: function(){
            errorMessage("Errore");
        }
    })
}

function openWishlist(){
    var data={
        action:"view"
    };

    $.ajax({
       type: "POST",
        url: "php/management_wishlist.php",
        data: data,
        success: function(result){
            var immobili = JSON.parse(result);

            $("#immobili-wishlist").text("");

            for(var immobile of immobili){
                var tr = createRow(immobile,"no");

                $("#immobili-wishlist").append(tr);
            }
        },
        error: function(){
            errorMessage("Errore");
        }
    })
}

function successMessage(text){
    $("#message").css("background-color","green");
    $("#message").text(text);
    $("#message").animate({
        "top": "0px"
    },"slow");

    setTimeout(function(){
        $("#message").animate({
            "top": "-60px"
        },"slow");
    },3000)

}

function errorMessage(text){
    $("#message").css("background-color","red");
    $("#message").text(text);
    $("#message").animate({
        "top": "0px"
    },"slow");

    setTimeout(function(){
        $("#message").animate({
            "top": "-60px"
        },"slow");
    },3000)

}