<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src=" {{ URL::asset('js/jquery-3.2.1.min.js') }} "></script>
</head>
<body>
<div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%;">
    <iframe width="100%" height="100%" src="https://denise.pdffiller.com/en/login/auto.htm?t=1515676445&id=186705&uid=5a57631db505b&hash=56f1fed53f2624ddeef0fcc79ed2e7fc" name="myFrame">not supported</iframe>
</div>
<script>
    window.addEventListener('message', function(e) {
        if (e.data === 'editorDone') { console.log(e); alert('1') }
        });
    $(document).ready(function () {
        $("#test").on("click", function () {
            var url = "http://apicallbacks.pdffiller.com/handle?hash=11cf8c99";
            var data = "";
            function success(data) {
                console.log(data);
            }
            var dataType = "json";
            $.ajax({
                url: url,
                data: data,
                success: success,
                dataType: dataType
            });
        })
    })

</script>
<div id="test">test</div>
</body>
</html>
