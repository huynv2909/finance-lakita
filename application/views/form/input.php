<input
   <?php
      foreach ($properties as $key => $value) {
         echo $key . '="' . $value . '"';
      }
   ?>
>
<!-- GUIDE
   $data = array(
      'properties' => array(
         'class' => 'className',
         'id' => 'idName',
         ...
      )
   );
 -->
