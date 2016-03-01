function ajaxx(url,numero,nomAppel,organisme,publication,img,src,urlDestination) {
  $.ajax({
      type: "POST",
      url: url,
      data: {
          "numero": numero, // Numéro de proposition
          "nom": nomAppel,
          "organisme": organisme,
          "publication": publication
      },
      dataType: "text",
      timeout: 7000, // 7s
      success: function(data, textStatus, jqXHR) {
          alert(data);
          img.attr("src",src);
          if (urlDestination)
            location.assign(urlDestination);
      },
      error: function(jqXHR, textStatus, errorThrown) {
         console.log("Upload failed: " + textStatus + " // " + errorThrown);
         alert("Problème lors de la soumission de la requête HTTP");
         img.attr("src",src);
     }
  });
}

function faireProposition(url,id,nom,organisme,publication) { // OK
  // http://stackoverflow.com/a/12962912/2105309
  var img = $("tr#row"+id+" td:not(:last-child) img");
  var src = img.attr("src").toString();
  var path = src.substring(0,src.lastIndexOf('/'));
  var newSrc = path+"/ajax-loader.gif";
  img.attr("src",newSrc);

  ajaxx(url,null,nom,organisme,publication,img,src,false);
}

function supprimerAppel(url,id,nom,organisme,publication,destUrl) { // OK
  var img = $("tr#row"+id+" td:last-child img");
  var src = img.attr("src").toString();
  var path = src.substring(0,src.lastIndexOf('/'));
  var newSrc = path+"/ajax-loader.gif";
  img.attr("src",newSrc);

  ajaxx(url,null,nom,organisme,publication,img,src,destUrl);
}

function supprimerPropositionOuProjet(url,id,numero,nomAppel,organisme,publication,destUrl) { // OK
  var img = $("tr#row"+id+" td:last-child img");
  var src = img.attr("src").toString();
  var path = src.substring(0,src.lastIndexOf('/'));
  var newSrc = path+"/ajax-loader.gif";
  img.attr("src",newSrc);

  ajaxx(url,numero,nomAppel,organisme,publication,img,src,destUrl);
}
