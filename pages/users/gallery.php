
<?php

function debug($value)
{
    echo '<pre>' . print_r($value, true) . '</pre>';
}


$auth = new \Core\Auth\Photos(App::getInstance()->getDb());

$nbPict = $auth->nb_pict();
foreach ($nbPict as $bla) {
    $tmp = $bla->nbPict;
}
$perPage = 9;
$nbPage = ceil($tmp/$perPage);
$cPage = 1;

if (isset($_GET['n'])) {
    $cPage = $_GET['n'];
} else {
    $cPage = 1;
}

$result = $auth->printPic(NULL, $cPage, $perPage);

foreach($result as $post) : ?>
    <img class="bigpict" id="myBtn<?=$post->id?>" src="<?=$post->photo?>" />
    <div name="divimg" id="myModal" class="modal">
        <div class="modal-content">
            <div style="min-width: 40%;">
                <img src="<?=$post->photo?>" />
                <div>
                    <div>
                        <p> Photo by <strong><?= $post->username ?></strong> </p>
                        <?PHP if (isset($_SESSION['auth'])) : ?>
                        <form method='post'>
                            <input type="hidden" name="user" value="<?= $_SESSION['auth'];?>">
                            <input type="hidden" name="owner" value="<?= $post->username; ?>">
                            <input type="hidden" name="id_photo" value="<?= $post->id;?>">
                            Comment:<br />
                            <textarea name="text"></textarea>
                            <br />
                            <button name="subbtn">Envoyer</button>
                        </form>
                        <?PHP endif ?>
                    </div>
                    <div>
                        <?PHP if (isset($_SESSION['auth'])) : ?>
                        <img name="like" class='photos' style="max-width: 10%" src="/img/like.png">
                        <?PHP endif ?>
                        <div name="nb_like"><?= $auth->printLikes($post->id); ?> like this.</div>
                    </div>
                </div>
            </div>
            <div style="min-width: 58%;">
                <table name="tablegal">
                    <?php
                    $com = $auth->printCom($post->id);
                    foreach ($com as $posts) : ?>
                        <tr>
                            <td><strong><?= $posts->username ?> : </strong></td>
                            <td><?= ' ' . $posts->comment ?></td>
                        </tr>
                    <?PHP endforeach;?>
                </table>
            </div>
            <div>
                <span name="bclose" class="close">x</span>
            </div>
        </div>
    </div>
<?PHP endforeach;
echo "<br />";
echo "<br />";
?>
<div style="position:relative; text-align: center;">
    <?PHP
for ($i = 1; $i <= $nbPage; $i++) {
    echo " <a href=\"index.php?p=gallery&n=$i\">$i</a> /";
}
?>
</div>



<script src="JS/Gallery.js"></script>