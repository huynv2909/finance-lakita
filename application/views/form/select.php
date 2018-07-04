<select
   <?php
      foreach ($properties as $key => $value) {
         echo $key . '="' . $value . '"';
      }
    ?>
>
   <?php foreach ($options as $option): ?>
      <option
         <?php
            foreach ($option as $key => $value) {
               if ($key != 'innerHTML') echo $key . '="' . $value . '"';
            }
          ?>
      ><?php echo $option['innerHTML']; ?></option>
   <?php endforeach; ?>
</select>
<!-- Guide
   $data = array(
      'properties' = array(
         'class' => 'className',
         'id' => 'idName',
         'style' => '...',
         ...
      ),
      'options' = array(
         array(
            'innerHTML' => 'optionInnerHtml',
            'value' => '2',
            'class' => 'className'
            ...
         ),
         array(
            'innerHTML' => 'optionInnerHtml',
            'value' => '2',
            'class' => 'className'
            ...
         ),
         ....
      )
   );
 -->
