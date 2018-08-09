<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Access token</title>
   </head>
   <body>
      <script type="text/javascript">
         var groupID = '9332d98b-9550-4d2b-82cf-9fb24b0188d1';
         var reportID = 'b2fd945a-ee6a-4995-8590-ce0fd1ff2f33';
         var url = 'https://app.powerbi.com/reportEmbed?reportId=b2fd945a-ee6a-4995-8590-ce0fd1ff2f33&groupId=9332d98b-9550-4d2b-82cf-9fb24b0188d1';
      // Read embed application token from textbox
         var txtAccessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsIng1dCI6IjdfWnVmMXR2a3dMeFlhSFMzcTZsVWpVWUlHdyIsImtpZCI6IjdfWnVmMXR2a3dMeFlhSFMzcTZsVWpVWUlHdyJ9.eyJhdWQiOiJodHRwczovL2FuYWx5c2lzLndpbmRvd3MubmV0L3Bvd2VyYmkvYXBpIiwiaXNzIjoiaHR0cHM6Ly9zdHMud2luZG93cy5uZXQvNzcxYTBhMzMtNTFjYi00Y2I1LWFkZDYtZWY0YjA3MmJhOGQ5LyIsImlhdCI6MTUzMjY4NDM3NCwibmJmIjoxNTMyNjg0Mzc0LCJleHAiOjE1MzI2ODgyNzQsImFjciI6IjEiLCJhaW8iOiJBU1FBMi84SUFBQUFDbGNLMEh4SHZ5NXRXTTVURU1oTXo3dlFMY1RrbndHZzU5VUNsZlZEb3R3PSIsImFtciI6WyJwd2QiXSwiYXBwaWQiOiJhMDUwMzkyYi01YjgyLTRkYWUtYTc1Zi01YjdhNTJkYWNiZjciLCJhcHBpZGFjciI6IjAiLCJlX2V4cCI6MjYyODAwLCJmYW1pbHlfbmFtZSI6IkNvbXBhbnkiLCJnaXZlbl9uYW1lIjoiTGFraXRhIiwiaXBhZGRyIjoiMTQuMTYyLjg1LjE2OSIsIm5hbWUiOiJMYWtpdGEgQ29tcGFueSIsIm9pZCI6IjNiNzMzMTUxLWNiZTUtNDUyOS05MmQ0LTY1N2ZmMGM4YzhhYiIsInB1aWQiOiIxMDAzMDAwMEFDNkZGMTU3Iiwic2NwIjoiQ2FwYWNpdHkuUmVhZC5BbGwgQ2FwYWNpdHkuUmVhZFdyaXRlLkFsbCBDb250ZW50LkNyZWF0ZSBEYXNoYm9hcmQuUmVhZC5BbGwgRGFzaGJvYXJkLlJlYWRXcml0ZS5BbGwgRGF0YS5BbHRlcl9BbnkgRGF0YXBvb2wuUmVhZC5BbGwgRGF0YXBvb2wuUmVhZFdyaXRlLkFsbCBEYXRhc2V0LlJlYWQuQWxsIERhdGFzZXQuUmVhZFdyaXRlLkFsbCBHcm91cC5SZWFkIEdyb3VwLlJlYWQuQWxsIE1ldGFkYXRhLlZpZXdfQW55IFJlcG9ydC5SZWFkLkFsbCBSZXBvcnQuUmVhZFdyaXRlLkFsbCBUZW5hbnQuUmVhZC5BbGwgVGVuYW50LlJlYWRXcml0ZS5BbGwgV29ya3NwYWNlLlJlYWQuQWxsIFdvcmtzcGFjZS5SZWFkV3JpdGUuQWxsIiwic3ViIjoiU2NJVTZqRlp3ZHNhMVBwVmZyTDBMNUxTQ2lrdDRQQ1B5VExfOXZLTVZPcyIsInRpZCI6Ijc3MWEwYTMzLTUxY2ItNGNiNS1hZGQ2LWVmNGIwNzJiYThkOSIsInVuaXF1ZV9uYW1lIjoiaG9ja2V0b2Fub25saW5lQGxha2l0YS52biIsInVwbiI6ImhvY2tldG9hbm9ubGluZUBsYWtpdGEudm4iLCJ1dGkiOiJjUThab042UWZVR0psamJzRXVZWUFBIiwidmVyIjoiMS4wIiwid2lkcyI6WyI2MmU5MDM5NC02OWY1LTQyMzctOTE5MC0wMTIxNzcxNDVlMTAiXX0.Ttc_t2ncZNVWrAZEa4emLqhsUkM7Xu_Ih261JplPrkzdlZAZVgioF__pos_pKsHKnlf0mdnAJ-4fL43d8ItcrzhQ49QOMz0q-uFgmQsnyI03YUMakTypvG5IAdAuH0L1ydvZbaEPZReR_2TOVrgRh308B2xdXF_OKWEDSxceXrK8vL-DzA9YshmAHANe96_CPgisX5A28GFeYCcJXSOfBw5FTtPvHZgVC2Pdr9r5ux8DRbYzvpO7Ya0wuQtkmFikn_u1Amya8_dcJDOWEQIJC0aD56psQJZlu59cuRwerCA0jE3C4lQun1SOuSyNH-xBFLJV2P2jckbxVfGw6d4_sg';

         // Read embed URL from textbox
         var txtEmbedUrl = $('#txtReportEmbed').val();

         // Read report Id from textbox
         var txtEmbedReportId = $('#txtEmbedReportId').val();

         // Read embed type from radio
         var tokenType = $('input:radio[name=tokenType]:checked').val();

         // Get models. models contains enums that can be used.
         var models = window['powerbi-client'].models;

         // We give All permissions to demonstrate switching between View and Edit mode and saving report.
         var permissions = models.Permissions.All;

         // Embed configuration used to describe the what and how to embed.
         // This object is used when calling powerbi.embed.
         // This also includes settings and options such as filters.
         // You can find more information at https://github.com/Microsoft/PowerBI-JavaScript/wiki/Embed-Configuration-Details.
         var config= {
         type: 'report',
         tokenType: tokenType == '0' ? models.TokenType.Aad : models.TokenType.Embed,
         accessToken: txtAccessToken,
         embedUrl: txtEmbedUrl,
         id: txtEmbedReportId,
         permissions: permissions,
         settings: {
              filterPaneEnabled: true,
              navContentPaneEnabled: true
         }
         };

         // Get a reference to the embedded report HTML element
         var embedContainer = $('#embedContainer')[0];

         // Embed the report and display it within the div container.
         var report = powerbi.embed(embedContainer, config);

         // Report.off removes a given event handler if it exists.
         report.off("loaded");

         // Report.on will add an event handler which prints to Log window.
         report.on("loaded", function() {
         Log.logText("Loaded");
         });

         report.on("error", function(event) {
         Log.log(event.detail);

         report.off("error");
         });

         report.off("saved");
         report.on("saved", function(event) {
         Log.log(event.detail);
         if(event.detail.saveAs) {
              Log.logText('In order to interact with the new report, create a new token and load the new report');
           }
         });
      </script>
   </body>
</html>
