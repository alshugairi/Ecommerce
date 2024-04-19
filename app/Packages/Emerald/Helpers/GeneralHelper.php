<?php

namespace App\Packages\Emerald\Helpers;


trait GeneralHelper
{
    /**
     * check Auth logged in or not
     *
     * @param string|null $url
     * @return bool
     */
    private function isURLFullScheme(?string $url = null): bool
    {
        $regex = "((https?|ftp)\:\/\/)?"; // SCHEME
        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass
        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP
        $regex .= "(\:[0-9]{2,5})?"; // Port
        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path
        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor

        if (preg_match("/^$regex$/i", $url)) // `i` flag for case-insensitive
        {
            return true;
        }
        return false;
    }

//    private function isURLFullScheme(string $url = null): bool
//    {
//        $url = "://api.createsend.com/api/v3.2/transactional/smartemail/247eb930-1c87-40c4-9cca-ce32918640ec/send";
//        dd(filter_var($url, FILTER_VALIDATE_URL)  === FALSE, $this->isURL1($url), $url);
//        return preg_match("/^$regex$/i", $url);
//    }
}
