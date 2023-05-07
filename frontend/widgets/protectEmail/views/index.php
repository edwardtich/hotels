<?php

/* @var $this \yii\web\View */
/* @var $email string */
/* @var $random string */

$email = explode('@', $email);
?>

<script type="text/javascript">
    var e<?= $random ?> = '<?= $email[0] ?>' + '@' + '<?= $email[1] ?>';

    document.write('<a <?php if (YII_ENV === 'dev') : ?>style="outline 1px dotted red"<?php endif; ?> href="mailto:' + e<?= $random ?> + '">' + e<?= $random ?> + '</a>');
</script>
