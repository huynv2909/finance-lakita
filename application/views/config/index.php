<form class="" method="post">
   <?php foreach ($configs_db as $item): ?>
      <label for="<?php echo $item->name; ?>"><?php echo $item->description; ?></label>
      <input type="checkbox" name="config_<?php echo $item->id; ?>" id="<?php echo $item->name; ?>" value="" <?php if ($item->value == 1) echo 'checked'; ?>>
      <input type="hidden" name="id" value="<?php echo $item->id ?>">
   <?php endforeach; ?>
   <input type="hidden" name="have_changed" value="1">
   <input type="submit" name="ok" value="Thay đổi">
</form>
