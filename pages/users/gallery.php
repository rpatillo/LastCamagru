
<?php

    function debug($value)
    {
        echo '<pre>' . print_r($value, true) . '</pre>';
    }


    $auth = new \Core\Auth\Photos(App::getInstance()->getDb());
    $result = $auth->printPic();

foreach($result as $post) : ?>
    <img class="bigpict" id="myBtn<?=$post->id?>" src="<?=$post->photo?>" />
    <div name="divimg" id="myModal" class="modal">
        <div class="modal-content">
            <div style="min-width: 40%;">
                <img src="<?=$post->photo?>" />
                <div>
                    <div>
                        <p> Photo by <strong><?= $post->username ?></strong> </p>
                        <form method='post'>
                            <input type="hidden" name="user" value="<?= $_SESSION['auth'];?>">
                            <input type="hidden" name="owner" value="<?= $post->username; ?>">
                            <input type="hidden" name="id_photo" value="<?= $post->id;?>">
                            Comment:<br />
                            <textarea name="text"></textarea>
                            <br />
                            <button name="subbtn">Envoyer</button>
                        </form>
                    </div>
                    <div>
                        <img name="like" class='photos' style="max-width: 10%" src="/img/like.png">
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
<?PHP endforeach;?>

<script src="JS/Gallery.js"></script>