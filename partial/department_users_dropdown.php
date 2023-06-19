<option value="">Select User</option>
<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
foreach ($users as $data) { ?>
<option value="<?php echo $data->id; ?>"><?php echo $data->name.'('. getDesignationByUserId($data->id).')'; ?></option>
<?php } ?>

