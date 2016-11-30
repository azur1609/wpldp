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
		
		// test function
		function wpldp_inc_test()
		{
			return 'Test includes';	
		}
		
		// returns post_id (or null if it doesn't exist) by slug
		function wpldp_get_id_by_slug($slug)
		{
			
			$page = get_page_by_path($slug);
			
			if ($page)
			{
				return $page->ID;
			}
			
			else
			{
				return null;
			}
}
    }

}

?>
