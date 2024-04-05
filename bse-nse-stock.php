<?php
/*
Plugin Name: Nava BSE and NSE Stock Value Display Plugin
Description: Fetch and display live stock values from BSE and NSE using shortcodes.
Version: 1.0
Author: Your Name
*/

function get_bse_stock_values() {
    $bse_result = file_get_contents("https://query1.finance.yahoo.com/v6/finance/options/NAVA.BO");
    $bse_convert = json_decode(str_replace("//", "", $bse_result));

    $live_value = $bse_convert->optionChain->result[0]->quote->regularMarketPrice;
    $change_value = (float) $bse_convert->optionChain->result[0]->quote->regularMarketChange;
    $change_symbol = ($change_value >= 0) ? '+' : '-';
    $change_arrow = ($change_value >= 0) ? '<span class="up-arrow"><img src="https://nava.webindia.com/wp-content/uploads/2024/01/Group-642.png" alt="Up Arrow"></span>' : '<span class="down-arrow"><img src="https://nava.webindia.com/wp-content/uploads/2023/12/Group-641.png" alt="Down Arrow"></span>';
    
    // Adding classes based on value being up or down
    $change_value_class = ($change_value >= 0) ? 'up' : 'down';

    $change_value_formatted = number_format(abs($change_value), 2, '.', '');

    return "<div id='bse'><span class='live-value $change_value_class'>$live_value</span><span class='arrow'> $change_arrow</span> <span class='change-value $change_value_class'><span class='change-symbol'>$change_symbol</span>$change_value_formatted</span></div>";
}

function get_nse_stock_values() {
    $nse_result = file_get_contents("https://query1.finance.yahoo.com/v6/finance/options/NAVA.NS");
    $nse_convert = json_decode(str_replace("//", "", $nse_result));

    $live_value = $nse_convert->optionChain->result[0]->quote->regularMarketPrice;
    $change_value = (float) $nse_convert->optionChain->result[0]->quote->regularMarketChange;
    $change_symbol = ($change_value >= 0) ? '+' : '-';
    $change_arrow = ($change_value >= 0) ? '<img src="https://nava.webindia.com/wp-content/uploads/2024/01/Group-642.png" alt="Up Arrow">' : '<img src="https://nava.webindia.com/wp-content/uploads/2023/12/Group-641.png" alt="Down Arrow">';
    
    // Adding classes based on value being up or down
    $change_value_class = ($change_value >= 0) ? 'up' : 'down';

    $change_value_formatted = number_format(abs($change_value), 2, '.', '');

    return "<div id='nse'><span class='live-value'>$live_value</span><span class='arrow'> $change_arrow</span> <span class='change-value $change_value_class'><span class='change-symbol'>$change_symbol</span>$change_value_formatted</span></div>";
}

function bse_stock_display_shortcode() {
    return get_bse_stock_values();
}

function nse_stock_display_shortcode() {
    return get_nse_stock_values();
}

add_shortcode('bse_stock_display', 'bse_stock_display_shortcode');
add_shortcode('nse_stock_display', 'nse_stock_display_shortcode');
?>
