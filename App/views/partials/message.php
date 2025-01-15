<?php
  use Framework\Session;
?>

<?php $sucessMsg = Session::getFlashMsg('success_message'); ?>

<?php if ($sucessMsg) : ?>
    <div class='message bg-green-100 p-3 my-3'> 
      <?= $sucessMsg ?>
    </div>
<?php endif ?>

<?php $errorMsg = Session::getFlashMsg('error_message'); ?>

<?php if ($errorMsg) : ?>
    <div class='message bg-red-100 p-3 my-3'> 
      <?= $errorMsg ?>
    </div>
<?php endif ?>