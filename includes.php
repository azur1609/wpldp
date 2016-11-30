<?php
/*
 * Tests includes
 */
namespace wpldp;

class wpldp_includes

{

    public function __construct()
    {
		
		// sets headers
		function wpldp_setheaders()
		{
			header('Content-Type:"application/ld+json"', true);
			header('Access-Control-Allow-Origin:"*"', true);
		}
		
		function wpldp_inc_test()
		{
			return 'Test includes';	
		}
		
		
    }

}

?>
