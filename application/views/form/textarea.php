<textarea
   <?php
      foreach ($properties as $key => $value) {
         echo $key . '="' . $value . '"';
      }
   ?>
></textarea>
