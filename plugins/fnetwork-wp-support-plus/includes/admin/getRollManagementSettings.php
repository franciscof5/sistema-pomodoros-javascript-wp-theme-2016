<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$cu = wp_get_current_user();
if (!$cu->has_cap('manage_options')) die();

global $wp_roles;
$userRoles=$wp_roles->roles;
$roleManage=get_option( 'wpsp_role_management' );

?>
<br>
<span class="label label-info wpsp_title_label"><?php _e('Agent Capabilities','wp-support-plus-responsive');?></span><br><br>
<small><code>*</code><?php _e('This will add','wp-support-plus-responsive');?> <b><?php _e('Support Agent','wp-support-plus-responsive');?></b> <?php _e('capabilities to your existing user roles','wp-support-plus-responsive');?></small><br>
<table>
<?php 
foreach ($userRoles as $roleSlug=>$role){
	if($roleSlug=='administrator' || $roleSlug=='wp_support_plus_agent' || $roleSlug=='wp_support_plus_supervisor') continue;
	?>
	<tr>
		<td id="cmbEmail_admin_new_ticket"><input <?php echo (is_numeric(array_search($roleSlug,$roleManage['agents'])))?'checked="checked"':'';?> type="checkbox" name="agentRole[]" value="<?php echo $roleSlug;?>"/></td>
    	<td id="cmbEmail_admin_new_ticket_label"><?php _e($role['name'],'wp-support-plus-responsive');?></td>
	</tr>
	<?php 
}
?>
</table>
<hr>

<span class="label label-info wpsp_title_label"><?php _e('Supervisor Capabilities','wp-support-plus-responsive');?></span><br><br>
<small><code>*</code><?php _e('This will add','wp-support-plus-responsive');?> <b><?php _e('Support Supervisor','wp-support-plus-responsive');?></b> <?php _e('capabilities to your existing user roles','wp-support-plus-responsive');?></small><br>
<table>
<?php
$userRoles=$wp_roles->roles; 
foreach ($userRoles as $roleSlug=>$role){
	if($roleSlug=='administrator' || $roleSlug=='wp_support_plus_agent' || $roleSlug=='wp_support_plus_supervisor') continue;
	?>
	<tr>
		<td id="cmbEmail_admin_new_ticket"><input <?php echo (is_numeric(array_search($roleSlug,$roleManage['supervisors'])))?'checked="checked"':'';?> type="checkbox" name="supervisorRole[]" value="<?php echo $roleSlug;?>"/></td>
    	<td id="cmbEmail_admin_new_ticket_label"><?php _e($role['name'],'wp-support-plus-responsive');?></td>
	</tr>
	<?php 
}
?>
</table>
<hr>
<button class="btn btn-success" onclick="setRoleManagement();"><?php _e('Save Settings','wp-support-plus-responsive');?></button>