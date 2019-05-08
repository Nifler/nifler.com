<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    </head>
    <body>
        <canvas id="pool"></canvas>
        <br/>
        <button id="run">RUN</button>
        <script>
            var url = "https://nifler.com/botpool/run";

            function run()
            {
                jQuery.ajax({
                    url: url
                })
                    .done(function( data ) {
                        var res = JSON.parse(data);
                        buildPool(res.dimensions, res.pixels)
                    });
            }

            function buildPool(dimensions, pixels) {
                var pixelWidth = 4;
                var width = pixelWidth * dimensions.width + (dimensions.width + 1) * 1;
                var height = pixelWidth * dimensions.height + (dimensions.height + 1) * 1;

                var pool = jQuery("#pool");
                pool.attr('width', width);
                pool.attr('height', height);

                var canvas = document.getElementById('pool');
                var ctx = canvas.getContext('2d');
                ctx.fillStyle = 'rgb(225, 225, 225, 225)';
                ctx.fillRect(0, 0, width, height);

                for (var i = 0; i <= dimensions.width; i++) {
                    ctx.beginPath();
                    ctx.moveTo(i * pixelWidth + i, 0);
                    ctx.lineTo(i * pixelWidth + i, height);
                    ctx.stroke();
                }
                for (var i = 0; i <= dimensions.height; i++) {
                    ctx.beginPath();
                    ctx.moveTo(0, i * pixelWidth + i);
                    ctx.lineTo(width, i * pixelWidth + i);
                    ctx.stroke();
                }

                for (var pixel in pixels) {
                    x = pixel % dimensions.width + 1;
                    y = Math.trunc(pixel  / dimensions.width) + 1;

                    x = ((pixelWidth * x) + x) - (pixelWidth / 2);
                    y = ((pixelWidth * y) + y) - (pixelWidth / 2);

                    ctx.beginPath();
                    ctx.arc(x, y, pixelWidth / 2, 0, 2 * Math.PI);
                    ctx.stroke();
                }
            }

            jQuery("#run").click(function () {
                run();
            })

        </script>
    </body>
</html>


{{--<canvas id="pool" width="200px" height="200px"></canvas>--}}

{{--<script>--}}
{{--    var canvas = document.getElementById('pool');--}}
{{--    var ctx = canvas.getContext('2d');--}}
{{--    ctx.fillStyle = 'rgb(225, 225, 225, 225)';--}}
{{--    ctx.fillRect(0, 0, 150, 150);--}}

{{--    //ctx.fillStyle = 'rgb(225)';--}}

{{--    // ctx.beginPath();--}}
{{--    // ctx.moveTo(0, 0);--}}
{{--    // ctx.lineTo(0, 150);--}}
{{--    // ctx.lineTo(150, 150);--}}
{{--    // ctx.lineTo(150, 0);--}}
{{--    // ctx.lineTo(0, 0);--}}
{{--    // ctx.stroke();--}}
{{--</script>--}}