<?php
namespace Bageur\Auth\Processors;

class AvatarProcessor {

    public static function get( $name, $image = null, $folder = "bageur", $type = "initials") {
        if (empty($image)) {
            if (!empty($name)) {
                return 'https://avatars.dicebear.com/v2/'.$type.'/' . preg_replace('/[^a-z0-9 _.-]+/i', '', $name) . '.svg';
            }
            return null;
        }
        return url('auth/'.$image);
    }
}
