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

<?php /* numbers of pings and comments */
$ping_count = $comment_count = 0;
foreach ( $comments as $comment )
	get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;
?>

	<?php if ( ! empty($comments_by_type['comment']) ) : ?>

			<h3 id="comments-title"><?php printf($comment_count > 1 ? __('%d commentaires', 'autofocus') : __('Un commentaire', 'autofocus'), $comment_count) ?></h3>

			<ol class="commentlist">
				<?php wp_list_comments( array( 'callback' => 'autofocus_comment', 'type' => 'comment' ) ); ?>
			</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Commentaires plus anciens', 'autofocus' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Commentaires plus récents <span class="meta-nav">&rarr;</span>', 'autofocus' ) ); ?></div>
			</div><!-- .navigation -->
		<?php endif; // check for comment navigation ?>

	<?php endif; /* if ( $comment_count ) */ ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( ! comments_open() ) :
?>
	<p class="nocomments"><?php _e( 'Les commentaires sont ferm&eacute;s.', 'autofocus' ); ?></p>
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<?php 

$af_comment_fields =  array(
	'comment_notes_before' => '<p class="comment-notes">' . __( 'Votre adresse mail ne sera pas publi&eacute;e.' ) . ( $req ? '<br>Les champs obligatoires sont marqu&eacute;s :<span class="required">*</span>' : '' ) . '</p>'
);

comment_form($af_comment_fields); ?>

</div><!-- #comments -->
