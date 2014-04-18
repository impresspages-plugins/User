<?php
namespace Plugin\User;


class Model{

    static $lastError;

    public static function get($id)
    {
        return ipDb()->selectRow('user', '*', array('id' => $id));
    }

    public static function getAll()
    {
        return ipDb()->selectAll('user', '*', array(), 'ORDER BY `id` ASC');
    }

    public static function delete($id)
    {
        ipDb()->delete('user', array('id' => $id));
    }

    public static function getByUsername($username)
    {
        return ipDb()->selectRow('user', '*', array('username' => $username));
    }

    public static function getByEmail($email)
    {
        return ipDb()->selectRow('user', '*', array('email' => $email));
    }

    public static function addUser($username, $email, $password)
    {
        $data = array(
            'username' => $username,
            'email' => $email,
            'hash' => self::passwordHash($password)
        );
        return ipDb()->insert('user', $data);
    }

    public static function sendResetPasswordLink($userId)
    {
        $user = self::get($userId);
        if (!$user) {
            throw new \Ip\Exception("User doesn't exist");
        }

        $urlData = array(
            'userId' => $userId,
            'secret' => self::generatePasswordResetSecret($userId)
        );

        $contentData = array (
            'link' => ipRouteUrl('User_passwordReset2', $urlData)
        );

        $content = ipView('view/passwordResetEmail.php', $contentData)->render();

        $emailData = array (
            'content' => $content
        );

        $email = ipEmailTemplate($emailData);

        $from = ipGetOption('Config.websiteEmail');
        $fromName = ipGetOption('Config.websiteTitle');
        $subject = __('Password reset instructions', 'User', false);
        $to = $user['email'];
        $toName = $user['username'];
        ipSendEmail($from, $fromName, $to, $toName, $subject, $email);

    }


    public static function setUserPassword($userId, $password)
    {
        ipDb()->update('user', array('hash' => self::passwordHash($password)), array('id' => $userId));
    }

    public static function update($userId, $data)
    {
        $data = array_intersect($data, array('username', 'email'));

        if (isset($data['password'])) {
            $data['hash'] = self::passwordHash($data['password']);
            unset($data['password']);
        }
        ipDb()->update('user', $data, array('id' => $userId));
    }


    public static function validPasswordResetSecret($userId, $secret)
    {
        $user = self::get($userId);
        if (!$user) {
            self::$lastError = __('User doesn\'t exist', 'User', false);
            return false;
        }

        if (empty($user['resetSecret']) || $user['resetTime'] < time() - ipGetOption('Config.passwordResetLinkExpire', 60 * 60 * 24)) {
            self::$lastError = __('Password reset link has expired', 'User', false);
            return false;
        }

        if ($user['resetSecret'] != $secret) {
            self::$lastError = __('Invalid password reset link', 'User', false);
            return false;
        }

        return true;
    }

    private static function generatePasswordResetSecret($userId)
    {
        $secret = md5(ipConfig()->get('sessionName') . uniqid());
        $data = array(
            'resetSecret' => $secret,
            'resetTime' => time()
        );
        ipDb()->update('user', $data, array('id' => $userId));
        return $secret;
    }

    public static function removePasswordResetSecret($userId)
    {
        $data = array(
            'resetSecret' => '',
            'resetTime' => 0
        );
        ipDb()->update('user', $data, array('id' => $userId));
    }

    public static function checkPassword($userId, $password)
    {
        $user = self::get($userId);
        return self::checkHash($password, $user['hash']);
    }

    private static function passwordHash($password)
    {
        $stretching = ipGetOption('User.passwordStretchingIterations', 8);
        $hasher = new PasswordHash($stretching, FALSE);
        return $hasher->HashPassword($password);
    }

    private static function checkHash($password, $storedHash)
    {
        $hasher = new PasswordHash(8, FALSE);
        $hasher->CheckPassword($password, $storedHash);
        return $hasher->CheckPassword($password, $storedHash);
    }

    public static function setRedirectAfterLogin($url)
    {
        ipStorage()->set('User', 'redirectAfterLogin', $url);
    }

    public static function getRedirectAfterLogin($url)
    {
        ipStorage()->get('User', 'redirectAfterLogin');
    }

    public static function removeRedirectAfterLogin()
    {
        ipStorage()->remove('User', 'redirectAfterLogin');
    }

    public static function loginUrl()
    {
        $loginPage = ipContent()->getPage('User_login');
        if (!$loginPage) {
            return '';
        }
        return $loginPage->getLink();
    }

    public static function getError()
    {
        return self::$lastError;
    }
}
