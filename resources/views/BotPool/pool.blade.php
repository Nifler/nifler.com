{{--<canvas id="pool" width="150" height="150"></canvas>--}}

{{--{{ $dimensions['width'] }}--}}

<button id="run">RUN</button>

<script>
    var url = "https://nifler.com/botpool/run";

    function run()
    {
        $.ajax({
            url: url
        })
            .done(function( data ) {
                console.log( 'ajax' );
            });
    }



</script>




{{--<script>--}}
{{--    var poolWith = (x * pixelR) + x + 1--}}

{{--    var dimensions = {{$dimensions}};--}}

{{--    var canvas = document.getElementById('pool');--}}
{{--    var ctx = canvas.getContext('2d');--}}
{{--    ctx.fillStyle = 'rgb(225, 225, 225, 225)';--}}
{{--    ctx.fillRect(0, 0, 150, 150);--}}

{{--    ctx.fillStyle = 'rgb(225)';--}}

{{--    ctx.beginPath();--}}
{{--    ctx.moveTo(0, 0);--}}
{{--    ctx.lineTo(0, 150);--}}
{{--    ctx.lineTo(150, 150);--}}
{{--    ctx.lineTo(150, 0);--}}
{{--    ctx.lineTo(0, 0);--}}
{{--    ctx.stroke();--}}
{{--</script>--}}