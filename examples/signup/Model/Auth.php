<?php

namespace Examples\Signup\Model;

use Examples\Signup\Base;

class Auth extends Base
{
    public function findByProviderUid($provider, $provider_uid)
    {
        $sql = <<<SQL
SELECT *
FROM `:p_authentications`
WHERE `provider` = :provider AND `provider_uid` = :provider_uid
LIMIT 1
SQL;

        return self::$db->query($sql, compact('provider', 'provider_uid'))->fetchAssoc();
    }

    public function create(
        $user_id,
        $provider,
        $provider_uid,
        $email,
        $display_name,
        $first_name,
        $last_name,
        $profile_url,
        $website_url
    ) {
        $sql = <<<SQL
INSERT INTO
  `:p_authentications` (`user_id`, `provider`, `provider_uid`, `email`, `display_name`, `first_name`, 
  `last_name`, `profile_url`, `website_url`, `created_at`) VALUES
(:user_id, :provider, :provider_uid, :email, :display_name, :first_name,
 :last_name, :profile_url, :website_url, NOW() )
SQL;

        return self::$db->query(
            $sql,
            compact(
                'user_id',
                'provider',
                'provider_uid',
                'email',
                'display_name',
                'first_name',
                'last_name',
                'profile_url',
                'website_url'
            )
        )->insertId();
    }

    public function findByUserId($user_id)
    {
        $sql = "SELECT * FROM `:p_authentications` WHERE `user_id` = :user_id LIMIT 1";
        return self::$db->query($sql, compact('user_id'))->fetchAssoc();
    }
}
