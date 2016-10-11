/**
 * Created by rpatillo on 9/13/16.
 */

(function () {

    var data = '';
    var x = '50';
    var y = '50';

    var streaming = false,
        video = document.querySelector('#video'),
        cover = document.querySelector('#cover'),
        canvas = document.querySelector('#canvas'),
        photo = document.querySelector('#photo'),
        startbutton = document.querySelector('#startbutton'),
        savebutton = document.querySelector('#savebutton'),
        modify = document.querySelector('#modify'),
        photo1 = document.querySelector('#photo1'),
        photo2 = document.querySelector('#photo2'),
        photo3 = document.querySelector('#photo3'),
        onclick_del = document.getElementsByName('onclick_del'),
        t_photo = [photo1, photo2, photo3],
        XVal = document.getElementById('myRangeX');
        YVal = document.getElementById('myRangeY');
        pict_add = document.getElementsByClassName('photos');
        r_btn = document.getElementsByName('r_btn');
        aside = document.getElementById('aside');
        width = 320;
        height = 0;
        navigator.getMedia = ( navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);
        navigator.getMedia(
        {
            video: true,
            audio: false
        },
        function (stream) {
            if (navigator.mozGetUserMedia) {
                video.mozSrcObject = stream;
            } else {
                var vendorURL = window.URL || window.webkitURL;
                video.src = vendorURL.createObjectURL(stream);
            }
            video.play();
        },
        function (err) {
            console.log("An error occured! " + err);
        }
    );

    video.addEventListener('canplay', function (ev) {
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth / width);
            video.setAttribute('width', width);
            video.setAttribute('height', height);
            feed.setAttribute('width', width);
            feed.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            streaming = true;

        }
    }, false);
    savebutton.className = 'hidden';
    startbutton.addEventListener('click', function (ev) {
        savebutton.className = '';
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(feed, 0, 0, width, height);
        data = canvas.toDataURL();
        ev.preventDefault();
    }, false);

    savebutton.addEventListener('click', function (ev) {
        var res = encodeURIComponent(data);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                document.getElementById('result').innerHTML = 'Success';
                aside.innerHTML = xhttp.responseText;
            }
        };
        xhttp.open("POST", "/public/includes/savepic.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send('photo=' + res + '&mX=' + x + '&mY=' + y + '&nb=' + select);
        ev.preventDefault();
    }, false);

    function test () {
        for (var i = 0; i < onclick_del.length; i++) {
            (function (i) {
                onclick_del[i].onclick = function (ev) {
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function () {
                        if (xhttp.readyState == 4 && xhttp.status == 200) {
                            document.getElementById('result').innerHTML = 'Deleted';
                            aside.innerHTML = xhttp.responseText;
                        }
                    };
                    xhttp.open("POST", "/public/includes/delpic.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send('id=' + this.id);
                    ev.preventDefault();
                };
            }(i));
        }
    }

    video.style.display = 'none';

    window.onload = function() {
        streamFeed_vid();
    };

    var b_video = document.querySelector('#b_video');
    var b_upload = document.querySelector('#b_upload');

    b_upload.style.display = 'none';
    b_video.addEventListener('click', function (ev) {
        streamFeed_vid();
    },false);

    b_upload.addEventListener('click', function (ev) {
        streamFeed_img();
    },false);

    function streamFeed_vid() {
        XVal = 100;
        var context = feed.getContext('2d');

        requestAnimationFrame(streamFeed_vid);
        context.drawImage(video, 0, 0, feed.width, feed.height);
        context.drawImage(t_photo[select - 1], x, y);
        test();
    };

    function streamFeed_img() {
        XVal = 100;
        var context = feed.getContext('2d');

        requestAnimationFrame(streamFeed_img);
        context.drawImage(img, 0, 0, feed.width, feed.height);
        context.drawImage(t_photo[select - 1], x, y);
        test();
    };

    XVal.addEventListener("mousemove", function () {
        x = this.value * 2;
    });

    YVal.addEventListener("mousemove", function () {
        y = this.value;
    });

    var select = 1;
    var prev = 0;
    for (var i = 0; i < r_btn.length; i++){
        (function(i){
            r_btn[i].onclick = function() {
                if(this !== prev) {
                    prev = this;
                }
                select = this.value;
            };
        }(i));
    }

      // UPLOAD PART
    var imageLoader = document.getElementById('imageLoader');
    imageLoader.addEventListener('change', handleImage, false);
    var ctxf = feed.getContext('2d');

    var img;
    img = null;
    function handleImage(e) {
        var fileList = this.files;
        var blob = fileList[0];
        var fileReader = new FileReader();
        fileReader.onloadend = function(e) {
            var arr = (new Uint8Array(e.target.result)).subarray(0, 4);
            var test = (new Uint8Array(e.target.result));
            var header = "";
            for(var i = 0; i < arr.length; i++) {
                header += arr[i].toString(16);
            }
            if (header == 'ffd8ffe0' || header == '89504e47') {
                img = new Image();
                img.onload = function() {
                    b_upload.style.display = '';
                    ctxf.drawImage(img, 0, 0);
                    streamFeed_img();
                    window.onload = null;
                }
                img.src = URL.createObjectURL(blob);
            }

        };
        fileReader.readAsArrayBuffer(blob);
    }
})();

