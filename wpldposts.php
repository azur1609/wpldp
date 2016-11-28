<?php
/*
 * Plugin Name: WpLdp
 * Plugin URI: https://mizar.ursa.wares.fr/wordpress/
 * Description: This is a plugin which aims to emulate the default caracteristics of a Linked Data Platform compatible server
 * Version: 0
 * License: GPL2
 */
 
// TODO : repartir sur plusieurs fichiers ? => includes.php

namespace wpldp;
 
// If the file is accessed outside of index.php (ie. directly), we just deny the access
defined('ABSPATH') or die("No script kiddies please!");

require_once('includes.php');

class wpldp
{
	
	/* default constructor */
    public function __construct()
    {
		/* calls a function to register routes at the Rest API initialisation */
        add_action('rest_api_init', array($this, 'wpldp_register_routes')) ;
		
        include_once plugin_dir_path( __FILE__ ).'/includes.php';
		new wpldp_includes();
		
    }
    

	/* Registers custom routes (comments for each route are listed above)
	 * 
	 * E.g : "yoursite.com/wordpress/wp-json/ldp/custom/" where
	 * 
	 * "yoursite.com/wordpress" is the main url
	 * "/wp-json/ is the default route for requests to the embedded WP rest api
	 * "/ldp" is the first URL segment after core prefix. Must be unique to our plugin
	 * "/custom" is the route to some function */ 
	
	/*
	$the_slug = 'my_slug';
$args = array(
  'name'        => $the_slug,
  'post_type'   => 'post',
  'post_status' => 'publish',
  'numberposts' => 1
);
$my_post = get_posts($args)[0];
***************************

if( $my_posts ) :
  echo 'ID on the first post found ' . $my_post->ID
	
	$comments = get_comments('post_id=15'); //  get_comments('post_name='.$the_slug)
foreach($comments as $comment) :
	echo($comment->comment_author);
endforeach;
****************************************************************
*
* 
$time = current_time('mysql');

$data = array(
    'comment_post_ID' => 1,
    'comment_author' => 'admin',
    'comment_author_email' => 'admin@admin.com',
    'comment_author_url' => 'http://',
    'comment_content' => 'content here',
    'comment_type' => '',
    'comment_parent' => 0,
    'user_id' => 1,
    'comment_author_IP' => '127.0.0.1',
    'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
    'comment_date' => $time,
    'comment_approved' => 1,
);

wp_insert_comment($data);

$data->get_body()

* */
	
	
    public function wpldp_register_routes()
    {

		/* Registers a route for listing posts */
		register_rest_route( 'ldp', '/posts/', array(
		'methods' => 'GET',
		'callback' => array($this, 'wpldp_list_posts') ));
		
		/* Registers a route for fonction test 1*/
		register_rest_route( 'ldp', '/posts/(?P<slug>[a-zA-Z0-9-]+)', array(
		'methods' => 'GET',
		'callback' => array($this, 'wpldp_detail_post') ));
		
		/* Registers a route for fonction test 2*/
		register_rest_route( 'ldp', '/toto2/', array(
		'methods' => 'GET',
		'callback' => array($this, 'wpldp_toto2') ));
		
		/* Registers a route for fonction test 3*/
		register_rest_route( 'ldp', '/toto3/', array(
		'methods' => 'GET',
		'callback' => array($this, 'wpldp_toto3') ));
		
		/* Registers a route for fonction test 4*/
		register_rest_route( 'ldp', '/toto4/', array(
		'methods' => 'GET',
		'callback' => array($this, 'wpldp_toto4') ));
		
	}
	
	
	/* Returns all posts (in jdson-ld format ?) */
	 
	public function wpldp_list_posts()
	{	 
		
		// sets headers
		header('Access-Control-Allow-Origin:"*"', true);
		
		// lists all posts in array
		$tabPosts = get_posts();
		
		for ($cpt = 0; $cpt < count($tabPosts) ; $cpt++)
			{
				$posts[$cpt] = array(
				'rdfs:label'=>$tabPosts[$cpt]-> post_name,
				'dc:title'=>$tabPosts[$cpt]-> post_title,
				'dcterms:created'=>$tabPosts[$cpt]-> post_date,
				'sioc:User'=>$tabPosts[$cpt]-> post_author) ;
			}
		
		// initializes the "context" in array
		// see : http://json-ld.org/spec/latest/json-ld/#the-context
		$context = array("dcterms" => "http://purl.org/dc/terms",
		"foaf" => "http://xmlns.com/foaf/0.1",
		"owl" => "http://www.w3.org/2002/07/owl#",
		"rdf" =>"http://www.w3.org/1999/02/22-rdf-syntax-ns#",
		"rdfs" => "http://www.w3.org/2000/01/rdf-schema#",
		"sioc" => "http://rdfs.org/sioc/ns#",
		"vs" => "http://www.w3.org/2003/06/sw-vocab-status/ns#",
		"wot" => "http://xmlns.com/wot/0.1",
		"xsd" => "http://www.w3.org/2001/XMLSchema#");
		
		// initializes graph array, then stores posts inside the array
		$graph = array("@id" => "http://ldp.happy-dev.fr/ldp/posts/",
				"@type" => "http://www.w3.org/ns/ldp#BasicContainer",
				"http://www.w3.org/ns/ldp#contains" => $posts);
		
		$retour = array('@context' => $context, '@graph' => $graph);
		
		return rest_ensure_response($retour);
	}

	// fonction test 1
	public function wpldp_detail_post($data)
	{
		echo $data['slug'];
		die();
	}

	
	public function wpldp_toto2()
	{
		// initialize headers
		header('Content-Type: "application/ld+json"', true);
		header('Access-Control-Allow-Origin:"*"', true);
		
		// stores all posts in array
		$tabPosts = get_posts();
		
		
		// generates the "context"
		// see : http://json-ld.org/spec/latest/json-ld/#the-context
		echo '"@context": 	{
		"dcterms": "http://purl.org/dc/terms",
		"foaf": "http://xmlns.com/foaf/0.1",
		"owl": "http://www.w3.org/2002/07/owl#",
		"rdf": "http://www.w3.org/1999/02/22-rdf-syntax-ns#",
		"rdfs": "http://www.w3.org/2000/01/rdf-schema#",
		"sioc": "http://rdfs.org/sioc/ns#",
		"vs": "http://www.w3.org/2003/06/sw-vocab-status/ns#",
		"wot": "http://xmlns.com/wot/0.1",
		"xsd": "http://www.w3.org/2001/XMLSchema#"
				},

		';

		// generates the "graph" (a basic container for posts) tag
		echo '"@graph":	';
    
		// opening brackets for "@graph"
		echo '{
		
		';
		
			// generates <todo: commentaire a clarifier /> for containers
			echo '		"@id" : "http://ldp.happy-dev.fr/ldp/posts/",
				"@type" : "http://www.w3.org/ns/ldp#BasicContainer",
				"http://www.w3.org/ns/ldp#contains" :
				
				';
		
				// then, extracts post titles, add them one by one in the json-ld response
				// a virer : echo '{"posts" : [';
				
				// opening bracket for posts
				echo '	[';
				echo "\n";
				
				for ($cpt = 0; $cpt < count($tabPosts) ; $cpt++)
				{
					$retour[$cpt] = array(
					'rdfs:label'=>$tabPosts[$cpt]-> post_name,
					'dc:title'=>$tabPosts[$cpt]-> post_title,
					'dcterms:creat	ed'=>$tabPosts[$cpt]-> post_date,
					'sioc:User'=>$tabPosts[$cpt]-> post_author) ;
					echo json_encode($retour[$cpt]);
					echo ','; // adds a comma to separate posts
				}
			
				// closes brackets for posts
				echo '
					]
				';
		
		// closes brackets for "@graph"
		echo '
				}
		';
		
		// closes brackets for json-ld
		echo "\n";
		echo '}';
		
		if (isset($_GET['filter'])) {echo 'Filtre : ' . $_GET['filter'];}
		
		// using die() to avoid using "return $retour", which adds slashs and doublequotes to the json
		die();
		
	}
	
	// fonction test 3
	public function wpldp_toto3()
	{
		
		// lists all posts in array
		$tabPosts = get_posts();
		
		for ($cpt = 0; $cpt < count($tabPosts) ; $cpt++)
			{
				$posts[$cpt] = array(
				'rdfs:label'=>$tabPosts[$cpt]-> post_name,
				'dc:title'=>$tabPosts[$cpt]-> post_title,
				'dcterms:creat	ed'=>$tabPosts[$cpt]-> post_date,
				'sioc:User'=>$tabPosts[$cpt]-> post_author) ;
			}
		
		
		// initialize the "context" in array
		// see : http://json-ld.org/spec/latest/json-ld/#the-context
		$context = array("dcterms" => "http://purl.org/dc/terms",
		"foaf" => "http://xmlns.com/foaf/0.1",
		"owl" => "http://www.w3.org/2002/07/owl#",
		"rdf" =>"http://www.w3.org/1999/02/22-rdf-syntax-ns#",
		"rdfs" => "http://www.w3.org/2000/01/rdf-schema#",
		"sioc" => "http://rdfs.org/sioc/ns#",
		"vs" => "http://www.w3.org/2003/06/sw-vocab-status/ns#",
		"wot" => "http://xmlns.com/wot/0.1",
		"xsd" => "http://www.w3.org/2001/XMLSchema#");
		
		// initialize graph array, then stores posts inside the array
		$graph = array("@id" => "http://ldp.happy-dev.fr/ldp/posts/",
				"@type" => "http://www.w3.org/ns/ldp#BasicContainer",
				"http://www.w3.org/ns/ldp#contains" => $posts);
		
	
		$retour = array('@context' => $context, '@graph' => $graph);
		
		
		return rest_ensure_response($retour);

	}
	
	// fonction test 4
	public function wpldp_toto4()
	{
		
		// lists all posts in array
		$posts = get_posts();
		
		// initialize the "context" in array
		// see : http://json-ld.org/spec/latest/json-ld/#the-context
		$context = array("dcterms" => "http://purl.org/dc/terms",
		"foaf" => "http://xmlns.com/foaf/0.1",
		"owl" => "http://www.w3.org/2002/07/owl#",
		"rdf" =>"http://www.w3.org/1999/02/22-rdf-syntax-ns#",
		"rdfs" => "http://www.w3.org/2000/01/rdf-schema#",
		"sioc" => "http://rdfs.org/sioc/ns#",
		"vs" => "http://www.w3.org/2003/06/sw-vocab-status/ns#",
		"wot" => "http://xmlns.com/wot/0.1",
		"xsd" => "http://www.w3.org/2001/XMLSchema#");
		
		// initialize graph array, then stores posts inside the array
		$graph = array("@id" => "http://ldp.happy-dev.fr/ldp/posts/",
				"@type" => "http://www.w3.org/ns/ldp#BasicContainer",
				"http://www.w3.org/ns/ldp#contains" => $posts);
		
		$retour = array('@context' => $context, '@graph' => $graph);
		
		
		return rest_ensure_response($retour);

	}

}

new wpldp();

?>
