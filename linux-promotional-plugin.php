<?php
/*
Plugin Name: Linux Promotional Plugin
Plugin URI: http://www.itsqueeze.com/2011/06/wordpress-linux-promotional-plugin/
Description: Displays a notice to Windows and Mac users about the benefits of Linux, and encourages them to follow a link to a Linux Distro website for more information. Configure your warning at the plugin <a href="options-general.php?page=linux-promotional-plugin/linux-promotional-plugin.php">settings</a> page.
Author: Timothy Arceri
Version: 1.4
Author URI: http://www.itsqueeze.com
*/

/*
Copyright 2011  Timothy Fridey  ( email: tim@itsqueeze.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// GLOBAL VARIABLES
$linuxProPlg_domain = 'linux-promotional-plugin';
$linuxProPlg_url = WP_PLUGIN_URL . '/linux-promotional-plugin';

// DEFAULT OPTIONS
function linProPlg_defaults() {
	$setup = array(
		'name' => 'Linux Promotional Plugin',
		'version' => '1.4',
		'site' => 'http://www.itsqueeze.com/2011/06/wordpress-linux-promotional-plugin/',
		'type' => 'top',
		'test' => 'false',
		'headcomm' => 'false',
		'jstest' => 'false',
		'mac' => 'true',
		'windows' => 'true',
		'texts' => array(
			't1' => 'ALERT!',
			't2' => 'You are using a proprietary Operating System such as Windows or Macs. Due to their ongoing support costs, upgrade costs and lack of support for Open Standards it is highly recommended that you look into the advantages of a modern Linux Operating System with free upgrades for life and support for Open Standards.',
			't3' => 'Click here to ignore and continue to website :)',
		),
		'distros' => array(
                        'fedora' => 'true',
			'ubuntu' => 'false',
			'linuxMint' => 'false',
			'centos' => 'false',
		),
		'distrourl' => array(
			'ubuntu' => 'http://www.ubuntu.com/ubuntu/why-use-ubuntu',
			'linuxMint' => 'http://www.linuxmint.com/about.php',
			'centos' => 'http://www.centos.org/',
                        'fedora' => 'http://fedoraproject.org/en/features/',
		)
	);
	return $setup;
}

// INITIALIZATION - locales @ /lang/
if ( is_admin() ) {
	add_action('init', 'linProPlg_init');
}
function linProPlg_init() {
	global $linuxProPlg_domain;
	load_plugin_textdomain($linuxProPlg_domain, '/wp-content/plugins/linux-promotional-plugin/lang/');
}

// ACTIVATION - when plugin is activated
register_activation_hook(__FILE__, 'linProPlg_activate');
function linProPlg_activate() {
	$opt = get_option('linProPlg_options');
	if (!is_array($opt)) {
		$options = linProPlg_defaults();
		add_option('linProPlg_options', $options);
	} else {
		$options = linProPlg_defaults();
		if ( $opt['version'] != $options['version'] ) {
			$options['texts']['t1'] = $opt['texts']['t1'];
			$options['texts']['t2'] = $opt['texts']['t2'];
			$options['texts']['t3'] = $opt['texts']['t3'];
			update_option("linProPlg_options", $options);
		}
	}
}

// DEACTIVATION - when plugin is deactivated
register_deactivation_hook(__FILE__, 'linProPlg_deactivate');
function linProPlg_deactivate() {
	//delete_option('linProPlg_options');
}

// HEADERS - blog header
add_action('template_redirect', 'linProPlg_Banner_head_init'); // js head
function linProPlg_Banner_head_init() {
	$opt = get_option('linProPlg_options');
	if ( $opt['type'] == 'top' ) {
		linProPlg_head_top();
	} else if ( $opt['type'] == 'center' ) {
		linProPlg_head_center();
	}
}
add_action('wp_head', 'linProPlg_head'); // normal head
function linProPlg_head() {
	$opt = get_option('linProPlg_options');
	// if head comment enabled add debug comments to header
	if ( $opt['headcomm'] == 'true' ) { echo '<!-- IE6WDebug Type:'.$opt['type'].' Test:'.$opt['test'].' JSTest:'.$opt['jstest'].' -->'; }
}

function runLinPPlgLocalizeScript($linuxProPlg_url, $opt, $localizeScript){
	wp_localize_script($localizeScript, 'linProPlg', array(
			'url' => $linuxProPlg_url,
			'test' => $opt['test'],
			'jstest' => $opt['jstest'],
			'mac' => $opt['mac'],
			'windows' => $opt['windows'],
			't1' => $opt['texts']['t1'],
			't2' => $opt['texts']['t2'],
			't3' => $opt['texts']['t3'],
			'ubuntu' => $opt['distros']['ubuntu'],
			'centos' => $opt['distros']['centos'],
			'linuxMint' => $opt['distros']['linuxMint'],
                        'fedora' => $opt['distros']['fedora'],
			'ubuntuURL' => $opt['distrourl']['ubuntu'],
			'centosURL' => $opt['distrourl']['centos'],
			'linuxMintURL' => $opt['distrourl']['linuxMint'],
                        'fedoraURL' => $opt['distrourl']['fedora'],
		));
}

// HEADER: TOP
function linProPlg_head_top() {
	global $linuxProPlg_url;
	$opt = get_option('linProPlg_options');

	wp_enqueue_script('jquery');
	wp_enqueue_script('osDetect', $linuxProPlg_url . '/js/osDetect.js');
	wp_enqueue_script('linProPlg_head_top', $linuxProPlg_url . '/js/linProPlg_top.js', array('jquery','osDetect'));
	runLinPPlgLocalizeScript($linuxProPlg_url, $opt, 'linProPlg_head_top');
}

// HEADER: CENTER
function linProPlg_head_center() {
	global $linuxProPlg_url;
	$opt = get_option('linProPlg_options');
	
	wp_enqueue_script('jquery');
	wp_enqueue_script('osDetect', $linuxProPlg_url . '/js/osDetect.js');
	wp_enqueue_script('linProPlg_head_center', $linuxProPlg_url . '/js/linProPlg_center.js', array('jquery','osDetect'));
	runLinPPlgLocalizeScript($linuxProPlg_url, $opt, 'linProPlg_head_center');
}

// OPTIONS PAGE
if ( is_admin() ) {
	add_action('admin_menu', 'linProPlg_options');
}
function linProPlg_options() { // options menu
	$page = add_options_page(__('Linux Promotional Plugin Options', $linuxProPlg_domain), __('Linux Promo Plugin', $linuxProPlg_domain), 8, __FILE__, 'options_page');
	add_action("admin_print_scripts-$page", 'linProPlg_admin_js');
	add_action("admin_print_styles-$page", 'linProPlg_admin_css');
}
function linProPlg_admin_js() { // options js
	global $linuxProPlg_url;
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('linProPlg_options_js', $linuxProPlg_url . '/js/linProPlg_options.js', array('jquery-ui-tabs'));
}
function linProPlg_admin_css() { // options css
	global $linuxProPlg_url;
	wp_enqueue_style('linProPlg_tabs_css', $linuxProPlg_url . '/css/linProPlg_opt.css');
}
function options_page() { // options page
global $linuxProPlg_domain, $linuxProPlg_url;
$opt = get_option('linProPlg_options');
	if ( isset($_POST['update_options']) ) { // save options
	// tab 1
		$opt['type'] = $_POST['ie6w_type'];
		$opt['test'] = $_POST['ie6w_test'];
		$opt['mac'] = $_POST['macEnabled'];
		$opt['windows'] = $_POST['windowsEnabled'];
		$opt['distros']['ubuntu'] = $_POST['ubuntuEnabled'];
		$opt['distros']['centos'] = $_POST['centosEnabled'];
		$opt['distros']['linuxMint'] = $_POST['linuxMintEnabled'];
		if ( $_POST['ubuntuURL'] != "" ) { $opt['distrourl']['ubuntu'] = $_POST['ubuntuURL']; }
		if ( $_POST['centosURL'] != "" ) { $opt['distrourl']['centos'] = $_POST['centosURL']; }
		if ( $_POST['linuxMintURL'] != "" ) { $opt['distrourl']['linuxMint'] = $_POST['linuxMintURL']; }
                if ( $_POST['fedoraURL'] != "" ) { $opt['distrourl']['fedora'] = $_POST['fedoraURL']; }
	// tab 2
		if ( $_POST['ie6w_t1'] != "" ) { $opt['texts']['t1'] = $_POST['ie6w_t1']; }
		if ( $_POST['ie6w_t2'] != "" ) { $opt['texts']['t2'] = $_POST['ie6w_t2']; }
		if ( $_POST['ie6w_t3'] != "" ) { $opt['texts']['t3'] = $_POST['ie6w_t3']; }
	// tab 3
		$opt['headcomm'] = $_POST['ie6w_headcomm'];
		$opt['jstest'] = $_POST['ie6w_jstest'];
		update_option('linProPlg_options', $opt);
		$opt = get_option('linProPlg_options');
		echo '<div id="message" class="updated fade"><p><strong>' . __('Settings saved.', $linuxProPlg_domain) . '</strong></p></div>';
    } 
	if ( isset($_POST['reset_options']) ) { // reset options
		$opt = linProPlg_defaults();
		update_option('linProPlg_options', $opt);
		echo '<div id="message" class="updated fade"><p><strong>' . __('Default options loaded.', $linuxProPlg_domain) . '</strong></p></div>';
		$opt = get_option('linProPlg_options');
	} 
	if ( isset($_POST['delete_options']) ) { // delete options
		delete_option('linProPlg_options');
		echo '<div id="message" class="updated fade"><p><strong>' . __('Options deleted.', $linuxProPlg_domain) . '</strong></p></div>';
		$opt = get_option('linProPlg_options');
	}
	if ( $opt['jstest'] == 'true' && $opt['test'] == 'false' ) {
		echo '<div id="message" class="updated fade"><p><strong>' . __('Attention: JavaScript Test is On, but Test Mode is Off, JavaScript Test will not work.', $linuxProPlg_domain) . '</strong></p></div>';
	}
    ?>
<div class="wrap">
  <div class="icon32" id="icon-options-tux"><br/>
  </div>
  <h2><?php echo __('Linux Promotional Plugin Settings', $linuxProPlg_domain); ?></h2>
  <div id="tabs">
  <ul>
    <li><a href="#tabs-1"><?php echo __('Options', $linuxProPlg_domain); ?></a> |</li>
    <li><a href="#tabs-2"><?php echo __('Message', $linuxProPlg_domain); ?></a> |</li>
    <li><a href="#tabs-3"><?php echo __('Advanced', $linuxProPlg_domain); ?></a></li>
    <li>| <a href="#tabs-4"><?php echo __('Registry', $linuxProPlg_domain); ?></a></li>
  </ul>
  <form method="post" name="options" target="_self">
    <div id="tabs-1"><br/>
      <table width="100%" cellspacing="0" id="inactive-plugins-table" class="widefat">
        <thead>
          <tr>
            <th width="125"><?php echo __('Settings', $linuxProPlg_domain); ?></th>
            <th width="125">&nbsp;</th>
            <th><?php echo __('Description', $linuxProPlg_domain); ?></th>
          </tr>
        </thead>
        <tr>
          <td width="125"><?php echo __('Promotion Type', $linuxProPlg_domain); ?></td>
          <td width="125"><select name="ie6w_type">
              <option value="off" <?php if ( $opt['type'] == 'off' ) echo 'selected="selected"'; ?> />
              <?php echo __('Off', $linuxProPlg_domain); ?>
              </option>
              <option value="top" <?php if ( $opt['type'] == 'top' ) echo 'selected="selected"'; ?> />
              <?php echo __('Top', $linuxProPlg_domain); ?>
              </option>
              <option value="center" <?php if ( $opt['type'] == 'center' ) echo 'selected="selected"'; ?> />
              <?php echo __('Center', $linuxProPlg_domain); ?>
              </option>
            </select></td>
          <td><?php echo __('The warnings: <strong>Top</strong>, the discreet top bar. <strong>Center</strong>, the full screen one.', $linuxProPlg_domain); ?></td>
        </tr>
        <tr>
          <td width="125"><?php echo __('Test Mode', $linuxProPlg_domain); ?></td>
          <td width="125"><select name="ie6w_test">
              <option value="false" <?php if ( $opt['test'] == 'false' ) echo 'selected="selected"'; ?> />
              <?php echo __('Off', $linuxProPlg_domain); ?>
              </option>
              <option value="true" <?php if ( $opt['test'] == 'true' ) echo 'selected="selected"'; ?> />
              <?php echo __('On', $linuxProPlg_domain); ?>
              </option>
            </select></td>
          <td><?php echo __('Turn this <strong>On</strong> if you want to test the Warnings in any Operating System.', $linuxProPlg_domain); ?></td>
        </tr>
		 <thead>
          <tr>
            <th width="125"><?php echo __('Visitor OS to show promotion to.', $linuxProPlg_domain); ?></th>
            <th width="125">&nbsp;</th>
            <th><?php echo __('URL', $linuxProPlg_domain); ?></th>
          </tr>
        </thead>
        <tr>
          <td width="125">Windows</td>
          <td width="125"><select name="windowsEnabled">
              <option value="true" <?php if ( $opt['windows'] == 'true' ) echo 'selected="selected"'; ?> />
              <?php echo __('Show', $linuxProPlg_domain); ?>
              </option>
              <option value="false" <?php if ( $opt['windows'] == 'false' ) echo 'selected="selected"'; ?> />
              <?php echo __('Hide', $linuxProPlg_domain); ?>
              </option>
            </select></td>
          <td>Enabled Linux promotional message to all Windows users that visit your site.</td>
        </tr>
        <tr>
          <td width="125">Mac</td>
          <td width="125"><select name="macEnabled">
              <option value="true" <?php if ( $opt['mac'] == 'true' ) echo 'selected="selected"'; ?> />
              <?php echo __('Show', $linuxProPlg_domain); ?>
              </option>
              <option value="false" <?php if ( $opt['mac'] == 'false' ) echo 'selected="selected"'; ?> />
              <?php echo __('Hide', $linuxProPlg_domain); ?>
              </option>
            </select></td>
          <td>Enabled Linux promotional message to all Mac users that visit your site.</td>
        </tr>
        <thead>
          <tr>
            <th width="125"><?php echo __('Linux Distros', $linuxProPlg_domain); ?></th>
            <th width="125">&nbsp;</th>
            <th><?php echo __('URL', $linuxProPlg_domain); ?></th>
          </tr>
        </thead>
        <tr>
          <td width="125">Ubuntu</td>
          <td width="125"><select name="ubuntuEnabled">
              <option value="true" <?php if ( $opt['distros']['ubuntu'] == 'true' ) echo 'selected="selected"'; ?> />
              <?php echo __('Show', $linuxProPlg_domain); ?>
              </option>
              <option value="false" <?php if ( $opt['distros']['ubuntu'] == 'false' ) echo 'selected="selected"'; ?> />
              <?php echo __('Hide', $linuxProPlg_domain); ?>
              </option>
            </select></td>
          <td><input type="text" name="ubuntuURL" class="widefat ubuntu" value="<?php echo $opt['distrourl']['ubuntu']; ?>" /></td>
        </tr>
        <tr>
          <td width="125">CentOS</td>
          <td width="125"><select name="centosEnabled">
              <option value="true" <?php if ( $opt['distros']['centos'] == 'true' ) echo 'selected="selected"'; ?> />
              <?php echo __('Show', $linuxProPlg_domain); ?>
              </option>
              <option value="false" <?php if ( $opt['distros']['centos'] == 'false' ) echo 'selected="selected"'; ?> />
              <?php echo __('Hide', $linuxProPlg_domain); ?>
              </option>
            </select></td>
          <td><input type="text" name="centosURL" class="widefat centos" value="<?php echo $opt['distrourl']['centos']; ?>" /></td>
        </tr>
	<tr>
          <td width="125">Linux Mint</td>
          <td width="125"><select name="linuxMintEnabled">
              <option value="true" <?php if ( $opt['distros']['linuxMint'] == 'true' ) echo 'selected="selected"'; ?> />
              <?php echo __('Show', $linuxProPlg_domain); ?>
              </option>
              <option value="false" <?php if ( $opt['distros']['linuxMint'] == 'false' ) echo 'selected="selected"'; ?> />
              <?php echo __('Hide', $linuxProPlg_domain); ?>
              </option>
            </select></td>
          <td><input type="text" name="linuxMintURL" class="widefat linuxMint" value="<?php echo $opt['distrourl']['linuxMint']; ?>" /></td>
        </tr>
	<tr>
          <td width="125">Fedora</td>
          <td width="125"><select name="fedoraEnabled">
              <option value="true" <?php if ( $opt['distros']['fedora'] == 'true' ) echo 'selected="selected"'; ?> />
              <?php echo __('Show', $linuxProPlg_domain); ?>
              </option>
              <option value="false" <?php if ( $opt['distros']['fedora'] == 'false' ) echo 'selected="selected"'; ?> />
              <?php echo __('Hide', $linuxProPlg_domain); ?>
              </option>
            </select></td>
          <td><input type="text" name="fedoraURL" class="widefat fedora" value="<?php echo $opt['distrourl']['fedora']; ?>" /></td>
        </tr>
      </table>
    </div>
    <div id="tabs-2"><br/>
      <table width="100%" cellspacing="0" id="inactive-plugins-table" class="widefat">
        <thead>
          <tr>
            <th width="125"><?php echo __('Field', $linuxProPlg_domain); ?></th>
            <th><?php echo __('Text', $linuxProPlg_domain); ?></th>
          </tr>
        </thead>
        <tr>
          <td width="125"><?php echo __('Title', $linuxProPlg_domain); ?></td>
          <td><input type="text" name="ie6w_t1" class="widefat" value="<?php echo stripslashes(htmlspecialchars($opt['texts']['t1'])); ?>" /></td>
        </tr>
        <tr>
          <td width="125"><?php echo __('Text', $linuxProPlg_domain); ?></td>
          <td><textarea name="ie6w_t2" rows="5" class="widefat"><?php echo stripslashes(htmlspecialchars($opt['texts']['t2'])); ?></textarea></td>
        </tr>
		<tr>
          <td width="125"><?php echo __('Center Promotion Bold Text', $linuxProPlg_domain); ?></td>
          <td><textarea name="ie6w_t3" rows="5" class="widefat"><?php echo stripslashes(htmlspecialchars($opt['texts']['t3'])); ?></textarea></td>
        </tr>
      </table>
    </div>
    <div id="tabs-3">
      <h3><?php echo __('Debug Mode', $linuxProPlg_domain); ?></h3>
      <table width="100%" cellspacing="0" id="inactive-plugins-table" class="widefat">
        <thead>
          <tr>
            <th width="125"><?php echo __('Settings', $linuxProPlg_domain); ?></th>
            <th width="125">&nbsp;</th>
            <th><?php echo __('Description', $linuxProPlg_domain); ?></th>
          </tr>
        </thead>
        <tr>
          <td width="125"><?php echo __('Head Comment', $linuxProPlg_domain); ?></td>
          <td width="125"><select name="ie6w_headcomm">
              <option value="false" <?php if ( $opt['headcomm'] == 'false' ) echo 'selected="selected"'; ?> />
              <?php echo __('Off', $linuxProPlg_domain); ?>
              </option>
              <option value="true" <?php if ( $opt['headcomm'] == 'true' ) echo 'selected="selected"'; ?> />
              <?php echo __('On', $linuxProPlg_domain); ?>
              </option>
            </select></td>
          <td><?php echo __('This mode will put a comment in the <code>head</code> of your blog with info about the setting of the plugin.', $linuxProPlg_domain); ?></td>
        </tr>
        <tr>
          <td width="125"><?php echo __('JavaScript Test', $linuxProPlg_domain); ?></td>
          <td width="125"><select name="ie6w_jstest">
              <option value="false" <?php if ( $opt['jstest'] == 'false' ) echo 'selected="selected"'; ?> />
              <?php echo __('Off', $linuxProPlg_domain); ?>
              </option>
              <option value="true" <?php if ( $opt['jstest'] == 'true' ) echo 'selected="selected"'; ?> />
              <?php echo __('On', $linuxProPlg_domain); ?>
              </option>
            </select></td>
          <td><?php echo __('Make the warning JavaScript pop up two alerts, one in the begin and other in the end of the script, this way you can know if the script is correctly loaded. For security this function only work with <strong>Test Mode</strong> activated.', $linuxProPlg_domain); ?></td>
        </tr>
      </table>
      <h3><?php echo __('Cleanup Registry', $linuxProPlg_domain); ?></h3>
      <p>
        <input type="submit" name="delete_options" style="margin-left:12px;" class="button-secondary" value="<?php echo __('Delete Options', $linuxProPlg_domain); ?>" />
      </p>
      <p><?php echo __('This option will remove any <strong>Linux Promotional Plugin</strong> from the Wordpress database, use it for clean uninstall. If you want to use it again deactivate and activate it or press the Reset Options button.', $linuxProPlg_domain); ?></p>
    </div>
    </div>
    <div id="tabs-4"><br />
      <table width="100%" cellspacing="0" id="inactive-plugins-table" class="widefat">
        <thead>
          <tr>
            <th width="125"><?php echo __('Field', $linuxProPlg_domain); ?></th>
            <th><?php echo __('Value', $linuxProPlg_domain); ?></th>
          </tr>
        </thead>
        <tr>
          <td width="125">name</td>
          <td><?php echo $opt['name'] ?></td>
        </tr>
        <tr>
        <tr>
          <td width="125">version</td>
          <td><?php echo $opt['version'] ?></td>
        </tr>
        <tr>
          <td width="125">site</td>
          <td><?php echo $opt['site'] ?></td>
        </tr>
        <tr>
        <tr>
          <td width="125">type</td>
          <td><?php echo $opt['type'] ?></td>
        </tr>
        <tr>
          <td width="125">test</td>
          <td><?php echo $opt['test'] ?></td>
        </tr>
        <tr>
          <td width="125">headcomm</td>
          <td><?php echo $opt['headcomm'] ?></td>
        </tr>
        <tr>
          <td width="125">jstest</td>
          <td><?php echo $opt['jstest'] ?></td>
        </tr>
        <thead>
          <tr>
            <th width="125">texts</th>
            <th><?php echo __('Value', $linuxProPlg_domain); ?></th>
          </tr>
        </thead>
        <tr>
          <td width="125">t1</td>
          <td><?php echo $opt['texts']['t1'] ?></td>
        </tr>
        <tr>
          <td width="125">t2</td>
          <td><?php echo $opt['texts']['t2'] ?></td>
        </tr>
		<tr>
          <td width="125">t3</td>
          <td><?php echo $opt['texts']['t3'] ?></td>
        </tr>
        <thead>
          <tr>
            <th width="125">distros</th>
            <th><?php echo __('Value', $linuxProPlg_domain); ?></th>
          </tr>
        </thead>
        <tr>
          <td width="125">ubuntu</td>
          <td><?php echo $opt['distros']['ubuntu'] ?></td>
        </tr>
        <tr>
          <td width="125">centos</td>
          <td><?php echo $opt['distros']['centos'] ?></td>
        </tr>
	<tr>
          <td width="125">linuxMint</td>
          <td><?php echo $opt['distros']['linuxMint'] ?></td>
        </tr>
	<tr>
          <td width="125">fedora</td>
          <td><?php echo $opt['distros']['fedora'] ?></td>
        </tr>
        <thead>
          <tr>
            <th width="125">distrourl</th>
            <th><?php echo __('Value', $linuxProPlg_domain); ?></th>
          </tr>
        </thead>
        <tr>
          <td width="125">ubuntu</td>
          <td><?php echo $opt['distrourl']['ubuntu'] ?></td>
        </tr>
        <tr>
          <td width="125">centos</td>
          <td><?php echo $opt['distrourl']['centos'] ?></td>
        </tr>
	<tr>
          <td width="125">linuxMint</td>
          <td><?php echo $opt['distrourl']['linuxMint'] ?></td>
        </tr>
	<tr>
          <td width="125">fedora</td>
          <td><?php echo $opt['distrourl']['fedora'] ?></td>
        </tr>
      </table>
    </div>
    <p class="submit">
      <input type="submit" name="update_options" class="button-primary" value="<?php echo __('Save Changes', $linuxProPlg_domain); ?>" />
      <input type="submit" name="reset_options" value="<?php echo __('Reset Options', $linuxProPlg_domain); ?>" />
    </p>
  </form>
  <hr />
  <p><?php echo __('<strong>Note</strong>: If you have any ideas or suggestion for improvements to this plugin please contact me.', $linuxProPlg_domain); ?></p>
  <p><?php echo '<a href="' . $opt['site'] . '">' . $opt['name'] . ' v' . $opt['version'] . '</a> ' . __('by', $linuxProPlg_domain) . ' <a href="mailto:tim@itsqueeze.com">Timothy Arceri</a> ' . __('at', $linuxProPlg_domain) . ' <a href="http://www.itsqueeze.com/" target="_blank">itsqueeze.com</a>'; ?></p>
</div>
<?php }
?>
