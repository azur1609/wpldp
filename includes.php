<?php
/*
 * Tests includes
 */
namespace wpldp;

class wpldposts_includes

{

    public function __construct()

    {
		//echo 'Constructeur fichier : includes.php  classe : wpldposts_test';
    }

	public function wpldposts_getposts()
	{
		// A utiliser comme modele pour criteres de tri/filtres getpost()
		$data = get_posts( array(
			'post_type'      => 'candy',
			'post_status'    => 'publish',
			'posts_per_page' => 20,
		) );
		return $data;

	}

}

?>
