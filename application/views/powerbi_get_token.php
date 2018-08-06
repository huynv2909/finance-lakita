<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>

        <script src="https://secure.aadcdn.microsoftonline-p.com/lib/1.0.12/js/adal.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
			 <script>
   			  window.config  = {
   				  instance: 'https://login.microsoftonline.com/',
   				  tenant: 'common', //COMMON OR YOUR TENANT ID

   				  clientId: 'a050392b-5b82-4dae-a75f-5b7a52dacbf7', //This is your client ID
   				  redirectUri: 'http://taichinh.lakita.vn/GetResponsesPBI', //This is your redirect URI

   				  callback: userSignedIn,
   				  popUp: true
   			  };

			     var ADAL = new AuthenticationContext(config);

				  function signIn() {
				      ADAL.login();
				  }

				  function userSignedIn(err, token) {
				      console.log('userSignedIn called');
				      if (!err) {

                  showWelcomeMessage();

				  ADAL.acquireToken("https://analysis.windows.net/powerbi/api", function (error, token) {

                  // Handle ADAL Error
                  if (error || !token) {
                      printErrorMessage('ADAL Error Occurred: ' + error);
                      return;
                  }

                  // Get TodoList Data
                  $.ajax({
                      type: "GET",
                      url: "https://api.powerbi.com/v1.0/myorg/datasets",
                      headers: {
                          'Authorization': 'Bearer ' + token,
                      },
                  }).done(function (data) {


                      console.log(data);



                      // Update the UI
                      $loading.hide();


                  }).fail(function () {
                      printErrorMessage('Error getting todo list data')
                  }).always(function () {

                      // Register Handlers for Buttons in Data Table
                      registerDataClickHandlers();
                  });
              });
				      }
				      else {
				          console.error("error: " + err);
				      }
				  }




				  function getDataSets(){


                  var trythis = "Bearer " + token;
    							var request = new XMLHttpRequest();

                  request.open('GET', 'https://api.powerbi.com/v1.0/myorg/datasets');

                  request.setRequestHeader('Authorization', trythis);

                  request.onreadystatechange = function () {
                    if (this.readyState === 4) {
                      console.log('Status:', this.status);
                      console.log('Body:', this.responseText);
                    }
                  };

                  request.send();


				  }




				  function showWelcomeMessage() {
				      var user = ADAL.getCachedUser();
				      var divWelcome = document.getElementById('WelcomeMessage');
				      divWelcome.innerHTML = "Welcome " + user.profile.name;
				  }
        </script>

    </head>
    <body>


			 <button id="SignIn" onclick="signIn()">Sign In</button>
			 <h4 id="WelcomeMessage"></h4>




    </body>
</html>
