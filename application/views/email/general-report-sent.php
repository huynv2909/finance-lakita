<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Bao Cao Tong Hop</title>
    <style media="screen">
      #table-main tr td {
        padding: 5px;
      }
    </style>
  </head>
  <body>
    <table align="center" cellpadding="0" cellspacing="0" width="600" style="background-color: aliceblue; margin: auto;">
      <tr style="background-color: black;">
       <td>
        <img src="https://crm.lakita.vn/style/img/logo5.png" alt="Lakita logo" style="width: 150px; padding: 10px;">
       </td>
      </tr>
      <tr style="background-color: black;">
        <td>
          <h1 style="text-align: center; color: #187533;">Lakita Finance Management System</h1>
        </td>
      </tr>
      <tr>
        <td>
          <h2 style="color: brown; text-align: center;">Số liệu hàng kỳ từ hệ thống quản trị tài chính</h2>
          <h4 style="margin-left: 30px;">Tính từ <i><?php echo $min_date; ?></i> đến <i><?php echo $max_date; ?></i></i> theo TOA</h4>
        </td>
      </tr>
      <tr>
        <td>
            <table id="table-main" style="margin: auto; padding: 15px;">
              <tr>
                <td>Tổng doanh thu</td>
                <td><?php echo number_format($revenue, 0, ",", ".") . ' đ'; ?></td>
              </tr>
              <tr>
                <td>Tổng chi phí</td>
                <td><?php echo number_format($cost, 0, ",", ".") . ' đ'; ?></td>
              </tr>
              <tr>
                <td>Tổng số chứng từ mới:</td>
                <td><?php echo number_format($new_records, 0, ",", "."); ?></td>
              </tr>
            </table>
        </td>
      </tr>

      <tr style="background-color: black;">
        <td>
          <h3 style="text-align: center; color: #187533;">Lakita - Cùng bạn vươn xa</h3>
        </td>
      </tr>
    </table>
  </body>
</html>
