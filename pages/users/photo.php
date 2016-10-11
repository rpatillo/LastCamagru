<?PHP
$auth = new \Core\Auth\Photos(App::getInstance()->getDb());
$result = $auth->printPic($_SESSION['auth']);
?>
<article>
    <button id="b_video">Video Mode</button>
    <button id="b_upload">Upload Mode</button>
    <br />
    <div id="image_area">
        <video id="video"></video>
        <canvas id="feed"></canvas>
        <canvas id="canvas"></canvas>
        </br>
    </div>
    <button id="startbutton">Take a picture</button>
    <button id="savebutton">Save</button>
    <br />
    <label>Image File:</label><br/>
    <input type="file" id="imageLoader" name="imageLoader"/>
<!--    <canvas id="imageCanvas"></canvas>-->
    <br />

    <div id="result"></div>

    <br/>
    <br/>
    <br/>

    <input type="range" id="myRangeX" value="90">
    <input type="range" id="myRangeY" value="90">
    <div>
        <form style="display: inline-flex;">
            <div>
                <img class='photos' id="photo1" src="public/img/photo.png" >
                <input type="radio" id="p1" name="r_btn" value="1">
            </div>
            <div>
                <img class='photos' id="photo2" src="public/img/hat.png" style="width: 130px;">
                <input type="radio" id="p2" name="r_btn" value="2">
            </div>
            <div>
                <img class='photos' id="photo3" src="public/img/Eyes.png">
                <input type="radio" id="p3" name="r_btn" value="3">
            </div>

        </form>
    </div>
</article>

<aside id="aside" style="max-height: 750px; overflow-y:scroll; width: 43%">
    Clic to delete.
    <br />
    <?PHP foreach($result as $post) : ?>
    <img src="<?=$post->photo?>" name="onclick_del" id="<?=$post->id?>"/>
    <?PHP endforeach;?>
</aside>

<script src="public/JS/JSphoto.js"></script>

