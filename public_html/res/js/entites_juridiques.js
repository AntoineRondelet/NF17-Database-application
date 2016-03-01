function ajax(urlPost,objet_value,img,imgSrc,urlDestination) {
  $.ajax({
      type: "POST",
      url: urlPost,
      data: {
          'id': objet_value, // pour entites et membres labos
          'nom': objet_value // pour organismes
      },
      dataType: "text",
      timeout: 7000, // 7s
      success: function(data, textStatus, jqXHR) {
          alert(data);
          img.attr("src",imgSrc);
          if (urlDestination)
            location.assign(urlDestination);
      },
      error: function(jqXHR, textStatus, errorThrown) {
         console.log("Upload failed: " + textStatus + " // " + errorThrown);
         alert("Problème lors de la soumission de la requête HTTP");
         img.attr("src",imgSrc);
     }
  });
}

function supprimerEntite(urlPost,idRow,entite_juridique_id,destUrl) { // OK
  // http://stackoverflow.com/a/12962912/2105309
  var img = $("tr#row"+idRow+" img");
  var src = img.attr("src").toString();
  var path = src.substring(0,src.lastIndexOf('/'));
  var newSrc = path+"/ajax-loader.gif";
  img.attr("src",newSrc);

  ajax(urlPost,entite_juridique_id,img,src,destUrl);
}

function supprimerMembreLabo(urlPost,idRow,membre_labo_id,destUrl) {
  // http://stackoverflow.com/a/12962912/2105309
  var img = $("tr#row"+idRow+" img");
  var src = img.attr("src").toString();
  var path = src.substring(0,src.lastIndexOf('/'));
  var newSrc = path+"/ajax-loader.gif";
  img.attr("src",newSrc);

  ajax(urlPost,membre_labo_id,img,src,destUrl);
}

function supprimerOrganismeProjet(urlPost,idRow,organisme_projet_nom,destUrl) {
  // http://stackoverflow.com/a/12962912/2105309
  var img = $("tr#row"+idRow+" img");
  var src = img.attr("src").toString();
  var path = src.substring(0,src.lastIndexOf('/'));
  var newSrc = path+"/ajax-loader.gif";
  img.attr("src",newSrc);

  ajax(urlPost,organisme_projet_nom,img,src,destUrl);
}