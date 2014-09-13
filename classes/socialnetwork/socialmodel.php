<?php
/**
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class SocialModel
{
    /**
    * Polymorphic - accepts a variable number of arguments dependent
    * on the type of the model subclass.
    */
    public function __construct()
    {
        if (func_num_args() == 1 && is_array(func_get_arg(0))) {
            // Initialize the model with the array's contents.
            $array = func_get_arg(0);
            $this->mapTypes($array);
        }
    }

    /**
     * Initialize this object's properties from an array.
     *
     * @param array $array Used to seed this object's properties.
     * @return void
     */
    protected function mapTypes($array)
    {
        // Hard initilise simple types, lazy load more complex ones.
        foreach ($array as $key => $val) {
            if (property_exists($this, $key)) {
                if (in_array($key, array('url', 'urls'))) {
                    $this->$key = rawurlencode($val);
                } else {
                    $this->$key = $val;
                }
                unset($array[$key]);
            }
        }
        $this->model = $array;
    }
}
