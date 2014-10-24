<?php defined('C5_EXECUTE') or die('Access Denied.');

use \Concrete\Core\Validation\CSRF\Token;

$token = id(new Token)->generate('mail_chimp');

echo "<h1>" . t('Newsletter') . "</h1>";
echo "<p>There are " . $listsTotal . " lists at mailchimp.com. We'll use this in the block add form.</p>";
echo "<p>" . $message . "</p>"; //TODO give the user a feedback
?>

<form method="post" action="<?php echo $this->action('mc_subscribe')?>">
    <input type="email" name="email" value="" placeholder="Email adress"> 
    <input type="submit" value="Subscribe">
    <?php echo $form->hidden('ccm_token', $token); ?>
</form>
