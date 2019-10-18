<?php
include '../lib/bootstrap.php';

$action_files = Tracking::action_files();
$action_files_amount = count($action_files);

if (isset($_GET['work'])) {
    $user_data = array();
    $website_data = array();
    foreach ($action_files as $action_file) {
        $actions = _zip_read($action_file);
        foreach ($actions as $action) {
            $domain_rootdomain = Request::_domain($action['url']);
            $action['domain'] = $domain_rootdomain[0];
            $action['rootdomain'] = $domain_rootdomain[1];
            //
            if (!isset($website_data[$action['rootdomain']])) {
                $website_data[$action['rootdomain']] = array();
            }
            array_push($website_data[$action['rootdomain']], $action);
            //
            if (!isset($user_data[$action['userid']])) {
                $user_data[$action['userid']] = array();
            }
            array_push($user_data[$action['userid']], $action);
        }
    }
    //
    foreach ($website_data as $website_domain => $data) {
        Tracking::create_track('websites', $website_domain, $data);
    }
    foreach ($user_data as $user_id => $data) {
        Tracking::create_track('users', $user_id, $data);
    }
    foreach ($action_files as $action_file) {
        unlink($action_file);
    }
}
?>
<h1>Admin / Actions</h1>
<h2>Currently <?= $action_files_amount ?> open action-files</h2>
<a href="actions.php?work"><button>Work open Actions</button></a>