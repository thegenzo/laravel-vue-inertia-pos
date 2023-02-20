<?php

if(!function_exists('Rupiah')) {
    function Rupiah($str) {
        return 'Rp. '. number_format($str, '0', ''. '.');
    }
}