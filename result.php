<?php
$a=$_POST['inputImage'];
?>
<!DOCTYPE html>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<html>
<head>
    <title>分析圖像結果</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
</head>
<body onload="processImage()">
<script type="text/javascript">
    function processImage() {
        // **********************************************
        // *** Update or verify the following values. ***
        // **********************************************
        let subscriptionKey = '092dca9731fd458da1b2b5a489c66fe6';
        let endpoint = 'https://southcentralus.api.cognitive.microsoft.com/customvision/v3.0/Prediction/f8b412c9-754b-4d14-a675-e377a2c17d8c/classify/iterations/Iteration1/url';
        if (!subscriptionKey) { throw new Error('Set your environment variables for your subscription key and endpoint.'); }
        
        // Display the image.
        var sourceImageUrl = document.getElementById("inputImage").value;
        document.querySelector("#sourceImage").src = sourceImageUrl;
        // Make the REST API call.
        $.ajax({
            url: endpoint + "?",
            // Request headers.
            beforeSend: function(xhrObj){
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader("Prediction-Key", subscriptionKey);
            },
            type: "POST",
            // Request body.
            data: '{"url": ' + '"' + sourceImageUrl + '"}',
        })
        .done(function(data) {
            // Show formatted JSON on webpage.
            $("#responseTextArea").val(JSON.stringify(data, null, 2));
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            // Display error message.
            var errorString = (errorThrown === "") ? "Error. " :
                errorThrown + " (" + jqXHR.status + "): ";
            errorString += (jqXHR.responseText === "") ? "" :
                jQuery.parseJSON(jqXHR.responseText).message;
            alert(errorString);
        });
    };
</script>

<style>

        h1 {
               font-size: 40px;
               text-align: center;
             }
       
       body{
               background-color: rgba(255, 181, 181, 0.849);
       }
       
       </style>

<input type="hidden" name="inputImage" id="inputImage" value="<?php echo $a;?>" />
<div id="wrapper" style="width:1450px; display:table;text-align:center;">
    <div id="jsonOutput" style="width:600px; display:table-cell;">
        <h1>分析結果</h1>
        <br><br>
        <textarea id="responseTextArea" class="UIInput"
                  style="width:580px; height:400px;"></textarea>
    </div>
    <div id="imageDiv" style="width:420px; display:table-cell;">
        <h1>圖像顯示</h1>
        <br><br>
        <img id="sourceImage" width="400" >
    </div>
</div>

    <center>
        <input style="width: 200px;px;height:40px;font-size:20px; " type="button" value="回到分析頁面" onclick="location.href='index.html'"></center>
    </center>

</body>
</html>