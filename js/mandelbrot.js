jQuery(function ($) {

    var x = -0.5;
    var y = 0;
    var s = 1;
    var l = 100;

    var jcrop;
    $("#figure").Jcrop({
	onSelect: zoom
    }, function () {
	jcrop = this;
    });

    function zoom(c) {
	if (Math.abs(c.x2 - c.x) < 20 && Math.abs(c.y2 - c.y) < 20) {
	    l *= 2;
	    draw();
	} else {
	    var xmin = x - s * 1.5;
	    var xmax = x + s * 1.5;
	    var ymin = y - s;
	    var ymax = y + s;
	    x = xmin + (xmax - xmin) * (c.x + c.x2) / 1800;
	    y = ymax + (ymin - ymax) * (c.y + c.y2) / 1200;
	    s = s * Math.max(Math.abs(c.x2 - c.x) / 900, Math.abs(c.y2 - c.y) / 600);
	    draw();
	}
    }

    function draw() {
	var url = "mandelbrot.php?x=" + x + "&y=" + y + "&s=" + s + "&l=" + l;
	var image = new Image();
	image.onload = function () {
	    $("img").attr("src", url);
	    jcrop.release();
	}
	image.src = url;
    }

    draw();
});
