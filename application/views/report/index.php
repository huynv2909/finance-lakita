<html>

    <script src="https://microsoft.github.io//PowerBI-JavaScript/demo/node_modules/jquery/dist/jquery.js"></script>
    <script src="https://microsoft.github.io//PowerBI-JavaScript/demo/node_modules/powerbi-client/dist/powerbi.js"></script>

   <script type="text/javascript">

   window.onload = function () {

   var embedConfiguration = {
       type: 'report',
       accessToken: '',
       embedUrl: 'https://app.powerbi.com/reportEmbed?reportId=9f841c40-b361-490b-8f08-01dd2b8e6645'
   };

   var $reportContainer = $('#reportContainer');

   // var report = powerbi.embed($reportContainer.get(0), embedConfiguration);

   }

   </script>
   <div id="reportContainer"></div>
   <iframe width="800" height="600" src="https://app.powerbi.com/view?r=eyJrIjoiYzFjNmIyNWMtYTQxMS00OGRiLWI2MGYtYWM1NmI4MjQ4NTBmIiwidCI6Ijc3MWEwYTMzLTUxY2ItNGNiNS1hZGQ2LWVmNGIwNzJiYThkOSIsImMiOjEwfQ%3D%3D" frameborder="0" allowFullScreen="true"></iframe>

</html>
