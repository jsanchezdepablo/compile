
function compararContra(){

    var pass1 = document.getElementById('pass').value;
    var pass2 = document.getElementById('pass2').value;

    if(pass1.localeCompare(pass2) == 0 ){
       document.getElementById('pass').style.borderColor = "#1ED810";
       document.getElementById('pass2').style.borderColor = "#1ED810";
       document.getElementById('aceptar').disabled= false;

    }else{
       document.getElementById('pass').style.borderColor = "red";
       document.getElementById('pass2').style.borderColor = "red";
       document.getElementById('aceptar').disabled= true;
   }

}



//FUNCION AJAX, ALELUYA HERMANOS

function llamarArchivo(datos){   //"id1=jfjf&id2=jjf"

    // console.log("llamando" + datos);
    $.ajax({
        url: 'funcion.php?'+ datos,  /// funcion.php?id1=jfjf&id2=jjf
        type: 'GET'
        // data: 'iduser=12345',
        // success: function(data) {
        // alert(data);
        // },
        // error: function(){
        // alert('Error!');
        // }
  });

}




function porcentajePerfil(datos){   //"id1=jfjf&id2=jjf"

    // console.log("llamando" + datos);
    $.ajax({
        url: 'funcion.php?'+ datos,  /// funcion.php?id1=jfjf&id2=jjf
        type: 'GET'
        // data: 'iduser=12345',
        // success: function(data) {
        // alert(data);
        // },
        // error: function(){
        // alert('Error!');
        // }
  });

}







//  function onSignIn(googleUser) {
//         // Useful data for your client-side scripts:
//         var profile = googleUser.getBasicProfile();
//         console.log("ID: " + profile.getId()); // Don't send this directly to your server!
//         console.log('Full Name: ' + profile.getName());
//         console.log('Given Name: ' + profile.getGivenName());
//         console.log('Family Name: ' + profile.getFamilyName());
//         console.log("Image URL: " + profile.getImageUrl());
//         console.log("Email: " + profile.getEmail());

//         sessionStorage.setItem("email", profile.getEmail());

//         console.log(sessionStorage.getItem("email"));

//         // The ID token you need to pass to your backend:
//         var id_token = googleUser.getAuthResponse().id_token;
//         console.log("ID Token: " + id_token);
// };








// Cosas de la api facebook

// window.fbAsyncInit = function() {
//     FB.init({
//       appId      : '1830890463900211',
//       xfbml      : true,
//       version    : 'v2.9'
//     });
//     FB.AppEvents.logPageView();
//   };

// // <div id="fb-root"></div>

// (function(d, s, id) {
//   var js, fjs = d.getElementsByTagName(s)[0];
//   if (d.getElementById(id)) return;
//   js = d.createElement(s); js.id = id;
//   js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.9&appId=1830890463900211";
//   fjs.parentNode.insertBefore(js, fjs);
// }(document, 'script', 'facebook-jssdk'));


// FB.logout(function(response) {
//    // Person is now logged out
// });