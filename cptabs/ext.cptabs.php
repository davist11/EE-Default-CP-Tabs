<?php

class Cptabs_ext {
    
    var $name = 'CP Default Tabs';
    var $version = '1.0.0';
    var $description = 'Add in default tabs for new members';
    var $settings_exist = 'y';
    var $docs_url = 'http://github.com/davist11/EE-Default-CP-Tabs';
    
    var $settings = array();
    var $settings_default = array(
      'new_tabs'  =>  ''
    );
    
    function settings()
    {
      $settings['new_tabs'] = array('t', null, $this->settings_default['new_tabs']);
      return $settings;
    }
    
    
    // -------------------------------
    //   Constructor - Extensions use this for settings
    // -------------------------------
    
    function Cptabs_ext($settings='')
    {
        $this->settings = $settings;
        $this->EE =& get_instance();
    }
    // END
    
    
    function cp_members_member_create($member_id, $data)
    {
      $this->EE->db->update('exp_members',
                            array(
                              'quick_tabs' => $this->settings['new_tabs']
                            ),
                            "member_id = {$member_id}");
  	}
  	
    
    // -------------------------------
    //   Activate Extension
    // -------------------------------
    function activate_extension()
    {

      $data = array(
        'class'       => 'Cptabs_ext',
        'hook'        => 'cp_members_member_create',
        'method'      => 'cp_members_member_create',
        'settings'    => serialize($this->settings_default),
        'priority'    => 10,
        'version'     => $this->version,
        'enabled'     => 'y'
      );

      // insert in database
      $this->EE->db->insert('exp_extensions', $data);

    }

    // -------------------------------
    //   Disable Extension
    // -------------------------------
    function disable_extension()
    {
      $this->EE->db->where('class', 'Cptabs_ext');
      $this->EE->db->delete('exp_extensions');
    }    

}
// END CLASS