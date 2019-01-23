<?php $total = 0; ?>
<div class="container-fluid">
   <h3>Tổng: <span id="total"></span> VND</h3>
   <?php foreach ($data_compilation as $row): ?>
      <table class="data-unit" border="1">
         <tr title="Chứng từ gốc">
            <td colspan="4" width="30%">Đã thêm: <?php echo $row->date; ?></td>
            <td  width="50%"><?php echo $row->content_v; ?></td>
            <td class="text-right"  width="20%"><?php echo number_format($row->value_v, 0, ",", "."); ?></td>
         </tr>
         <tr title="Bút toán">
            <td colspan="2" class="text-center"><?php echo $row->tot; ?></td>
            <td colspan="2" class="text-center"><?php echo $row->toa; ?></td>
            <td><?php echo $row->content_a; ?></td>
            <td class="text-right"><?php echo number_format($row->value_a, 0, ",", "."); ?></td>
         </tr>
         <tr title="Đã phân bổ">
            <td colspan="4" class="text-center"><a href="<?php echo $this->routes['accountingentry_index']; ?>?code=<?php echo $row->code; ?>">Xem bút toán</a></td>
            <td><?php echo $row->content_d; $total += $row->value_d; ?></td>
            <td class="text-right" style="color: blue;"><?php echo number_format($row->value_d, 0, ",", "."); ?></td>
         </tr>
      </table>
   <?php endforeach; ?>
   <script type="text/javascript">
      $('#total').html(convertToCurrency('<?php echo $total; ?>'));
   </script>
</div>
