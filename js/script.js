
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
                var tr = createRow(immobile);
                $("#immobili").append(tr);
            }
        },
        error: function(){
            alert("errore");
        }
    })
}

function createRow(immobile){

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

    //INSERISCO I DATI
    td1.append(immobile["immagine"]);
    td2.append(immobile["titolo"]);
    td3.append(immobile["prezzo"]);
    td4.append(immobile["mq"]);
    td5.append(immobile["locali"]);
    td6.append(immobile["data"]);
    td7.append(immobile["localita"]);
    td8.append(immobile["provincia"]);

    tr.append(td1);
    tr.append(td2);
    tr.append(td3);
    tr.append(td4);
    tr.append(td5);
    tr.append(td6);
    tr.append(td7);
    tr.append(td8);

    return tr;


}