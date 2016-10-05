<?PHP
$auth = new \Core\Auth\Photos(App::getInstance()->getDb());
$result = $auth->printPic($_SESSION['auth']);
?>
<article>
    <div id="image_area">
        <video id="video"></video>
        <canvas id="feed"></canvas>
        <canvas id="canvas"></canvas>
        </br>
    </div>
    <button id="startbutton">Take a picture</button>
    <button id="savebutton">Save</button>
    <br />

    <div id="result"></div>

    <br/>
    <br/>
    <br/>

    <input type="range" id="myRangeX" value="90">
    <input type="range" id="myRangeY" value="90">
    <div>
        <form>
            <div>
                <img class='photos' id="photo1" src="/img/photo.png" >
                <input type="radio" id="p1" name="r_btn" value="1">
            </div>
            <div>
                <img class='photos' id="photo2" src="/img/hat.png" style="width: 130px;">
                <input type="radio" id="p2" name="r_btn" value="2">
            </div>
            <div>
                <img class='photos' id="photo3" src="/img/Eyes.png">
                <input type="radio" id="p3" name="r_btn" value="3">
            </div>

        </form>
    </div>
</article>

<aside id="aside" style="max-height: 750px; overflow-y:scroll; width: 43%">
    <br />
    <?PHP foreach($result as $post) : ?>
    <img src="<?=$post->photo?>" name="onclick_del" id="<?=$post->id?>"/>
    <?PHP endforeach;?>
</aside>

<script src="JS/JSphoto.js"></script>

