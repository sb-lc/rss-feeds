<div class="msg"><?php echo $msg; ?></div>
<form action="?controller=posts&action=edit" method="post">
    <label>Enter valid url:<input name="url" type="text" value="<?php echo $url ?>"></label>
    <input name="id" type="hidden" value="<?php echo $id ?>">
    <input type="submit">
</form>

