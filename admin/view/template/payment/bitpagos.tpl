<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
    <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">      
        <tr>
            <td><?php echo $text_status; ?></td>
            <td>
              <select name="bitpagos_status">
                <?php if ($bitpagos_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </td>
        </tr>
        <tr>
            <td><?php echo $text_account_id ?></td>
            <td><input type="text" name="bitpagos_account_id" value="<?php echo $bitpagos_account_id; ?>" /></td>
        </tr>
        <tr>
            <td><?php echo $text_api_key ?></td>
            <td><input type="text" name="bitpagos_api_key" value="<?php echo $bitpagos_api_key; ?>" /></td>
        </tr>
        <tr>
            <td><?php echo $text_order_status; ?></td>
            <td>
              <label>Pending</label>              
              <!--
              <select name="bitpagos_order_status_id_old">
                <?php foreach ($order_statuses as $order_status) { ?>
                    <?php
                    $selected = ( $order_status['order_status_id'] === $bitpagos_order_status_id ) ? 'selected' : '';
                    ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" <?php echo $selected?>>
                        <?php echo $order_status['name']; ?>
                    </option>
                <?php } ?>
              </select>
              -->
            </td>
          </tr>
        <tr>
            <td><?php echo $text_status_transaction; ?></td>
            <td>
              <select name="bitpagos_transaction_status">
                  <?php
                  foreach( $order_statuses as $status ) { ?>
                      <?php
                      $selected = ( $status['order_status_id'] === $bitpagos_transaction_status ) ? 'selected' : '';
                      ?>
                      <option value="<?php echo $status['order_status_id']; ?>" <?php echo $selected?> ><?php echo $status['name']; ?></option>
                  <?php } ?>
              </select>
            </td>
        </tr>
        <tr>
            <td><?php echo $text_ipn; ?></td>
            <td><?php echo $bitpagos_ipn_url; ?></td>
        </tr>
        <tr>
            <td><?php echo $text_post; ?></td>
            <td><?php echo $bitpagos_post_url; ?></td>
        </tr>

      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>