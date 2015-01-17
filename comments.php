<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.  The actual display of comments is
 * handled by a callback to autofocus_comment which is
 * located in the functions.php file.
 */
?>

<div id="comments">

<?php if ( have_comments() ) : ?>

<?php 
	$comment_count = get_comments_number();	
	if ( $comment_count > 1 && $comment_count < 21 ): 		
    $numberdic = array("Zéro", "Un", "Deux","Trois", "Quatre", "Cinq", "Six", "Sept", "Huit", "Neuf", "Dix", "Onze", "Douze", "Treize", "Quatorze", "Quinze", "Seize", "Dix-sept", "Dix-huit", "Dix-neuf", "Vingt");
    $comment_count = $numberdic[$comment_count]; 
?>
	
	<h3 id="comments-title"><?php printf(__('%s commentaires'), $comment_count) ?></h3>
	
<?php else: ?>
	
	<h3 id="comments-title"><?php printf($comment_count > 1 ? __('%d commentaires') : __('Un commentaire'), $comment_count) ?></h3>
	
<?php endif; ?>

	<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
				) );
			?>
		</ol><!-- .comment-list -->
			
<?php endif; // end have_comments() ?>


<?php if ( ! comments_open() ) :?>
	<p class="nocomments"><?php _e( 'Les commentaires sont ferm&eacute;s.', 'autofocus' ); ?></p>
<?php endif; // end ! comments_open() ?>


<?php 

$af_comment_fields =  array(
	'comment_notes_before' => '<p class="comment-notes">' . __( 'Votre adresse mail ne sera pas publi&eacute;e.' ) . ( $req ? '<br>Les champs obligatoires sont marqu&eacute;s :<span class="required">*</span>' : '' ) . '</p>'
);

comment_form($af_comment_fields); ?>

</div><!-- #comments -->
