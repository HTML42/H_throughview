<?php

//this file will be executed after Xtreme and App init()
//###JSON-DB
$XDB = new XDB('jsondb');

$XDB->add_tables(array(
    'users' => array(
        'username' => '',
        'password' => '',
        'hash' => function($data) {
            $email = (isset($data['email']) ? $data['email'] : 'no-email');
            return strtoupper(md5($data['id'] . '||' . $email));
        },
        'email' => '',
        'email_validated' => null,
    ),
    'user_groups' => array('user_id' => '', 'name' => ''),
));

$XDB->add_validations(array(
    'users' => array(
        'groups' => array('id' => array('user_groups', 'user_id')),
    ),
));

$XDB->init();



//###X-Login
Xlogin::$config['db']['system'] = 'xjsondb';

#Start Database
$GLOBALS['XLDB'] = new Xlogin_DB();

#Create Current User
$GLOBALS['me'] = $me = Xuser::load(X_LOGIN_ID);
define('IS_ADMIN', $GLOBALS['me']->groups('admin'));

Xlogin::$config['signup']['callback'] = function($userid) {
    $User = Xuser::load($userid);
    @Emails::create('confirmation', $User);
};
Xlogin::$config['confirmation']['callback'] = function($userid) {
    $group_active = Xjsondb::select('user_groups', array(
                'user_id' => $userid,
                'name' => 'active'
    ));
    if (empty($group_active)) {
        Xjsondb::insert('user_groups', array(
            'user_id' => $userid,
            'name' => 'active',
        ));
    }
};
//##Texts
Xlogin::$config['confirmation']['response_success'] = 'E-Mail erfolgreich bestätigt.';
Xlogin::$config['confirmation']['response_error'] = 'E-Mail-Bestätigung fehlgeschlagen.';
Xlogin::$config['confirmation']['redirect_text'] = 'Sie werden weitergeleitet in 5 Sekunden...';
//##CSS-Classes
#Xlogin::$config['login']['form_css_class'] = 'standard_form';
#Xlogin::$config['signup']['form_css_class'] = 'standard_form';

//Tinypng
TinyPng::$api_key = 'biozpeZLIExCfyai9UWcKgXnX0v0JmfO';
