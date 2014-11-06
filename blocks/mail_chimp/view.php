<?php defined('C5_EXECUTE') or die('Access Denied.');

echo "<h1>" . t('Newsletter') . "</h1>";

if (is_array($errorArray)) {
    foreach ($errorArray as $msg) {
        echo "<p style=\"color:red;\">$msg</p>";
    }
} elseif ($subscribed) {
    echo "<p style=\"color:green;\">Thanks!</p>";
}
?>

<form method="post" action="<?php echo $this->action('mc_subscribe')?>">
    <input type="email" name="email" value="" placeholder="<?php echo t('Email adress'); ?>"> 
    <input type="submit" value="<?php echo t('Subscribe'); ?>">
    <?php echo $form->hidden('ccm_token', $token); ?>
</form>
