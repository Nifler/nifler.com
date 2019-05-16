<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    </head>
    <style>
        #wrapper{
            width: 1200px;
            background-color: #eeeeee;
        }
        .left{
            float: left;
        }
        .right{
            float:right;
        }
        .clr{
            clear: both;
        }
    </style>
    <body>
        <div id="wrapper">
            <div class="left">
                <canvas id="pool"></canvas>
                <br/>
                <button id="run">RUN</button>
                <button id="kill">KILL</button>
            </div>
            <div class="left">
                <div id="botinfo"></div>
            </div>
            <div class="clr"></div>
        </div>

        <script>
            var url = "https://nifler.com/botpool/run";
            var urlKill = "https://nifler.com/botpool/renew";

            function run()
            {
                jQuery.ajax({
                    url: url
                })
                    .done(function( data ) {
                        var res = JSON.parse(data);
                        buildPool(res.dimensions, res.pixels);
                        setBotInfo( res.population );
                    });
            }

            function setBotInfo(population) {
                $("#botinfo").html("");
                for (var bot of population) {
                    var msg = "<p>" + bot.properties.id + ": energy = " + bot.properties.energy + "</p>";
                    $( "#botinfo" ).append( msg );
                }
            }

            function buildPool(dimensions, pixels) {
                var pixelWidth = 20;
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
                    // console.log(pixels, pixel, pixels[pixel]);
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
            });
            jQuery("#kill").click(function () {
                jQuery.ajax({
                    url: urlKill
                });
            })

        </script>
    </body>
</html>
