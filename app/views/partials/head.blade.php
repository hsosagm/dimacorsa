<head>
	<script type="text/javascript">
		function LoadMyJs(scriptName) {
			var docHeadObj = document.getElementsByTagName("head")[0];
			// document.getElementById("customjs").innerHTML = '';
			var dynamicScript = document.createElement("script");
			dynamicScript.type = "text/javascript";
			dynamicScript.src = scriptName;
			docHeadObj.appendChild(dynamicScript);
			// document.getElementById('customjs').appendChild(dynamicScript);
		}
	</script>
	
	{{ HTML::style('css/main.css'); }}
	<link href="css/themes/default.theme.css" rel="stylesheet" id="theme">
	<link href="calendar/themes/classic.css" rel="stylesheet">
	<link href="calendar/themes/classic.date.css" rel="stylesheet">
</head>

{{-- <div id="customjs"></div> --}}