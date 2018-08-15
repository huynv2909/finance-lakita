<html>
<script src="https://microsoft.github.io/PowerBI-JavaScript/demo/node_modules/jquery/dist/jquery.js"></script>
<script src="https://microsoft.github.io/PowerBI-JavaScript/demo/node_modules/powerbi-client/dist/powerbi.js"></script>
<script type="text/javascript">

window.onload = function () {
var embedConfiguration = {
    type: 'report',
	accessToken: '<?php echo $access_tk; ?>',
	embedUrl: 'https://app.powerbi.com/reportEmbed?reportId=b2fd945a-ee6a-4995-8590-ce0fd1ff2f33&groupId=9332d98b-9550-4d2b-82cf-9fb24b0188d1',
	id:'b2fd945a-ee6a-4995-8590-ce0fd1ff2f33',
settings: {

            }
	};
var $reportContainer = $('#dashboardContainer');
var report = powerbi.embed($reportContainer.get(0), embedConfiguration);
}

function reloadreport(){
	var element = $('#dashboardContainer');
	alert(element);
	var report = powerbi.get(element);
	report.reload().catch(error => {console.log(error)  });
};
</script>
<div id="dashboardContainer"></div>
</html>
