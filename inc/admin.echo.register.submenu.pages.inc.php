<?php
	/*admin only*/
	add_submenu_page('edit.php?post_type='.$this->pluginSlug.'',$this->pluginName.' '.__('Manage Global Settings', $this->pluginLocale),__('Settings', $this->pluginLocale), 'manage_options', $this->pluginSlug.'-settings', array($this, 'admin_manage_settings'));
	add_submenu_page('edit.php?post_type='.$this->pluginSlug.'',$this->pluginName.' '.__('Manage Order Settings', $this->pluginLocale),__('&middot; Order Settings', $this->pluginLocale), 'manage_options',  $this->pluginSlug.'-order-settings', array($this, 'admin_manage_order_settings'));
	add_submenu_page('edit.php?post_type='.$this->pluginSlug.'',$this->pluginName.' '.__('Manage Gateways', $this->pluginLocale),__('&middot; Gateways', $this->pluginLocale), 'manage_options',  $this->pluginSlug.'-gateways', array($this, 'admin_manage_gateways'));
	add_submenu_page('edit.php?post_type='.$this->pluginSlug.'',$this->pluginName.' '.__('Manage Order Form', $this->pluginLocale),__('&middot; Order Form Settings', $this->pluginLocale), 'manage_options',  $this->pluginSlug.'-order-form', array($this, 'admin_manage_order_form'));
	add_submenu_page('edit.php?post_type='.$this->pluginSlug.'',$this->pluginName.' '.__('Manage Opening Times', $this->pluginLocale),__('&middot; Opening Times', $this->pluginLocale), 'manage_options', $this->pluginSlug.'-opening-times', array($this, 'admin_manage_opening_times'));
	add_submenu_page('edit.php?post_type='.$this->pluginSlug.'',$this->pluginName.' '.__('Manage Meal Sizes', $this->pluginLocale),__('&middot; Meal Sizes', $this->pluginLocale), 'manage_options',  $this->pluginSlug.'-meal-sizes', array($this, 'admin_manage_meal_sizes'));
	add_submenu_page('edit.php?post_type='.$this->pluginSlug.'',$this->pluginName.' '.__('Manage Additives', $this->pluginLocale),__('&middot; Additives', $this->pluginLocale), 'manage_options',  $this->pluginSlug.'-additives', array(&$this,'admin_manage_additives'));
	add_submenu_page('edit.php?post_type='.$this->pluginSlug.'',$this->pluginName.' '.__('Manage Layout', $this->pluginLocale),__('&middot; Layout', $this->pluginLocale), 'manage_options', $this->pluginSlug.'-layout', array($this, 'admin_manage_layout'));
	add_submenu_page('edit.php?post_type='.$this->pluginSlug.'',$this->pluginName.' '.__('Manage Localization', $this->pluginLocale),__('&middot; Localization', $this->pluginLocale), 'manage_options', $this->pluginSlug.'-localization', array($this, 'admin_manage_localization'));
	/*admins and editors*/
	add_submenu_page('edit.php?post_type='.$this->pluginSlug.'',$this->pluginName.' '.__('Manage Order History', $this->pluginLocale),__('Order History', $this->pluginLocale), 'read_private_pages',  $this->pluginSlug.'-order-history', array($this, 'admin_manage_order_history'));

?>