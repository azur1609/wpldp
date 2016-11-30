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
		function wpldp_set_headers()
		{
			header('Content-Type:"application/ld+json"', true);
			header('Access-Control-Allow-Origin:"*"', true);
		}
		
		// returns context to be set for posts/post_details/view_comments/post_comment etc.
		// see : http://json-ld.org/spec/latest/json-ld/#the-context
		function wpldp_set_context()
		{
			return array("dcterms" => "http://purl.org/dc/terms",
			"foaf" => "http://xmlns.com/foaf/0.1",
			"owl" => "http://www.w3.org/2002/07/owl#",
			"rdf" =>"http://www.w3.org/1999/02/22-rdf-syntax-ns#",
			"rdfs" => "http://www.w3.org/2000/01/rdf-schema#",
			"sioc" => "http://rdfs.org/sioc/ns#",
			"vs" => "http://www.w3.org/2003/06/sw-vocab-status/ns#",
			"wot" => "http://xmlns.com/wot/0.1",
			"xsd" => "http://www.w3.org/2001/XMLSchema#");
		}
		
		// returns post_id (or null if it doesn't exist) by slug
		function wpldp_get_postid_by_slug($slug)
		{
			
			$post = get_page_by_path($slug, OBJECT, 'post');
			
			if ($post)
			{
				return $post->ID;
			}
			
			else
			{
				return null;
			}
			
}
    }

}

?>
